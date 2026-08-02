<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;

class ClearDashboardCache
{
    public function handle(): void
    {
        $keys = [
            'dsh_stats_overview', 'dsh_stats_letter_dist', 'dsh_stats_analytics_summary',
            'dsh_workflow_pipeline', 'dsh_queue_status', 'dsh_health_check',
            'dsh_activity_recent', 'dsh_top_rtrw', 'dsh_village_info',
        ];

        foreach ($keys as $key) {
            Cache::forget($key);
        }

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
