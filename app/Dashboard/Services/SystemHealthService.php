<?php

namespace App\Dashboard\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class SystemHealthService
{
    private const CACHE_TTL = 120;

    private const PREFIX = 'dsh_health_';

    public function check(): array
    {
        return Cache::remember(self::PREFIX.'check', self::CACHE_TTL, function () {
            $phpVersion = phpversion();
            $laravelVersion = app()->version();

            try {
                $mysqlVersion = DB::connection()->getPdo()->getAttribute(\PDO::ATTR_SERVER_VERSION);
                $mysqlOk = true;
            } catch (\Exception) {
                $mysqlVersion = 'N/A';
                $mysqlOk = false;
            }

            try {
                $failedJobs = DB::table('failed_jobs')->count();
            } catch (\Exception) {
                $failedJobs = 0;
            }
            $queueOk = $failedJobs < 10;
            $storageOk = is_writable(storage_path());
            $schedulerOk = Cache::has('scheduler_last_run');

            try {
                Cache::store('file')->forever('health_check', true);
                Cache::store('file')->forget('health_check');
                $cacheOk = true;
            } catch (\Exception) {
                $cacheOk = false;
            }

            $diskTotal = @disk_total_space(storage_path()) ?: 0;
            $diskFree = @disk_free_space(storage_path()) ?: 0;
            $diskUsed = $diskTotal > 0 ? round((($diskTotal - $diskFree) / $diskTotal) * 100, 1) : 0;

            $memUsage = round(memory_get_usage(true) / 1024 / 1024, 1);
            $memLimitRaw = ini_get('memory_limit');
            $memLimitBytes = $memLimitRaw !== false ? (int) $memLimitRaw : 0;
            if ($memLimitBytes > 0 && preg_match('/([+-]?\d+)([kmg]b?)?$/i', $memLimitRaw, $m)) {
                $memLimitBytes = (int) $m[1];
                $unit = strtolower($m[2] ?? 'b');
                if ($unit === 'k' || $unit === 'kb') {
                    $memLimitBytes *= 1024;
                } elseif ($unit === 'm' || $unit === 'mb') {
                    $memLimitBytes *= 1024 * 1024;
                } elseif ($unit === 'g' || $unit === 'gb') {
                    $memLimitBytes *= 1024 * 1024 * 1024;
                }
            }
            $memLimit = $memLimitBytes > 0 ? round($memLimitBytes / 1024 / 1024, 1) : -1;

            $okCount = collect([$storageOk, $queueOk, $cacheOk, $schedulerOk, $mysqlOk])->filter()->count();
            $totalChecks = 5;
            $healthPercent = round(($okCount / $totalChecks) * 100);
            $healthStatus = $healthPercent === 100 ? 'Optimal' : ($healthPercent >= 60 ? 'Perlu Perhatian' : 'Kritis');

            return [
                'php' => ['version' => $phpVersion, 'ok' => version_compare($phpVersion, '8.1', '>=')],
                'laravel' => ['version' => $laravelVersion, 'ok' => true],
                'mysql' => ['version' => $mysqlVersion, 'ok' => $mysqlOk],
                'queue' => ['version' => "{$failedJobs} failed", 'ok' => $queueOk],
                'storage' => ['version' => 'writable', 'ok' => $storageOk],
                'scheduler' => ['version' => $schedulerOk ? 'running' : 'unknown', 'ok' => $schedulerOk],
                'cache' => ['version' => config('cache.default'), 'ok' => $cacheOk],
                'disk_usage' => $diskUsed,
                'memory_usage' => $memUsage,
                'memory_limit' => $memLimit,
                'health_percent' => $healthPercent,
                'health_status' => $healthStatus,
            ];
        });
    }
}
