<?php

namespace App\Dashboard\Widgets;

use App\Dashboard\Contracts\WidgetInterface;
use App\Models\User;
use App\Models\VillageSetting;
use Illuminate\Support\Facades\Cache;

class VillageWidget implements WidgetInterface
{
    public function __construct(private readonly User $user) {}

    public function getKey(): string
    {
        return 'village';
    }

    public function getTitle(): string
    {
        return 'Informasi Desa';
    }

    public function getComponent(): string
    {
        return 'components.widgets._village';
    }

    public function getPermissions(): array
    {
        return [];
    }

    public function getGroup(): string
    {
        return 'info';
    }

    public function getPosition(): int
    {
        return 60;
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
        return 6;
    }

    public function getData(): array
    {
        return Cache::remember('dsh_village_info', 300, function () {
            $settings = VillageSetting::pluck('value', 'key')->toArray();

            return [
                'nama_desa' => $settings['nama_desa'] ?? '-',
                'nama_kades' => $settings['nama_kades'] ?? '-',
                'nama_sekdes' => $settings['nama_sekdes'] ?? '-',
                'nama_kecamatan' => $settings['nama_kecamatan'] ?? '-',
                'total_penduduk' => User::count(),
                'total_kk' => User::whereNotNull('no_kk')->where('no_kk', '!=', '')->count(),
                'website_desa' => $settings['website_desa'] ?? '',
                'email_desa' => $settings['email_desa'] ?? '',
                'telepon_desa' => $settings['telepon_desa'] ?? '',
                'jumlah_dusun' => $settings['jumlah_dusun'] ?? '',
            ];
        });
    }
}
