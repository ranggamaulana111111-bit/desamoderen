<?php

use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\AnalyticsController;
use App\Http\Controllers\Admin\ApbdesaController;
use App\Http\Controllers\Admin\BeritaController;
use App\Http\Controllers\Admin\DisposisiController;
use App\Http\Controllers\Admin\DocumentVersionController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\InventarisController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\KadesDashboardController;
use App\Http\Controllers\Admin\SekdesDashboardController;
use App\Http\Controllers\Admin\LetterConfigController;
use App\Http\Controllers\Admin\PengajuanSuratController;
use App\Http\Controllers\Admin\QueueController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SettingVersionController;
use App\Http\Controllers\Admin\SuratKeluarController;
use App\Http\Controllers\Admin\SuratMasukController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\WargaController;
use App\Http\Controllers\Admin\WidgetController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\BeritaController as PublicBeritaController;
use App\Http\Controllers\Debug\QrTestController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\General\CetakSuratController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PublicVerificationController;
use App\Http\Controllers\Warga\DashboardController;
use App\Http\Controllers\Warga\EventController as WargaEventController;
use App\Http\Controllers\Warga\SuratController;
use App\Models\AntreanPengambilan;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('berita/{slug}', [PublicBeritaController::class, 'show'])->name('berita.show');
Route::post('faq/ask', [FaqController::class, 'ask'])->middleware('throttle:10,1')->name('faq.ask');

Route::get('verifikasi/{hash}', [PublicVerificationController::class, 'show'])->name('verifikasi.show');

if (app()->environment('local')) {
    Route::get('debug/test-qr', [QrTestController::class, 'testQr']);
}

Route::get('antrean/{kodeQr}', function (string $kodeQr) {
    $antrean = AntreanPengambilan::with('pengajuan.user')
        ->where('kode_qr', $kodeQr)
        ->firstOrFail();

    return view('antrean.show', compact('antrean'));
})->name('antrean.show');

Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->middleware('throttle:5,1');
    Route::get('register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('register', [AuthController::class, 'register'])->middleware('throttle:5,1');
});

