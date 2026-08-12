<?php

namespace App\Console\Commands;

use App\Services\BackupService;
use Illuminate\Console\Command;

class BackupDatabase extends Command
{
    protected $signature = 'backup:run {--no-storage : Jangan sertakan file storage}';

    protected $description = 'Membuat backup database (dan storage) ke storage/app/backups';

    public function handle(BackupService $backup): int
    {
        $this->info('Membuat backup...');

        try {
            $path = $backup->create(! $this->option('no-storage'));
            $this->info('Backup berhasil: '.$path);

            return self::SUCCESS;
        } catch (\Throwable $e) {
            $this->error('Backup gagal: '.$e->getMessage());

            return self::FAILURE;
        }
    }
}
