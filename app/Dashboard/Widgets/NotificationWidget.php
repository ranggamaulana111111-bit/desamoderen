<?php

namespace App\Dashboard\Widgets;

use App\Dashboard\Contracts\WidgetInterface;
use App\Models\PengajuanSurat;
use App\Models\User;

class NotificationWidget implements WidgetInterface
{
    public function __construct(private readonly User $user) {}

    public function getKey(): string
    {
        return 'notifications';
    }

    public function getTitle(): string
    {
        return 'Pusat Notifikasi';
    }

    public function getComponent(): string
    {
        return 'components.widgets._notifications';
    }

    public function getPermissions(): array
    {
        return ['letter.view'];
    }

    public function getGroup(): string
    {
        return 'action';
    }

    public function getPosition(): int
    {
        return 3;
    }

    public function isVisible(): bool
    {
        return $this->user && $this->user->role_label !== 'Warga';
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
        $user = $this->user;
        $role = $user->roles()->first()?->name;

        $statusMap = [
            'Operator Pelayanan' => ['submitted'],
            'Sekretaris Desa' => ['approved_operator'],
            'Kepala Desa' => ['approved_sekdes'],
        ];

        $myStatuses = $role === 'Super Admin'
            ? ['submitted', 'verified', 'approved_operator', 'approved_sekdes']
            : ($statusMap[$role] ?? []);

        $myPending = empty($myStatuses) ? 0 : PengajuanSurat::whereIn('status', $myStatuses)->count();

        $revisionCount = PengajuanSurat::where('status', 'revision')
            ->where('user_id', $user->id)
            ->count();

        $todaySubmissions = PengajuanSurat::whereDate('created_at', today())->count();

        $completedToday = PengajuanSurat::where('status', 'completed')
            ->whereDate('updated_at', today())
            ->count();

        $items = [];

        if ($myPending > 0) {
            $items[] = [
                'type' => 'approval',
                'icon' => 'M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
                'color' => 'emerald',
                'message' => "{$myPending} pengajuan menunggu persetujuan Anda",
                'count' => $myPending,
            ];
        }

        if ($revisionCount > 0) {
            $items[] = [
                'type' => 'revision',
                'icon' => 'M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182',
                'color' => 'amber',
                'message' => "{$revisionCount} pengajuan perlu revisi dari Anda",
                'count' => $revisionCount,
            ];
        }

        $items[] = [
            'type' => 'today',
            'icon' => 'M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z',
            'color' => 'blue',
            'message' => "{$todaySubmissions} pengajuan baru hari ini",
            'count' => $todaySubmissions,
        ];

        $items[] = [
            'type' => 'completed',
            'icon' => 'M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
            'color' => 'green',
            'message' => "{$completedToday} surat selesai diproses hari ini",
            'count' => $completedToday,
        ];

        return ['items' => $items];
    }
}
