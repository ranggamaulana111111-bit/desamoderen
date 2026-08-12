<?php

namespace App\Console\Commands;

use App\Models\ActivityLog;
use Illuminate\Console\Command;

class PruneAuditLogs extends Command
{
    protected $signature = 'logs:prune {--days= : Jumlah hari retensi (default dari pengaturan)}';

    protected $description = 'Menghapus log aktivitas yang lebih lama dari masa retensi';

    public function handle(): int
    {
        $days = (int) ($this->option('days')
            ?: config('village.security_audit_log_retensi')
            ?: config('village.security_audit_retensi_hari', 90));

        if ($days <= 0) {
            $this->info('Retensi non-aktif, tidak ada yang dihapus.');

            return self::SUCCESS;
        }

        $cutoff = now()->subDays($days);
        $deleted = ActivityLog::where('created_at', '<', $cutoff)->delete();

        $this->info("Menghapus {$deleted} log aktivitas sebelum {$cutoff->format('d-m-Y')}.");

        return self::SUCCESS;
    }
}
