<?php

namespace App\Dashboard\Widgets;

use App\Dashboard\Contracts\WidgetInterface;
use App\Dashboard\Services\SystemHealthService;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class SystemInfoWidget implements WidgetInterface
{
    public function __construct(private readonly User $user) {}

    public function getKey(): string
    {
        return 'system_info';
    }

    public function getTitle(): string
    {
        return 'Info Sistem';
    }

    public function getComponent(): string
    {
        return 'components.widgets._system_info';
    }

    public function getPermissions(): array
    {
        return [];
    }

    public function getGroup(): string
    {
        return 'system';
    }

    public function getPosition(): int
    {
        return 52;
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
        return 4;
    }

    public function getData(): array
    {
        try {
            $health = app(SystemHealthService::class)->check();
        } catch (\Exception) {
            $health = [
                'php' => ['version' => phpversion(), 'ok' => true],
                'laravel' => ['version' => app()->version(), 'ok' => true],
                'mysql' => ['version' => 'N/A', 'ok' => false],
                'queue' => ['version' => 'N/A', 'ok' => false],
                'storage' => ['version' => 'N/A', 'ok' => false],
                'scheduler' => ['version' => 'unknown', 'ok' => false],
                'cache' => ['version' => 'N/A', 'ok' => false],
                'disk_usage' => 0,
                'memory_usage' => round(memory_get_usage(true) / 1024 / 1024, 1),
                'memory_limit' => -1,
                'health_percent' => 0,
                'health_status' => 'Kritis',
            ];
        }

        $dbSize = 0;
        try {
            $dbName = config('database.connections.mysql.database', 'prodesa');
            $row = DB::selectOne(
                'SELECT ROUND(SUM(data_length + index_length) / 1024 / 1024, 2) AS size_mb FROM information_schema.tables WHERE table_schema = ?',
                [$dbName]
            );
            $dbSize = $row->size_mb ?? 0;
        } catch (\Exception) {
            $dbSize = 0;
        }

        $storageUsed = 0;
        $storageTotal = 0;
        if (function_exists('disk_free_space') && function_exists('disk_total_space')) {
            $path = storage_path();
            $free = @disk_free_space($path) ?: 0;
            $total = @disk_total_space($path) ?: 1;
            $storageUsed = round(($total - $free) / 1024 / 1024 / 1024, 2);
            $storageTotal = round($total / 1024 / 1024 / 1024, 2);
        }

        $storagePercent = $storageTotal > 0 ? round(($storageUsed / $storageTotal) * 100, 1) : 0;

        $pdfCount = 0;
        $pdfSize = 0;
        try {
            $pdfPath = storage_path('app/public/pdfs');
            if (is_dir($pdfPath)) {
                $files = glob($pdfPath.'/*.pdf');
                $pdfCount = count($files);
                foreach ($files as $file) {
                    $pdfSize += filesize($file);
                }
                $pdfSize = round($pdfSize / 1024 / 1024, 2);
            }
        } catch (\Exception) {
            $pdfCount = 0;
            $pdfSize = 0;
        }

        return [
            'health' => $health,
            'dbSizeMb' => $dbSize,
            'storageUsedGb' => $storageUsed,
            'storageTotalGb' => $storageTotal,
            'storagePercent' => $storagePercent,
            'pdfCount' => $pdfCount,
            'pdfSizeMb' => $pdfSize,
            'lastBackup' => null,
        ];
    }
}
