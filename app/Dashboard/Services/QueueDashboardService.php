<?php

namespace App\Dashboard\Services;

use App\Models\PengajuanSurat;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class QueueDashboardService
{
    private const CACHE_TTL = 60;

    private const PREFIX = 'dsh_queue_';

    public function status(): array
    {
        return Cache::remember(self::PREFIX.'status', self::CACHE_TTL, function () {
            $waiting = DB::table('jobs')->count();
            $failed = DB::table('failed_jobs')->count();
            $running = DB::table('jobs')->whereNotNull('reserved_at')->count();
            $success = PengajuanSurat::where('status', 'completed')
                ->whereDate('updated_at', today())
                ->count();

            return [
                'waiting' => $waiting,
                'failed' => $failed,
                'running' => $running,
                'success' => $success,
            ];
        });
    }
}
