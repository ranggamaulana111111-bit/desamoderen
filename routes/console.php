<?php

use App\Console\Commands\BackupDatabase;
use App\Console\Commands\PruneAuditLogs;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Schedule::command(BackupDatabase::class)
    ->when(fn () => (string) config('village.backup_auto', '0') === '1')
    ->{match (config('village.backup_frekuensi', 'harian')) {
        'mingguan' => 'weekly',
        'bulanan' => 'monthly',
        default => 'daily',
    }}();

Schedule::command(PruneAuditLogs::class)
    ->when(fn () => (int) (config('village.security_audit_log_retensi') ?: config('village.security_audit_retensi_hari', 90)) > 0)
    ->daily();
