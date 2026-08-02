<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Cache;

class ClearDashboardCache
{
    public function handle(object $event): void
    {
        $prefixes = [
            'dsh_stats_',
            'dsh_workflow_',
            'dsh_queue_',
            'dsh_health_',
            'dsh_activity_',
            'dsh_top_rtrw',
            'dsh_village_info',
        ];

        foreach ($prefixes as $prefix) {
            Cache::tags([$prefix])->flush();
        }

        // Also clear by prefix pattern
        $tags = ['dashboard_stats', 'dashboard_workflow', 'dashboard_activities', 'dashboard_queue', 'dashboard_health'];
        foreach ($tags as $tag) {
            Cache::forget($tag);
            Cache::forget("{$tag}_dist");
            Cache::forget("{$tag}_analytics_summary");
        }

        // Clear all dashboard cache keys
        $cacheKeys = [
            'dashboard_stats', 'dashboard_workflow', 'dashboard_activities',
            'dashboard_queue', 'dashboard_health', 'dashboard_letter_dist',
            'dashboard_analytics_summary', 'dashboard_village',
        ];
        foreach ($cacheKeys as $key) {
            Cache::forget($key);
            Cache::forget("{$key}_dist");
        }
    }
}
