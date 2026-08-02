<?php

namespace App\Services;

use App\Models\ActivityLog;
use App\Models\ApprovalHistory;
use App\Models\Berita;
use App\Models\Event;
use App\Models\PengajuanSurat;
use App\Models\User;
use App\Models\VillageSetting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class DashboardService
{
    private const CACHE_TTL = 60;

    private const CACHE_PREFIX = 'dashboard_';

    public function __construct(
        private AnalyticsService $analytics,
    ) {}

    public function all(): array
    {
        $user = auth()->user();
        $role = $user?->roles()->first()?->name;
        $can = fn ($perm) => $user?->can($perm) ?? false;

        $permissions = [
            'letter.create' => $can('letter.create'),
            'letter.view' => $can('letter.view'),
            'letter.review' => $can('letter.review'),
            'letter.verify' => $can('letter.verify'),
            'letter.final_approve' => $can('letter.final_approve'),
            'letter.reject' => $can('letter.reject'),
            'news.manage' => $can('news.manage'),
            'event.manage' => $can('event.manage'),
            'user.create' => $can('user.create'),
            'user.view' => $can('user.view'),
            'analytics.view' => $can('analytics.view'),
            'queue.view' => $can('queue.view'),
            'queue.manage' => $can('queue.manage'),
            'setting.manage' => $can('setting.manage'),
            'audit.view' => $can('audit.view'),
        ];

        $isApprovalRole = in_array($role, ['Super Admin', 'Operator Pelayanan', 'Sekretaris Desa', 'Kepala Desa']);
        $isAdmin = $role !== 'Warga';
        $isSuperAdmin = $role === 'Super Admin';

        $data = [
            'stats' => $this->stats(),
            'workflow' => $this->workflowMonitor(),
            'activities' => $this->recentActivities(),
            'queue' => $this->queueStatus(),
            'systemHealth' => $this->systemHealth(),
            'village' => $this->villageInfo(),
            'notifications' => $this->notifications(),
            'userRole' => $role,
            'can' => $permissions,
        ];

        if ($isAdmin) {
            $data['trends'] = $this->analytics->getMonthlyTrends(12);
            $data['letterDistribution'] = $this->letterDistribution();
            $data['analyticsSummary'] = $this->analyticsSummary();
            $data['latestSubmissions'] = $this->latestSubmissions();
        }

        if ($isApprovalRole) {
            $data['approvals'] = $this->myApprovals();
        }

        if ($isSuperAdmin || $permissions['analytics.view']) {
            $data['topRtrw'] = $this->topRtrw();
            $data['operatorPerformance'] = array_slice($this->analytics->getOperatorPerformance(), 0, 5);
        }

        if ($permissions['event.manage']) {
            $data['events'] = $this->upcomingEvents();
            $data['calendarEvents'] = $this->calendarEvents();
        }

        return $data;
    }

    public function stats(): array
    {
        return Cache::remember(self::CACHE_PREFIX.'stats', self::CACHE_TTL, function () {
            $now = now();
            $lastMonth = now()->subMonth();
            $lastMonthStart = $lastMonth->startOfMonth();
            $thisMonthStart = $now->copy()->startOfMonth();

            $counts = PengajuanSurat::selectRaw('
                COUNT(*) as total,
                SUM(CASE WHEN status = "submitted" THEN 1 ELSE 0 END) as pending,
                SUM(CASE WHEN status IN ("submitted","verified","revision","approved_operator","approved_sekdes","approved_kades") THEN 1 ELSE 0 END) as proses,
                SUM(CASE WHEN status = "completed" THEN 1 ELSE 0 END) as selesai,
                SUM(CASE WHEN status = "rejected" THEN 1 ELSE 0 END) as ditolak
            ')->first();

            $countsPrev = PengajuanSurat::where('created_at', '<', $thisMonthStart)->selectRaw('
                COUNT(*) as total,
                SUM(CASE WHEN status = "submitted" THEN 1 ELSE 0 END) as pending
            ')->first();

            $totalWarga = User::count();
            $wargaPrev = User::where('created_at', '<', $lastMonthStart)->count();
            $wargaGrowth = $wargaPrev > 0 ? round((($totalWarga - $wargaPrev) / $wargaPrev) * 100, 1) : 0;

            $totalSurat = (int) $counts->total;
            $suratPrev = (int) $countsPrev->total;
            $suratGrowth = $suratPrev > 0 ? round((($totalSurat - $suratPrev) / $suratPrev) * 100, 1) : 0;

            $pending = (int) $counts->pending;
            $pendingPrev = (int) $countsPrev->pending;
            $pendingGrowth = $pendingPrev > 0 ? round((($pending - $pendingPrev) / $pendingPrev) * 100, 1) : 0;

            $eventBulanIni = Event::whereBetween('tanggal', [$thisMonthStart, $now->copy()->endOfMonth()])->count();
            $eventPrev = Event::whereBetween('tanggal', [$lastMonthStart, $lastMonth->copy()->endOfMonth()])->count();
            $eventGrowth = $eventPrev > 0 ? round((($eventBulanIni - $eventPrev) / $eventPrev) * 100, 1) : 0;

            $beritaAktif = Berita::count();
            $beritaPrev = Berita::where('created_at', '<', $lastMonthStart)->count();
            $beritaGrowth = $beritaPrev > 0 ? round((($beritaAktif - $beritaPrev) / $beritaPrev) * 100, 1) : 0;

            return [
                'totalWarga' => ['value' => $totalWarga, 'growth' => $wargaGrowth, 'sparkline' => $this->sparklineAggregate(User::class, 30)],
                'totalSurat' => ['value' => $totalSurat, 'growth' => $suratGrowth, 'sparkline' => $this->sparklineAggregate(PengajuanSurat::class, 30)],
                'pending' => ['value' => $pending, 'growth' => $pendingGrowth],
                'proses' => ['value' => (int) $counts->proses, 'growth' => 0],
                'selesai' => ['value' => (int) $counts->selesai, 'growth' => 0],
                'ditolak' => ['value' => (int) $counts->ditolak, 'growth' => 0],
                'eventBulanIni' => ['value' => $eventBulanIni, 'growth' => $eventGrowth],
                'beritaAktif' => ['value' => $beritaAktif, 'growth' => $beritaGrowth],
            ];
        });
    }

    public function letterDistribution(): array
    {
        return Cache::remember(self::CACHE_PREFIX.'letter_dist', self::CACHE_TTL, function () {
            $raw = PengajuanSurat::selectRaw('jenis_surat, COUNT(*) as total')
                ->groupBy('jenis_surat')
                ->orderByDesc('total')
                ->get();

            $colors = [
                '#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6',
                '#ec4899', '#14b8a6', '#f97316', '#6366f1', '#84cc16',
            ];

            $result = [];
            $others = 0;
            $i = 0;

            foreach ($raw as $item) {
                $label = str_replace('_', ' ', ucfirst($item->jenis_surat));
                if ($i < 5) {
                    $result[] = [
                        'label' => $label,
                        'total' => (int) $item->total,
                        'color' => $colors[$i],
                    ];
                } else {
                    $others += (int) $item->total;
                }
                $i++;
            }

            if ($others > 0) {
                $result[] = [
                    'label' => 'Lainnya',
                    'total' => $others,
                    'color' => '#6b7280',
                ];
            }

            return $result;
        });
    }

    public function workflowMonitor(): array
    {
        return Cache::remember(self::CACHE_PREFIX.'workflow', self::CACHE_TTL, function () {
            $steps = [
                'submitted' => 'blue',
                'verified' => 'indigo',
                'approved_operator' => 'purple',
                'approved_sekdes' => 'cyan',
                'approved_kades' => 'emerald',
                'completed' => 'green',
            ];

            $counts = PengajuanSurat::selectRaw('status, COUNT(*) as total')
                ->whereIn('status', array_keys($steps))
                ->groupBy('status')
                ->pluck('total', 'status');

            $result = [];
            foreach ($steps as $status => $color) {
                $result[] = [
                    'status' => $status,
                    'label' => ApprovalHistory::STATUS_LABELS()[$status] ?? ucfirst(str_replace('_', ' ', $status)),
                    'total' => (int) ($counts[$status] ?? 0),
                    'color' => $color,
                ];
            }

            return $result;
        });
    }

    public function myApprovals(): array
    {
        $user = auth()->user();
        $role = $user?->roles()->first()?->name;

        $statusMap = [
            'Operator Pelayanan' => ['submitted', 'verified'],
            'Sekretaris Desa' => ['approved_operator'],
            'Kepala Desa' => ['approved_sekdes'],
        ];

        $statuses = $role === 'Super Admin'
            ? ['submitted', 'verified', 'approved_operator', 'approved_sekdes']
            : ($statusMap[$role] ?? []);

        $items = [];
        if (! empty($statuses)) {
            $items = PengajuanSurat::with('user')
                ->whereIn('status', $statuses)
                ->latest()
                ->take(5)
                ->get()
                ->map(fn ($s) => [
                    'id' => $s->id,
                    'user_name' => $s->user->name ?? '-',
                    'user_avatar' => $s->user->avatar_initials,
                    'jenis_surat' => str_replace('_', ' ', $s->jenis_surat),
                    'status' => $s->status,
                    'status_label' => $s->status_label,
                    'status_color' => $s->status_color,
                    'created_at' => $s->created_at->diffForHumans(),
                    'url' => route('admin.pengajuan.show', $s),
                ])->toArray();
        }

        return [
            'role' => $role,
            'items' => $items,
            'total' => count($items),
        ];
    }

    public function recentActivities(): array
    {
        return Cache::remember(self::CACHE_PREFIX.'activities', self::CACHE_TTL, function () {
            return ActivityLog::with('user')
                ->latest()
                ->take(10)
                ->get()
                ->map(fn ($log) => [
                    'id' => $log->id,
                    'user_name' => $log->user->name ?? 'System',
                    'user_avatar' => $log->user ? $log->user->avatar_initials : 'S',
                    'aksi' => $log->aksi,
                    'deskripsi' => $log->deskripsi,
                    'waktu' => $log->created_at->diffForHumans(),
                    'created_at' => $log->created_at,
                    'icon' => $this->activityIcon($log->aksi),
                    'color' => $this->activityColor($log->aksi),
                ])->toArray();
        });
    }

    public function latestSubmissions(): array
    {
        return PengajuanSurat::with('user')
            ->latest()
            ->take(10)
            ->get()
            ->map(fn ($s) => [
                'id' => $s->id,
                'user_name' => $s->user->name ?? '-',
                'user_avatar' => $s->user->avatar_initials ?? '?',
                'jenis_surat' => str_replace('_', ' ', $s->jenis_surat),
                'status' => $s->status,
                'status_label' => $s->status_label,
                'status_color' => $s->status_color,
                'created_at' => $s->created_at->format('d M Y, H:i'),
                'priority' => $s->isActive() ? 'high' : ($s->isTerminal() ? 'done' : 'medium'),
                'url' => route('admin.pengajuan.show', $s),
                'progress' => $this->calculateProgress($s->status),
            ])->toArray();
    }

    public function queueStatus(): array
    {
        return Cache::remember(self::CACHE_PREFIX.'queue', self::CACHE_TTL, function () {
            $waiting = DB::table('jobs')->count();
            $failed = DB::table('failed_jobs')->count();
            $running = DB::table('jobs')->whereNotNull('reserved_at')->count();
            $success = PengajuanSurat::where('status', 'completed')
                ->whereDate('updated_at', today())
                ->count();

            return [
                'waiting' => $waiting,
                'failed' => $failed,
                'running' => $running,
                'success' => $success,
            ];
        });
    }

    public function systemHealth(): array
    {
        return Cache::remember(self::CACHE_PREFIX.'health', 120, function () {
            $phpVersion = phpversion();
            $laravelVersion = app()->version();

            try {
                $mysqlVersion = DB::connection()->getPdo()->getAttribute(\PDO::ATTR_SERVER_VERSION);
                $mysqlOk = true;
            } catch (\Exception) {
                $mysqlVersion = 'N/A';
                $mysqlOk = false;
            }

            $failedJobs = DB::table('failed_jobs')->count();
            $queueOk = $failedJobs < 10;

            $storageOk = is_writable(storage_path());
            $schedulerOk = Cache::has('scheduler_last_run');

            try {
                Cache::store('file')->forever('health_check', true);
                Cache::store('file')->forget('health_check');
                $cacheOk = true;
            } catch (\Exception) {
                $cacheOk = false;
            }

            $diskTotal = @disk_total_space(storage_path()) ?: 0;
            $diskFree = @disk_free_space(storage_path()) ?: 0;
            $diskUsed = $diskTotal > 0 ? round((($diskTotal - $diskFree) / $diskTotal) * 100, 1) : 0;

            $memUsage = round(memory_get_usage(true) / 1024 / 1024, 1);
            $memLimitRaw = ini_get('memory_limit');
            $memLimitBytes = $memLimitRaw !== false ? (int) $memLimitRaw : 0;
            if ($memLimitBytes > 0 && preg_match('/([+-]?\d+)([kmg]b?)?$/i', $memLimitRaw, $m)) {
                $memLimitBytes = (int) $m[1];
                $unit = strtolower($m[2] ?? 'b');
                if ($unit === 'k' || $unit === 'kb') {
                    $memLimitBytes *= 1024;
                } elseif ($unit === 'm' || $unit === 'mb') {
                    $memLimitBytes *= 1024 * 1024;
                } elseif ($unit === 'g' || $unit === 'gb') {
                    $memLimitBytes *= 1024 * 1024 * 1024;
                }
            }
            $memLimit = $memLimitBytes > 0 ? round($memLimitBytes / 1024 / 1024, 1) : -1;

            $okCount = collect([$storageOk, $queueOk, $cacheOk, $schedulerOk, $mysqlOk])->filter()->count();
            $totalChecks = 5;
            $healthPercent = round(($okCount / $totalChecks) * 100);
            $healthStatus = $healthPercent === 100 ? 'Optimal' : ($healthPercent >= 60 ? 'Perlu Perhatian' : 'Kritis');

            return [
                'php' => ['version' => $phpVersion, 'ok' => version_compare($phpVersion, '8.1', '>=')],
                'laravel' => ['version' => $laravelVersion, 'ok' => true],
                'mysql' => ['version' => $mysqlVersion, 'ok' => $mysqlOk],
                'queue' => ['version' => "{$failedJobs} failed", 'ok' => $queueOk],
                'storage' => ['version' => 'writable', 'ok' => $storageOk],
                'scheduler' => ['version' => $schedulerOk ? 'running' : 'unknown', 'ok' => $schedulerOk],
                'cache' => ['version' => config('cache.default'), 'ok' => $cacheOk],
                'disk_usage' => $diskUsed,
                'memory_usage' => $memUsage,
                'memory_limit' => $memLimit,
                'health_percent' => $healthPercent,
                'health_status' => $healthStatus,
            ];
        });
    }

    public function analyticsSummary(): array
    {
        return Cache::remember(self::CACHE_PREFIX.'analytics_summary', self::CACHE_TTL, function () {
            $today = PengajuanSurat::whereDate('created_at', today())->count();
            $todayCompleted = PengajuanSurat::where('status', 'completed')->whereDate('updated_at', today())->count();

            $thisWeek = PengajuanSurat::where('created_at', '>=', now()->startOfWeek())->count();
            $thisWeekCompleted = PengajuanSurat::where('status', 'completed')
                ->where('updated_at', '>=', now()->startOfWeek())->count();

            $thisMonth = PengajuanSurat::whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)->count();
            $thisMonthCompleted = PengajuanSurat::where('status', 'completed')
                ->whereMonth('updated_at', now()->month)
                ->whereYear('updated_at', now()->year)->count();

            $thisYear = PengajuanSurat::whereYear('created_at', now()->year)->count();

            $total = PengajuanSurat::count();
            $completed = PengajuanSurat::where('status', 'completed')->count();
            $rejected = PengajuanSurat::where('status', 'rejected')->count();

            $avgProcessing = PengajuanSurat::where('status', 'completed')
                ->selectRaw('AVG(TIMESTAMPDIFF(SECOND, created_at, updated_at)) as avg')
                ->value('avg') ?? 0;

            return [
                'today' => $today,
                'todayCompleted' => $todayCompleted,
                'thisWeek' => $thisWeek,
                'thisWeekCompleted' => $thisWeekCompleted,
                'thisMonth' => $thisMonth,
                'thisMonthCompleted' => $thisMonthCompleted,
                'thisYear' => $thisYear,
                'avgProcessingTime' => round($avgProcessing / 3600, 1),
                'successRate' => $total > 0 ? round(($completed / $total) * 100, 1) : 0,
                'rejectionRate' => $total > 0 ? round(($rejected / $total) * 100, 1) : 0,
            ];
        });
    }

    public function topRtrw(): array
    {
        return Cache::remember(self::CACHE_PREFIX.'top_rtrw', self::CACHE_TTL, function () {
            $topRt = PengajuanSurat::selectRaw('users.rt, COUNT(*) as total')
                ->join('users', 'pengajuan_surats.user_id', '=', 'users.id')
                ->whereNotNull('users.rt')
                ->where('users.rt', '!=', '')
                ->groupBy('users.rt')
                ->orderByDesc('total')
                ->take(5)
                ->get()
                ->map(fn ($item) => ['label' => "RT {$item->rt}", 'total' => (int) $item->total])->toArray();

            $topRw = PengajuanSurat::selectRaw('users.rw, COUNT(*) as total')
                ->join('users', 'pengajuan_surats.user_id', '=', 'users.id')
                ->whereNotNull('users.rw')
                ->where('users.rw', '!=', '')
                ->groupBy('users.rw')
                ->orderByDesc('total')
                ->take(5)
                ->get()
                ->map(fn ($item) => ['label' => "RW {$item->rw}", 'total' => (int) $item->total])->toArray();

            return ['rt' => $topRt, 'rw' => $topRw];
        });
    }

    public function upcomingEvents(): array
    {
        return Event::whereDate('tanggal', '>=', today())
            ->orderBy('tanggal')
            ->take(5)
            ->get()
            ->map(fn ($e) => [
                'id' => $e->id,
                'judul' => $e->judul,
                'tanggal' => $e->tanggal->format('d M'),
                'tanggal_full' => $e->tanggal->format('Y-m-d'),
                'tempat' => $e->tempat,
                'jenis' => $e->jenis,
                'waktu_mulai' => $e->waktu_mulai?->format('H:i'),
            ])->toArray();
    }

    public function calendarEvents(): array
    {
        $start = now()->startOfMonth();
        $end = now()->copy()->endOfMonth();

        return Event::whereBetween('tanggal', [$start, $end])
            ->orderBy('tanggal')
            ->get()
            ->map(fn ($e) => [
                'id' => $e->id,
                'judul' => $e->judul,
                'day' => $e->tanggal->format('d'),
                'jenis' => $e->jenis,
                'status' => $e->status,
            ])->toArray();
    }

    public function villageInfo(): array
    {
        return Cache::remember(self::CACHE_PREFIX.'village', 300, function () {
            $settings = VillageSetting::pluck('value', 'key')->toArray();

            return [
                'nama_desa' => $settings['nama_desa'] ?? '-',
                'nama_kades' => $settings['nama_kades'] ?? '-',
                'nama_sekdes' => $settings['nama_sekdes'] ?? '-',
                'nama_kecamatan' => $settings['nama_kecamatan'] ?? '-',
                'nama_kabupaten' => $settings['nama_kabupaten'] ?? '-',
                'alamat_kantor' => $settings['alamat_kantor'] ?? '-',
                'telepon' => $settings['telepon_desa'] ?? '-',
                'email' => $settings['email_desa'] ?? '-',
                'logo_desa' => $settings['logo_desa'] ?? null,
                'total_penduduk' => User::count(),
                'total_kk' => User::whereNotNull('no_kk')->where('no_kk', '!=', '')->count(),
            ];
        });
    }

    public function notifications(): array
    {
        $user = auth()->user();
        $items = collect();

        $pendingCount = PengajuanSurat::where('status', 'submitted')->count();
        if ($pendingCount > 0 && $user->can('letter.review')) {
            $items->push([
                'type' => 'approval',
                'message' => "{$pendingCount} pengajuan menunggu verifikasi",
                'url' => route('admin.pengajuan.index', ['status' => 'submitted']),
            ]);
        }

        $revisionCount = PengajuanSurat::where('status', 'revision')->count();
        if ($revisionCount > 0 && $user->can('letter.view')) {
            $items->push([
                'type' => 'revision',
                'message' => "{$revisionCount} pengajuan perlu direvisi",
                'url' => route('admin.pengajuan.index', ['status' => 'revision']),
            ]);
        }

        $failedJobs = DB::table('failed_jobs')->count();
        if ($failedJobs > 0 && $user->can('queue.manage')) {
            $items->push([
                'type' => 'queue',
                'message' => "{$failedJobs} antrean gagal",
                'url' => route('admin.queue.index'),
            ]);
        }

        $todayEvents = Event::whereDate('tanggal', today())->count();
        if ($todayEvents > 0 && $user->can('event.manage')) {
            $items->push([
                'type' => 'event',
                'message' => "{$todayEvents} event hari ini",
                'url' => route('admin.events.index'),
            ]);
        }

        return $items->toArray();
    }

    private function sparklineAggregate(string $modelClass, int $days): array
    {
        $table = (new $modelClass)->getTable();

        $raw = DB::table($table)
            ->selectRaw('DATE(created_at) as date, COUNT(*) as total')
            ->where('created_at', '>=', now()->subDays($days - 1)->startOfDay())
            ->groupBy(DB::raw('DATE(created_at)'))
            ->pluck('total', 'date');

        $data = [];
        for ($i = $days - 1; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $data[] = (int) ($raw[$date] ?? 0);
        }

        return $data;
    }

    private function calculateProgress(string $status): int
    {
        return match ($status) {
            'submitted' => 17,
            'verified' => 33,
            'approved_operator' => 50,
            'approved_sekdes' => 67,
            'approved_kades' => 83,
            'completed' => 100,
            'revision' => 33,
            'rejected' => 33,
            default => 0,
        };
    }

    private function activityIcon(string $aksi): string
    {
        return match (true) {
            str_contains($aksi, 'create') || str_contains($aksi, 'add') => 'plus',
            str_contains($aksi, 'update') || str_contains($aksi, 'edit') || str_contains($aksi, 'ubah') => 'pencil',
            str_contains($aksi, 'delete') || str_contains($aksi, 'hapus') => 'trash',
            str_contains($aksi, 'approve') || str_contains($aksi, 'setuju') => 'check',
            str_contains($aksi, 'reject') || str_contains($aksi, 'tolak') => 'x-mark',
            str_contains($aksi, 'revision') || str_contains($aksi, 'revisi') => 'arrow-path',
            str_contains($aksi, 'login') || str_contains($aksi, 'masuk') => 'arrow-right',
            str_contains($aksi, 'toggle') || str_contains($aksi, 'aktif') => 'power',
            default => 'document',
        };
    }

    private function activityColor(string $aksi): string
    {
        return match (true) {
            str_contains($aksi, 'create') || str_contains($aksi, 'add') => 'emerald',
            str_contains($aksi, 'update') || str_contains($aksi, 'edit') || str_contains($aksi, 'ubah') => 'blue',
            str_contains($aksi, 'delete') || str_contains($aksi, 'hapus') => 'red',
            str_contains($aksi, 'approve') || str_contains($aksi, 'setuju') => 'green',
            str_contains($aksi, 'reject') || str_contains($aksi, 'tolak') => 'red',
            str_contains($aksi, 'revision') || str_contains($aksi, 'revisi') => 'amber',
            str_contains($aksi, 'login') || str_contains($aksi, 'masuk') => 'indigo',
            default => 'gray',
        };
    }
}
