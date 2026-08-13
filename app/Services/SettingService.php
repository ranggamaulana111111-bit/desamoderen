<?php

namespace App\Services;

use App\Models\ActivityLog;
use App\Models\VillageSetting;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SettingService
{
    const CACHE_KEY = 'village_settings';

    const CACHE_TTL = 3600;

    private ?SettingVersionService $versionService = null;

    private function getVersionService(): SettingVersionService
    {
        if (! $this->versionService) {
            $this->versionService = app(SettingVersionService::class);
        }

        return $this->versionService;
    }

    const CATEGORIES = [
        'profil-desa' => [
            'label' => 'Profil Desa',
            'icon' => 'M2.25 12l8.954-8.955a1.126 1.126 0 011.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25',
            'group' => 'identity',
            'description' => 'Identitas dan profil resmi desa',
        ],
        'pemerintahan' => [
            'label' => 'Pemerintahan',
            'icon' => 'M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z',
            'group' => 'officials',
            'description' => 'Data pejabat dan perangkat desa',
        ],
        'ttd-digital' => [
            'label' => 'TTD Digital',
            'icon' => 'M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10',
            'group' => 'signature',
            'description' => 'Tanda tangan digital, stempel, dan QR',
        ],
        'template-surat' => [
            'label' => 'Template Surat',
            'icon' => 'M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z',
            'group' => 'letter_template',
            'description' => 'Kelola template dan format surat',
        ],
        'nomor-surat' => [
            'label' => 'Nomor Surat',
            'icon' => 'M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z',
            'group' => 'letter_number',
            'description' => 'Format dan pola penomoran surat',
        ],
        'workflow' => [
            'label' => 'Workflow',
            'icon' => 'M3 4.5h14.25M3 9h9.75M3 13.5h5.25m5.25-.75L17.25 9m0 0L21 12.75M17.25 9v12',
            'group' => 'workflow',
            'description' => 'Alur persetujuan dan approval',
        ],
        'queue-driver' => [
            'label' => 'Queue Driver',
            'icon' => 'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10',
            'group' => 'queue_driver',
            'description' => 'Konfigurasi driver antrean',
        ],
        'antrean' => [
            'label' => 'Antrean',
            'icon' => 'M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z',
            'group' => 'service_queue',
            'description' => 'Jam layanan dan kuota antrean',
        ],
        'notifikasi' => [
            'label' => 'Notifikasi',
            'icon' => 'M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0',
            'group' => 'notification',
            'description' => 'Konfigurasi notifikasi dan template',
        ],
        'analytics' => [
            'label' => 'Analytics',
            'icon' => 'M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z',
            'group' => 'analytics',
            'description' => 'Pengaturan dashboard analitik',
        ],
        'backup' => [
            'label' => 'Backup',
            'icon' => 'M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 0v3.75m-16.5-3.75v3.75m16.5 0v3.75C20.25 16.153 16.556 18 12 18s-8.25-1.847-8.25-4.125v-3.75m16.5 0c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125',
            'group' => 'backup',
            'description' => 'Backup database dan storage',
        ],
        'keamanan' => [
            'label' => 'Keamanan',
            'icon' => 'M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z',
            'group' => 'security',
            'description' => 'Keamanan sistem dan akses',
        ],
        'integrasi' => [
            'label' => 'Integrasi',
            'icon' => 'M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244',
            'group' => 'integration',
            'description' => 'Layanan eksternal dan API',
        ],
        'tampilan' => [
            'label' => 'Tampilan',
            'icon' => 'M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5v4m0 0h-4m4 0l-5-5',
            'group' => 'appearance',
            'description' => 'Personalisasi tampilan aplikasi',
        ],
        'maintenance' => [
            'label' => 'Maintenance',
            'icon' => 'M11.42 15.17l-4.29-4.3m0 0l-4.29 4.3m4.29-4.3V1.59m0 18.82V21m0-21l4.29 4.3m0 0l4.29-4.3M17.59 9H21M3 9h3.41m10.18 0H21M3 9h3.41',
            'group' => 'maintenance',
            'description' => 'Pemeliharaan sistem',
        ],
        'audit-log' => [
            'label' => 'Audit Log',
            'icon' => 'M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z',
            'group' => 'audit_log',
            'description' => 'Riwayat perubahan konfigurasi',
        ],
    ];

    public function getAllGrouped(): array
    {
        return VillageSetting::all()
            ->groupBy('group')
            ->map(fn ($items) => $items->pluck('value', 'key')->toArray())
            ->toArray();
    }

    public function getByGroup(string $group): array
    {
        return VillageSetting::where('group', $group)
            ->pluck('value', 'key')
            ->toArray();
    }

    public function updateGroup(string $group, array $data, ?array $files = null): void
    {
        $oldValues = $this->getByGroup($group);

        DB::transaction(function () use ($group, $data, $files) {
            foreach ($data as $key => $value) {
                VillageSetting::updateOrCreate(
                    ['key' => $key],
                    ['value' => $value, 'group' => $group]
                );
            }

            if ($files) {
                foreach ($files as $key => $file) {
                    if ($file instanceof UploadedFile && $file->isValid()) {
                        $existing = VillageSetting::where('key', $key)->value('value');
                        if ($existing && Storage::disk('public')->exists($existing)) {
                            Storage::disk('public')->delete($existing);
                        }

                        $ext = $file->getClientOriginalExtension();
                        $filename = str_replace('_', '-', $key).".{$ext}";
                        $path = $file->storeAs('uploads/identity', $filename, 'public');

                        VillageSetting::updateOrCreate(
                            ['key' => $key],
                            ['value' => $path, 'group' => $group]
                        );
                    }
                }
            }
        });

        $newValues = $this->getByGroup($group);
        $changes = $this->diffChanges($oldValues, $newValues);

        if (! empty($changes)) {
            $categoryLabel = self::CATEGORIES[$this->getCategoryKeyByGroup($group)]['label'] ?? $group;
            $userName = auth()->user()->name ?? 'System';

            ActivityLog::catat(
                'update_pengaturan',
                "{$userName} mengubah {$categoryLabel}: ".implode(', ', array_keys($changes)),
                'pengaturan',
                null
            );

            $this->getVersionService()->createSnapshot(
                "Update {$categoryLabel}",
                $changes
            );
        }

        $this->clearCache();
    }

    public function clearCache(): void
    {
        Cache::forget(self::CACHE_KEY);
    }

    public function diffChanges(array $old, array $new): array
    {
        $changes = [];
        foreach ($new as $key => $value) {
            $oldValue = $old[$key] ?? null;
            if ($oldValue !== $value && ! $this->isFileField($key)) {
                $changes[$key] = ['old' => $oldValue, 'new' => $value];
            }
        }

        return $changes;
    }

    private function isFileField(string $key): bool
    {
        return in_array($key, [
            'logo_desa', 'logo_pemda', 'stempel_desa', 'ttd_kades', 'ttd_sekdes',
            'foto_kades', 'banner_desa', 'foto_kantor',
            'logo_login', 'logo_sidebar', 'favicon', 'background_login',
        ]);
    }

    public function getCategories(): array
    {
        return self::CATEGORIES;
    }

    public function getCategory(string $key): ?array
    {
        return self::CATEGORIES[$key] ?? null;
    }

    public function getGroupFromCategory(string $category): ?string
    {
        return self::CATEGORIES[$category]['group'] ?? null;
    }

    public function getCategoryKeyByGroup(string $group): ?string
    {
        foreach (self::CATEGORIES as $key => $category) {
            if (($category['group'] ?? null) === $group) {
                return $key;
            }
        }

        return null;
    }
}
