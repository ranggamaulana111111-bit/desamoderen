<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use RuntimeException;

class BackupService
{
    private string $backupDir;

    public function __construct()
    {
        $this->backupDir = storage_path('app/backups');

        if (! is_dir($this->backupDir)) {
            mkdir($this->backupDir, 0755, true);
        }
    }

    public function dir(): string
    {
        return $this->backupDir;
    }

    public function list(): array
    {
        $files = glob($this->backupDir.'/*.zip') ?: [];

        $items = collect($files)->map(function (string $path) {
            return [
                'filename' => basename($path),
                'path' => $path,
                'size' => filesize($path),
                'size_human' => $this->humanSize(filesize($path)),
                'created_at' => filemtime($path),
            ];
        })->sortByDesc('created_at')->values();

        return $items->all();
    }

    public function create(bool $includeStorage = true): string
    {
        $sql = $this->dumpDatabase();
        $sqlPath = $this->backupDir.'/dump_'.Str::random(8).'.sql';
        file_put_contents($sqlPath, $sql);

        $stamp = now()->format('Y-m-d_His');
        $zipPath = $this->backupDir."/backup_{$stamp}.zip";

        $zip = new \ZipArchive;
        if ($zip->open($zipPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) !== true) {
            unlink($sqlPath);
            throw new RuntimeException('Gagal membuat file backup.');
        }

        $zip->addFile($sqlPath, 'database.sql');
        $zip->close();
        unlink($sqlPath);

        if ($includeStorage) {
            $this->appendStorage($zipPath);
        }

        $this->prune((int) config('village.backup_retensi_hari', 30));

        return $zipPath;
    }

    public function prune(int $retentionDays): int
    {
        if ($retentionDays <= 0) {
            return 0;
        }

        $cutoff = now()->subDays($retentionDays)->getTimestamp();
        $deleted = 0;

        foreach (glob($this->backupDir.'/*.zip') ?: [] as $path) {
            if (filemtime($path) < $cutoff) {
                @unlink($path);
                $deleted++;
            }
        }

        return $deleted;
    }

    public function download(string $filename): ?string
    {
        $path = $this->backupDir.'/'.basename($filename);

        return is_file($path) ? $path : null;
    }

    public function delete(string $filename): bool
    {
        $path = $this->backupDir.'/'.basename($filename);

        return is_file($path) && unlink($path);
    }

    private function dumpDatabase(): string
    {
        $binary = $this->findMysqldump();

        if ($binary !== null) {
            return $this->dumpViaBinary($binary);
        }

        return $this->dumpViaPdo();
    }

    private function findMysqldump(): ?string
    {
        $candidates = [];

        $candidates[] = 'mysqldump';

        foreach (glob('C:/laragon/bin/mysql/*/bin/mysqldump.exe') ?: [] as $p) {
            $candidates[] = $p;
        }

        foreach ($candidates as $candidate) {
            $cmd = sprintf('%s --version', escapeshellarg($candidate));
            @exec($cmd, $out, $code);

            if ($code === 0) {
                return $candidate;
            }
        }

        return null;
    }

    private function dumpViaBinary(string $binary): string
    {
        $config = config('database.connections.mysql');

        $cmd = sprintf(
            '%s --host=%s --port=%s --user=%s --password=%s --single-transaction --routines --triggers %s',
            escapeshellarg($binary),
            escapeshellarg($config['host']),
            escapeshellarg((string) $config['port']),
            escapeshellarg($config['username']),
            escapeshellarg((string) $config['password']),
            escapeshellarg($config['database'])
        );

        @exec($cmd, $out, $code);

        if ($code !== 0) {
            throw new RuntimeException('mysqldump gagal dieksekusi (kode '.$code.').');
        }

        return implode("\n", $out);
    }

    private function dumpViaPdo(): string
    {
        $pdo = DB::connection()->getPdo();
        $sql = "-- Prodesa database backup\n-- Generated: ".now()->toDateTimeString()."\n--\n\n";
        $sql .= 'SET FOREIGN_KEY_CHECKS = 0;'."\n\n";

        $tables = $pdo->query('SHOW TABLES')->fetchAll(\PDO::FETCH_COLUMN);

        foreach ($tables as $table) {
            $create = $pdo->query("SHOW CREATE TABLE `{$table}`")->fetch(\PDO::FETCH_ASSOC);
            $sql .= "DROP TABLE IF EXISTS `{$table}`;\n";
            $sql .= $create['Create Table'].";\n\n";

            $rows = $pdo->query("SELECT * FROM `{$table}`");
            while ($row = $rows->fetch(\PDO::FETCH_ASSOC)) {
                $cols = implode(', ', array_map(fn ($c) => '`'.$c.'`', array_keys($row)));
                $vals = implode(', ', array_map(function ($v) use ($pdo) {
                    if ($v === null) {
                        return 'NULL';
                    }

                    return $pdo->quote((string) $v);
                }, array_values($row)));
                $sql .= "INSERT INTO `{$table}` ({$cols}) VALUES ({$vals});\n";
            }

            $sql .= "\n";
        }

        $sql .= 'SET FOREIGN_KEY_CHECKS = 1;'."\n";

        return $sql;
    }

    private function appendStorage(string $zipPath): void
    {
        $publicDir = storage_path('app/public');

        if (! is_dir($publicDir)) {
            return;
        }

        $zip = new \ZipArchive;
        if ($zip->open($zipPath, \ZipArchive::CREATE) !== true) {
            return;
        }

        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($publicDir, \FilesystemIterator::SKIP_DOTS)
        );

        foreach ($iterator as $file) {
            if (! $file->isFile()) {
                continue;
            }

            $relative = 'storage/'.Str::after($file->getPathname(), realpath($publicDir).DIRECTORY_SEPARATOR);
            $zip->addFile($file->getPathname(), str_replace('\\', '/', $relative));
        }

        $zip->close();
    }

    private function humanSize(int $bytes): string
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $i = 0;

        while ($bytes >= 1024 && $i < count($units) - 1) {
            $bytes /= 1024;
            $i++;
        }

        return round($bytes, 1).' '.$units[$i];
    }
}
