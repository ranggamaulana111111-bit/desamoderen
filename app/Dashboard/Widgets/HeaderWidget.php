<?php

namespace App\Dashboard\Widgets;

use App\Dashboard\Contracts\WidgetInterface;
use App\Models\Event;
use App\Models\PengajuanSurat;
use App\Models\User;
use App\Services\ApprovalService;
use App\Services\WeatherService;
use Illuminate\Support\Facades\DB;

class HeaderWidget implements WidgetInterface
{
    public function __construct(private readonly User $user) {}

    public function getKey(): string
    {
        return 'header';
    }

    public function getTitle(): string
    {
        return 'Header';
    }

    public function getComponent(): string
    {
        return 'components.widgets._header';
    }

    public function getPermissions(): array
    {
        return [];
    }

    public function getGroup(): string
    {
        return 'header';
    }

    public function getPosition(): int
    {
        return 1;
    }

    public function isVisible(): bool
    {
        return true;
    }

    public function isLazy(): bool
    {
        return false;
    }

    public function gridSpan(): int
    {
        return 12;
    }

    public function getData(): array
    {
        $todayStats = $this->getTodayStats();

        return [
            'user' => $this->user,
            'weather' => app(WeatherService::class)->getWeather(),
            'notifications' => $this->getNotifications(),
            'dailySummary' => $this->buildDailySummary($todayStats),
            'todayStats' => $todayStats,
        ];
    }

    private function getTodayStats(): array
    {
        $todaySubmissions = PengajuanSurat::whereDate('created_at', today())->count();
        $todayCompleted = PengajuanSurat::where('status', 'completed')
            ->whereDate('updated_at', today())->count();
        $todayVerified = PengajuanSurat::where('status', 'verified')
            ->whereDate('updated_at', today())->count();

        $pendingApprovals = $this->pendingApprovalCount();

        return compact(
            'todaySubmissions',
            'todayCompleted',
            'todayVerified',
            'pendingApprovals',
        );
    }

    private function pendingApprovalCount(): int
    {
        $service = app(ApprovalService::class);
        $permissions = ['letter.review', 'letter.verify', 'letter.final_approve'];
        $total = 0;

        foreach ($permissions as $permission) {
            if (! $this->user->hasPermissionTo($permission)) {
                continue;
            }

            foreach ($service->getPendingStatusesForPermission($permission) as $status) {
                $total += PengajuanSurat::where('status', $status)->count();
            }
        }

        return $total;
    }

    private function buildDailySummary(array $stats): string
    {
        $parts = [];

        if ($stats['pendingApprovals'] > 0) {
            $label = match (true) {
                $this->user->hasPermissionTo('letter.review') => 'surat menunggu verifikasi',
                $this->user->hasPermissionTo('letter.verify') => 'surat menunggu verifikasi Sekretaris Desa',
                $this->user->hasPermissionTo('letter.final_approve') => 'surat menunggu tanda tangan Kepala Desa',
                default => 'surat menunggu verifikasi',
            };
            $parts[] = "{$stats['pendingApprovals']} {$label}";
        }

        if ($stats['todayCompleted'] > 0) {
            $parts[] = "{$stats['todayCompleted']} surat selesai diproses";
        }

        $todayEvents = Event::whereDate('tanggal', today())->count();
        if ($todayEvents > 0 && $this->user->hasPermissionTo('event.manage')) {
            $parts[] = "{$todayEvents} event desa berlangsung";
        }

        return $this->joinParts($parts);
    }

    private function joinParts(array $parts): string
    {
        $count = count($parts);

        if ($count === 0) {
            return '';
        }

        if ($count === 1) {
            return "Hari ini terdapat {$parts[0]}.";
        }

        if ($count === 2) {
            return "Hari ini terdapat {$parts[0]} dan {$parts[1]}.";
        }

        $last = array_pop($parts);

        return 'Hari ini terdapat '.implode(', ', $parts).", dan {$last}.";
    }

    private function getNotifications(): array
    {
        $items = collect();
        $service = app(ApprovalService::class);

        $permissionLabels = [
            'letter.review' => 'verifikasi',
            'letter.verify' => 'verifikasi Sekretaris Desa',
            'letter.final_approve' => 'tanda tangan Kepala Desa',
        ];

        foreach ($permissionLabels as $permission => $label) {
            if (! $this->user->hasPermissionTo($permission)) {
                continue;
            }

            $statuses = $service->getPendingStatusesForPermission($permission);
            $total = 0;
            $linkStatus = $statuses[0] ?? null;

            foreach ($statuses as $status) {
                $count = PengajuanSurat::where('status', $status)->count();
                $total += $count;
                if ($linkStatus === null && $count > 0) {
                    $linkStatus = $status;
                }
            }

            if ($total > 0) {
                $items->push([
                    'type' => 'approval',
                    'message' => "{$total} pengajuan menunggu {$label}",
                    'url' => route('admin.pengajuan.index', ['status' => $linkStatus]),
                ]);
            }
        }

        $revisionCount = PengajuanSurat::where('status', 'revision')->count();
        if ($revisionCount > 0 && $this->user->hasPermissionTo('letter.view')) {
            $items->push([
                'type' => 'revision',
                'message' => "{$revisionCount} pengajuan perlu direvisi",
                'url' => route('admin.pengajuan.index', ['status' => 'revision']),
            ]);
        }

        $failedJobs = DB::table('failed_jobs')->count();
        if ($failedJobs > 0 && $this->user->hasPermissionTo('queue.manage')) {
            $items->push([
                'type' => 'queue',
                'message' => "{$failedJobs} antrean gagal",
                'url' => route('admin.queue.index'),
            ]);
        }

        $todayEvents = Event::whereDate('tanggal', today())->count();
        if ($todayEvents > 0 && $this->user->hasPermissionTo('event.manage')) {
            $items->push([
                'type' => 'event',
                'message' => "{$todayEvents} event hari ini",
                'url' => route('admin.events.index'),
            ]);
        }

        return $items->toArray();
    }
}
