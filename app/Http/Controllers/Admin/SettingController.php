<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Setting\SettingStoreRequest;
use App\Models\ActivityLog;
use App\Models\LetterConfig;
use App\Services\BackupService;
use App\Services\GitUpdateService;
use App\Services\SettingService;
use App\Services\SettingVersionService;
use App\Services\TelegramNotifier;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\View\View;

class SettingController extends Controller
{
    public function __construct(
        private SettingService $settingService,
        private SettingVersionService $versionService,
        private GitUpdateService $gitUpdateService,
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

        $telegramConfigured = app(TelegramNotifier::class)->isConfigured();
        $backups = app(BackupService::class)->list();

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
            'telegramConfigured',
            'backups',
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
        foreach (['logo_desa', 'logo_pemda', 'banner_desa', 'foto_kantor', 'foto_kades', 'stempel_desa', 'ttd_kades', 'ttd_sekdes', 'logo_login', 'logo_sidebar', 'favicon', 'background_login'] as $field) {
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

        $label = match ($action) {
            'cache' => 'Cache',
            'config' => 'Konfigurasi',
            'route' => 'Route',
            'view' => 'View',
            'optimize' => 'Cache & Optimasi',
            'storage-link' => 'Storage Link',
        };

        try {
            $exitCode = Artisan::call($commands[$action]);
            $output = trim(Artisan::output());
        } catch (\Throwable $e) {
            $output = $e->getMessage();
            $exitCode = 1;
        }

        if ($exitCode !== 0) {
            return redirect()->route('admin.setting.index', ['tab' => 'maintenance'])
                ->with('error', "{$label} gagal dijalankan.".($output ? " {$output}" : ''));
        }

        ActivityLog::catat(
            "maintenance_{$action}",
            "{$request->user()->name} menjalankan maintenance: {$label}",
            'pengaturan',
            null
        );

        return redirect()->route('admin.setting.index', ['tab' => 'maintenance'])
            ->with('success', "{$label} berhasil dijalankan.");
    }

    public function updateStatus(): JsonResponse
    {
        if (! $this->gitUpdateService->gitAvailable()) {
            return response()->json([
                'success' => false,
                'message' => 'Git tidak tersedia di server.',
            ]);
        }

        if (! $this->gitUpdateService->isGitRepository()) {
            return response()->json([
                'success' => false,
                'message' => 'Folder aplikasi bukan repository git. Jalankan git clone terlebih dahulu.',
            ]);
        }

        try {
            $current = $this->gitUpdateService->currentVersion();
            $update = $this->gitUpdateService->checkForUpdates();
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }

        return response()->json([
            'success' => true,
            'current' => $current,
            'update' => $update,
        ]);
    }

    public function updateApp(Request $request): JsonResponse
    {
        if (! $this->gitUpdateService->gitAvailable()) {
            return response()->json([
                'success' => false,
                'message' => 'Git tidak tersedia di server.',
            ]);
        }

        if (! $this->gitUpdateService->isGitRepository()) {
            return response()->json([
                'success' => false,
                'message' => 'Folder aplikasi bukan repository git. Jalankan git clone terlebih dahulu.',
            ]);
        }

        try {
            $result = $this->gitUpdateService->update();
        } catch (\Throwable $e) {
            $result = [
                'success' => false,
                'steps' => [],
                'message' => $e->getMessage(),
            ];
        }

        $shortHash = $result['version']['shortHash'] ?? 'n/a';

        ActivityLog::catat(
            'update_app',
            $result['success']
                ? "{$request->user()->name} memperbarui aplikasi ke versi terbaru ({$shortHash})"
                : "{$request->user()->name} mencoba memperbarui aplikasi, tetapi gagal.",
            'pengaturan',
            null
        );

        return response()->json($result);
    }

    public function notifyTest(Request $request): RedirectResponse
    {
        $notifier = app(TelegramNotifier::class);

        if (! $notifier->isConfigured()) {
            return redirect()->route('admin.setting.index', ['tab' => 'notifikasi'])
                ->with('error', 'Telegram belum dikonfigurasi. Isi token bot dan chat ID terlebih dahulu.');
        }

        $ok = $notifier->send(
            '<b>Prodesa</b> - Pesan uji terkirim pada '.now()->translatedFormat('d M Y H:i').'.'
        );

        ActivityLog::catat(
            'telegram_test',
            "{$request->user()->name} mengirim pesan uji Telegram: ".($ok ? 'berhasil' : 'gagal'),
            'pengaturan',
            null
        );

        return redirect()->route('admin.setting.index', ['tab' => 'notifikasi'])
            ->with($ok ? 'success' : 'error', $ok
                ? 'Pesan uji berhasil dikirim ke Telegram.'
                : 'Gagal mengirim pesan uji. Periksa kembali token dan chat ID.');
    }

    public function backupRun(Request $request): RedirectResponse
    {
        try {
            $path = app(BackupService::class)->create();

            ActivityLog::catat(
                'backup_create',
                "{$request->user()->name} membuat backup database: ".basename($path),
                'pengaturan',
                null
            );

            return redirect()->route('admin.setting.index', ['tab' => 'backup'])
                ->with('success', 'Backup berhasil dibuat.');
        } catch (\Throwable $e) {
            return redirect()->route('admin.setting.index', ['tab' => 'backup'])
                ->with('error', 'Backup gagal: '.$e->getMessage());
        }
    }

    public function backupDownload(string $filename)
    {
        $path = app(BackupService::class)->download($filename);

        if ($path === null) {
            return redirect()->route('admin.setting.index', ['tab' => 'backup'])
                ->with('error', 'File backup tidak ditemukan.');
        }

        return response()->download($path);
    }

    public function backupDelete(Request $request, string $filename): RedirectResponse
    {
        $deleted = app(BackupService::class)->delete($filename);

        ActivityLog::catat(
            'backup_delete',
            "{$request->user()->name} menghapus backup: {$filename}",
            'pengaturan',
            null
        );

        return redirect()->route('admin.setting.index', ['tab' => 'backup'])
            ->with($deleted ? 'success' : 'error', $deleted
                ? 'Backup berhasil dihapus.'
                : 'File backup tidak ditemukan.');
    }
}
