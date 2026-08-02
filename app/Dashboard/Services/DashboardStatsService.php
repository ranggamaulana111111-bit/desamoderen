<?php

namespace App\Dashboard\Services;

use App\Models\Berita;
use App\Models\Event;
use App\Models\PengajuanSurat;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class DashboardStatsService
{
    private const CACHE_TTL = 60;

    private const PREFIX = 'dsh_stats_';

    public function overview(): array
    {
        return Cache::remember(self::PREFIX.'overview', self::CACHE_TTL, function () {
            $now = now();
            $lastMonthStart = now()->subMonth()->startOfMonth();
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
            $eventPrev = Event::whereBetween('tanggal', [$lastMonthStart, $now->copy()->endOfMonth()])->count();
            $eventGrowth = $eventPrev > 0 ? round((($eventBulanIni - $eventPrev) / $eventPrev) * 100, 1) : 0;

            $beritaAktif = Berita::count();
            $beritaPrev = Berita::where('created_at', '<', $lastMonthStart)->count();
            $beritaGrowth = $beritaPrev > 0 ? round((($beritaAktif - $beritaPrev) / $beritaPrev) * 100, 1) : 0;

            return [
                'totalWarga' => ['value' => $totalWarga, 'growth' => $wargaGrowth, 'sparkline' => $this->sparkline(User::class, 30)],
                'totalSurat' => ['value' => $totalSurat, 'growth' => $suratGrowth, 'sparkline' => $this->sparkline(PengajuanSurat::class, 30)],
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
        return Cache::remember(self::PREFIX.'letter_dist', self::CACHE_TTL, function () {
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
                    $result[] = ['label' => $label, 'total' => (int) $item->total, 'color' => $colors[$i]];
                } else {
                    $others += (int) $item->total;
                }
                $i++;
            }

            if ($others > 0) {
                $result[] = ['label' => 'Lainnya', 'total' => $others, 'color' => '#6b7280'];
            }

            return $result;
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
                'progress' => $this->calculateProgress($s->status),
                'url' => route('admin.pengajuan.show', $s),
            ])->toArray();
    }

    public function analyticsSummary(): array
    {
        return Cache::remember(self::PREFIX.'analytics_summary', self::CACHE_TTL, function () {
            $today = PengajuanSurat::whereDate('created_at', today())->count();
            $todayCompleted = PengajuanSurat::where('status', 'completed')->whereDate('updated_at', today())->count();
            $thisWeek = PengajuanSurat::where('created_at', '>=', now()->startOfWeek())->count();
            $thisWeekCompleted = PengajuanSurat::where('status', 'completed')->where('updated_at', '>=', now()->startOfWeek())->count();
            $thisMonth = PengajuanSurat::whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->count();
            $thisMonthCompleted = PengajuanSurat::where('status', 'completed')->whereMonth('updated_at', now()->month)->whereYear('updated_at', now()->year)->count();
            $thisYear = PengajuanSurat::whereYear('created_at', now()->year)->count();
            $total = PengajuanSurat::count();
            $completed = PengajuanSurat::where('status', 'completed')->count();
            $rejected = PengajuanSurat::where('status', 'rejected')->count();
            $avgProcessing = PengajuanSurat::where('status', 'completed')->selectRaw('AVG(TIMESTAMPDIFF(SECOND, created_at, updated_at)) as avg')->value('avg') ?? 0;

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

    private function sparkline(string $modelClass, int $days): array
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

    public static function calculateProgress(string $status): int
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
}
