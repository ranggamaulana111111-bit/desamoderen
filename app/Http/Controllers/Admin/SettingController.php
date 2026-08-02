<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Setting\SettingStoreRequest;
use App\Models\ActivityLog;
use App\Models\LetterConfig;
use App\Services\SettingService;
use App\Services\SettingVersionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\View\View;

class SettingController extends Controller
{
    public function __construct(
        private SettingService $settingService,
        private SettingVersionService $versionService,
    ) {}

    public function index(): View
    {
        $groupedSettings = $this->settingService->getAllGrouped();
        $categories = $this->settingService->getCategories();
        $letterTemplates = LetterConfig::all();

        $auditLogs = ActivityLog::where('tipe', 'pengaturan')
            ->with('user')
            ->latest()
            ->take(50)
            ->get();

        $settings = [];
        foreach ($groupedSettings as $group => $items) {
            foreach ($items as $key => $value) {
                $settings[$key] = $value;
            }
        }

        $versions = $this->versionService->getVersions(10);
        $currentVersion = $this->versionService->getLatestVersionNumber();

        $previewKeys = [
            'nama_desa', 'nama_provinsi', 'nama_kabupaten', 'nama_kecamatan',
            'alamat_kantor', 'motto_desa', 'nama_kades', 'jabatan_kades',
            'nama_sekdes', 'nama_camat', 'latitude', 'longitude',
            'format_nomor_surat', 'nomor_prefix', 'nomor_suffix',
            'nomor_padding', 'nomor_reset', 'qr_sertifikat',
        ];
        $previewDefaults = collect($previewKeys)
            ->mapWithKeys(fn ($k) => [$k => $settings[$k] ?? ''])
            ->all();

        return view('admin.setting.index', compact(
            'settings',
            'groupedSettings',
            'categories',
            'letterTemplates',
            'auditLogs',
            'versions',
            'currentVersion',
            'previewDefaults',
        ));
    }

    public function update(SettingStoreRequest $request, string $category): RedirectResponse
    {
        $validated = $request->validated();

        $group = $this->settingService->getGroupFromCategory($category);
        if (! $group) {
            return redirect()->route('admin.setting.index')
                ->with('error', 'Kategori tidak ditemukan.');
        }

        $files = [];
        foreach (['logo_desa', 'banner_desa', 'foto_kantor', 'foto_kades', 'stempel_desa', 'ttd_kades', 'ttd_sekdes', 'logo_login', 'logo_sidebar', 'favicon', 'background_login'] as $field) {
            if ($request->hasFile($field)) {
                $files[$field] = $request->file($field);
            }
        }

        $this->settingService->updateGroup($group, $validated, $files);

        $catLabel = SettingService::CATEGORIES[$category]['label'] ?? $category;

        return redirect()->route('admin.setting.index', ['tab' => $category])
            ->with('success', "Pengaturan {$catLabel} berhasil disimpan.");
    }

    public function clearCache(Request $request): RedirectResponse
    {
        $this->settingService->clearCache();

        ActivityLog::catat(
            'clear_cache',
            "{$request->user()->name} membersihkan cache pengaturan",
            'pengaturan',
            null
        );

        return redirect()->route('admin.setting.index', ['tab' => 'maintenance'])
            ->with('success', 'Cache pengaturan berhasil dibersihkan.');
    }

    public function maintenance(Request $request, string $action): RedirectResponse
    {
        $allowed = ['cache', 'config', 'route', 'view', 'optimize', 'storage-link'];

        if (! in_array($action, $allowed)) {
            return redirect()->route('admin.setting.index', ['tab' => 'maintenance'])
                ->with('error', 'Aksi maintenance tidak dikenal.');
        }

        $commands = [
            'cache' => 'cache:clear',
            'config' => 'config:clear',
            'route' => 'route:clear',
            'view' => 'view:clear',
            'optimize' => 'optimize:clear',
            'storage-link' => 'storage:link',
        ];

        Artisan::call($commands[$action]);

        $output = Artisan::output();

        $label = match ($action) {
            'cache' => 'Cache',
            'config' => 'Konfigurasi',
            'route' => 'Route',
            'view' => 'View',
            'optimize' => 'Optimasi',
            'storage-link' => 'Storage Link',
        };

        ActivityLog::catat(
            "maintenance_{$action}",
            "{$request->user()->name} menjalankan maintenance: {$label}",
            'pengaturan',
            null
        );

        return redirect()->route('admin.setting.index', ['tab' => 'maintenance'])
            ->with('success', "{$label} berhasil dijalankan.");
    }
}