Route::middleware('auth')->post('logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('dashboard', function () {
        return view('admin.dashboard');
    })->middleware('permission:dashboard.view')->name('dashboard');

    Route::get('kades', [KadesDashboardController::class, 'index'])->middleware('permission:letter.final_approve')->name('kades.dashboard');
    Route::get('sekdes', [SekdesDashboardController::class, 'index'])->middleware('permission:letter.verify')->name('sekdes.dashboard');

    // ── Office Administration Center ──
    Route::resource('surat-masuk', SuratMasukController::class)->except(['index'])->middleware('permission:office.view')->names('surat-masuk');
    Route::get('surat-masuk', [SuratMasukController::class, 'index'])->middleware('permission:office.view')->name('surat-masuk.index');
    Route::resource('surat-keluar', SuratKeluarController::class)->except(['index'])->middleware('permission:office.view')->names('surat-keluar');
    Route::get('surat-keluar', [SuratKeluarController::class, 'index'])->middleware('permission:office.view')->name('surat-keluar.index');
    Route::resource('disposisi', DisposisiController::class)->except(['index'])->middleware('permission:office.view')->names('disposisi');
    Route::get('disposisi', [DisposisiController::class, 'index'])->middleware('permission:office.view')->name('disposisi.index');

    // ── Inventaris & Aset ──
    Route::resource('inventaris', InventarisController::class)->except(['index'])->middleware('permission:inventaris.view')->names('inventaris');
    Route::get('inventaris', [InventarisController::class, 'index'])->middleware('permission:inventaris.view')->name('inventaris.index');

    // ── APBDesa ──
    Route::resource('apbdesa', ApbdesaController::class)->except(['index'])->middleware('permission:anggaran.view')->names('apbdesa');
    Route::get('apbdesa', [ApbdesaController::class, 'index'])->middleware('permission:anggaran.view')->name('apbdesa.index');

    // ── User Management ──
    Route::get('warga', [WargaController::class, 'index'])->middleware('permission:user.view')->name('warga.index');
    Route::get('users', [UserManagementController::class, 'index'])->middleware('permission:user.view')->name('users.index');
    Route::get('users/create', [UserManagementController::class, 'create'])->middleware('permission:user.create')->name('users.create');
    Route::post('users', [UserManagementController::class, 'store'])->middleware('permission:user.create')->name('users.store');
    Route::get('users/{user}', [UserManagementController::class, 'show'])->middleware('permission:user.view')->name('users.show');
    Route::patch('users/{user}/role', [UserManagementController::class, 'updateRole'])->middleware('permission:user.assign_role')->name('users.updateRole');

    // ── Role & Permission Management ──
    Route::resource('roles', RoleController::class)->middleware('permission:role.manage')->except('show');

    // ── Letter Workflow ──
    Route::get('pengajuan', [PengajuanSuratController::class, 'index'])->middleware('permission:letter.view')->name('pengajuan.index');
    Route::get('pengajuan/{pengajuan}', [PengajuanSuratController::class, 'show'])->middleware('permission:letter.view')->name('pengajuan.show');
    Route::post('pengajuan/{pengajuan}/approve', [PengajuanSuratController::class, 'approve'])->name('pengajuan.approve');
    Route::post('pengajuan/{pengajuan}/reject', [PengajuanSuratController::class, 'reject'])->name('pengajuan.reject');
    Route::post('pengajuan/{pengajuan}/revision', [PengajuanSuratController::class, 'requestRevision'])->name('pengajuan.revision');
    Route::get('pengajuan/{pengajuan}/cetak', [CetakSuratController::class, 'cetak'])->middleware('permission:letter.print')->name('pengajuan.cetak');

    // ── Document Versioning ──
    Route::prefix('pengajuan/{pengajuan}/versions')->name('pengajuan.versions.')->middleware('permission:letter.version.view')->group(function () {
        Route::get('/', [DocumentVersionController::class, 'index'])->name('index');
        Route::get('/{version}', [DocumentVersionController::class, 'show'])->name('show');
        Route::post('/{version}/restore', [DocumentVersionController::class, 'restore'])->name('restore');
        Route::get('/{version}/download', [DocumentVersionController::class, 'download'])->name('download');
        Route::get('/diff/compare', [DocumentVersionController::class, 'diff'])->name('diff');
    });

    // ── Content Management ──
    Route::resource('berita', BeritaController::class)->middleware('permission:news.manage');
    Route::resource('events', AdminEventController::class)->middleware('permission:event.manage');

    // ── Queue Monitoring ──
    Route::get('queue', [QueueController::class, 'index'])->middleware('permission:queue.view')->name('queue.index');
    Route::get('queue/chart-data', [QueueController::class, 'chartData'])->middleware('permission:queue.view')->name('queue.chart');
    Route::post('queue/retry/{id}', [QueueController::class, 'retry'])->middleware('permission:queue.manage')->name('queue.retry');
    Route::post('queue/retry-all', [QueueController::class, 'retryAll'])->middleware('permission:queue.manage')->name('queue.retryAll');
    Route::delete('queue/{id}', [QueueController::class, 'destroy'])->middleware('permission:queue.manage')->name('queue.destroy');
    Route::delete('queue/all', [QueueController::class, 'destroyAll'])->middleware('permission:queue.manage')->name('queue.destroyAll');

    // ── Analytics ──
    Route::get('analytics', [AnalyticsController::class, 'index'])->middleware('permission:analytics.view')->name('analytics.index');
    Route::get('analytics/chart-data', [AnalyticsController::class, 'chartData'])->middleware('permission:analytics.view')->name('analytics.chart');
    Route::get('analytics/export', [AnalyticsController::class, 'exportCsv'])->middleware('permission:analytics.view')->name('analytics.export');

    // ── Laporan Desa ──
    Route::get('laporan', [LaporanController::class, 'index'])->middleware('permission:dashboard.view')->name('laporan.index');
    Route::get('laporan/create', [LaporanController::class, 'create'])->middleware('permission:dashboard.view')->name('laporan.create');
    Route::post('laporan', [LaporanController::class, 'store'])->middleware('permission:dashboard.view')->name('laporan.store');
    Route::post('laporan/preview-data', [LaporanController::class, 'previewData'])->middleware('permission:dashboard.view')->name('laporan.preview');
    Route::get('laporan/{laporan}', [LaporanController::class, 'show'])->middleware('permission:dashboard.view')->name('laporan.show');
    Route::get('laporan/{laporan}/edit', [LaporanController::class, 'edit'])->middleware('permission:dashboard.view')->name('laporan.edit');
    Route::put('laporan/{laporan}', [LaporanController::class, 'update'])->middleware('permission:dashboard.view')->name('laporan.update');
    Route::delete('laporan/{laporan}', [LaporanController::class, 'destroy'])->middleware('permission:dashboard.view')->name('laporan.destroy');
    Route::get('laporan/{laporan}/pdf', [LaporanController::class, 'generatePdf'])->middleware('permission:dashboard.view')->name('laporan.pdf');
    Route::post('laporan/{laporan}/finalize', [LaporanController::class, 'finalize'])->middleware('permission:letter.final_approve')->name('laporan.finalize');
    Route::post('laporan/{laporan}/restore', [LaporanController::class, 'restore'])->middleware('permission:letter.final_approve')->name('laporan.restore');

    // ── Activity Log ──
    Route::get('activity-log', [ActivityLogController::class, 'index'])->middleware('permission:audit.view')->name('activity-log.index');

    // ── Letter Template Management ──
    Route::get('template-surat/{letterConfig}/toggle', [LetterConfigController::class, 'toggle'])->middleware('permission:setting.manage')->name('letter-config.toggle');
    Route::resource('template-surat', LetterConfigController::class)->middleware('permission:setting.manage')->except('show')->names('letter-config');

    // ── Theme Settings (AJAX) — must be before wildcard widgets/{key} ──
    Route::get('widgets/theme/settings', [WidgetController::class, 'getTheme'])->middleware('permission:dashboard.view')->name('widgets.theme');
    Route::post('widgets/theme/settings', [WidgetController::class, 'saveTheme'])->middleware('permission:dashboard.view')->name('widgets.theme.save');

    // ── Widget Engine (AJAX) ──
    Route::get('widgets/{key}', [WidgetController::class, 'show'])->middleware('permission:dashboard.view')->name('widgets.show');
    Route::post('widgets/layout', [WidgetController::class, 'saveLayout'])->middleware('permission:dashboard.view')->name('widgets.layout');

    // ── Settings ──
    Route::get('pengaturan', [SettingController::class, 'index'])->middleware('permission:setting.manage')->name('setting.index');
    Route::post('pengaturan/{category}', [SettingController::class, 'update'])->middleware('permission:setting.manage')->name('setting.update');
    Route::post('pengaturan/clear-cache', [SettingController::class, 'clearCache'])->middleware('permission:setting.manage')->name('setting.clearCache');
    Route::post('pengaturan/maintenance/{action}', [SettingController::class, 'maintenance'])->middleware('permission:setting.manage')->name('setting.maintenance');

    // ── Configuration Versioning ──
    Route::get('pengaturan/versions', [SettingVersionController::class, 'index'])->middleware('permission:setting.manage')->name('setting.versions.index');
    Route::get('pengaturan/versions/{id}', [SettingVersionController::class, 'show'])->middleware('permission:setting.manage')->name('setting.versions.show');
    Route::post('pengaturan/versions/{id}/rollback', [SettingVersionController::class, 'rollback'])->middleware('permission:setting.manage')->name('setting.versions.rollback');
    Route::get('pengaturan/versions/diff/{from}/{to}', [SettingVersionController::class, 'diff'])->middleware('permission:setting.manage')->name('setting.versions.diff');
});

Route::middleware(['auth'])->prefix('warga')->name('warga.')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('surat', [SuratController::class, 'index'])->name('surat.index');
    Route::get('surat/create/{jenis}', [SuratController::class, 'create'])->name('surat.create');
    Route::post('surat', [SuratController::class, 'store'])->name('surat.store');
    Route::get('surat/{pengajuan}', [SuratController::class, 'show'])->name('surat.show');
    Route::get('surat/{pengajuan}/edit', [SuratController::class, 'edit'])->name('surat.edit');
    Route::patch('surat/{pengajuan}', [SuratController::class, 'updateAfterRevision'])->name('surat.updateAfterRevision');
    Route::get('surat/{pengajuan}/cetak', [CetakSuratController::class, 'cetakWarga'])->name('surat.cetak');
    Route::delete('surat/{pengajuan}', [SuratController::class, 'destroy'])->name('surat.destroy');

    Route::post('events/{undangan}/konfirmasi', [WargaEventController::class, 'konfirmasi'])->name('events.konfirmasi');
});
