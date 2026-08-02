<?php

namespace App\Providers;

use App\Models\ActivityLog;
use App\Models\Berita;
use App\Models\Event;
use App\Models\PengajuanSurat;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;

class DashboardCacheProvider extends ServiceProvider
{
    public function boot(): void
    {
        PengajuanSurat::created(fn () => $this->clear());
        PengajuanSurat::updated(fn () => $this->clear());
        PengajuanSurat::deleted(fn () => $this->clear());

        User::created(fn () => $this->clear());
        User::updated(fn () => $this->clear());
        User::deleted(fn () => $this->clear());

        Berita::created(fn () => $this->clear());
        Berita::updated(fn () => $this->clear());
        Berita::deleted(fn () => $this->clear());

        Event::created(fn () => $this->clear());
        Event::updated(fn () => $this->clear());
        Event::deleted(fn () => $this->clear());

        ActivityLog::created(fn () => $this->clear());
    }

    public function clear(): void
    {
        $keys = [
            'dsh_stats_overview', 'dsh_stats_letter_dist', 'dsh_stats_analytics_summary',
            'dsh_workflow_pipeline', 'dsh_queue_status', 'dsh_health_check',
            'dsh_activity_recent', 'dsh_top_rtrw', 'dsh_village_info',
        ];

        foreach ($keys as $key) {
            Cache::forget($key);
        }

        // Clear old-style keys too
        $oldKeys = [
            'dashboard_stats', 'dashboard_workflow', 'dashboard_activities',
            'dashboard_queue', 'dashboard_health', 'dashboard_letter_dist',
            'dashboard_analytics_summary', 'dashboard_village',
        ];
        foreach ($oldKeys as $key) {
            Cache::forget($key);
        }
    }
}
