<?php

namespace App\Dashboard\Widgets;

use App\Dashboard\Contracts\WidgetInterface;
use App\Models\Event;
use App\Models\PengajuanSurat;
use App\Models\User;
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

        $pendingApprovals = 0;
        if ($this->user->can('letter.review')) {
            $pendingApprovals = PengajuanSurat::where('status', 'submitted')->count();
        } elseif ($this->user->can('letter.verify')) {
            $pendingApprovals = PengajuanSurat::where('status', 'approved_operator')->count();
        } elseif ($this->user->can('letter.final_approve')) {
            $pendingApprovals = PengajuanSurat::where('status', 'approved_sekdes')->count();
        }

        return compact(
            'todaySubmissions',
            'todayCompleted',
            'todayVerified',
            'pendingApprovals',
        );
    }

    private function buildDailySummary(array $stats): string
    {
        $parts = [];

        if ($stats['pendingApprovals'] > 0) {
            if ($this->user->can('letter.review')) {
                $parts[] = "{$stats['pendingApprovals']} surat menunggu verifikasi";
            } elseif ($this->user->can('letter.verify')) {
                $parts[] = "{$stats['pendingApprovals']} surat menunggu verifikasi Sekretaris Desa";
            } elseif ($this->user->can('letter.final_approve')) {
                $parts[] = "{$stats['pendingApprovals']} surat menunggu tanda tangan Kepala Desa";
            }
        }

        if ($stats['todayCompleted'] > 0) {
            $parts[] = "{$stats['todayCompleted']} surat selesai diproses";
        }

        $todayEvents = Event::whereDate('tanggal', today())->count();
        if ($todayEvents > 0 && $this->user->can('event.manage')) {
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

        $pendingCount = PengajuanSurat::where('status', 'submitted')->count();
        if ($pendingCount > 0 && $this->user->can('letter.review')) {
            $items->push([
                'type' => 'approval',
                'message' => "{$pendingCount} pengajuan menunggu verifikasi",
                'url' => route('admin.pengajuan.index', ['status' => 'submitted']),
            ]);
        }

        $revisionCount = PengajuanSurat::where('status', 'revision')->count();
        if ($revisionCount > 0 && $this->user->can('letter.view')) {
            $items->push([
                'type' => 'revision',
                'message' => "{$revisionCount} pengajuan perlu direvisi",
                'url' => route('admin.pengajuan.index', ['status' => 'revision']),
            ]);
        }

        $failedJobs = DB::table('failed_jobs')->count();
        if ($failedJobs > 0 && $this->user->can('queue.manage')) {
            $items->push([
                'type' => 'queue',
                'message' => "{$failedJobs} antrean gagal",
                'url' => route('admin.queue.index'),
            ]);
        }

        $todayEvents = Event::whereDate('tanggal', today())->count();
        if ($todayEvents > 0 && $this->user->can('event.manage')) {
            $items->push([
                'type' => 'event',
                'message' => "{$todayEvents} event hari ini",
                'url' => route('admin.events.index'),
            ]);
        }

        return $items->toArray();
    }
}
