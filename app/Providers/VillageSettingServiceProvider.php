<?php

namespace App\Providers;

use App\Models\VillageSetting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class VillageSettingServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        try {
            if (Schema::hasTable('village_settings')) {
                $settings = VillageSetting::pluck('value', 'key')->toArray();
                config(['village' => $settings]);

                if (! empty($settings['security_session_timeout'])) {
                    config(['session.lifetime' => (int) $settings['security_session_timeout']]);
                }

                if (! empty($settings['queue_driver'])) {
                    config(['queue.default' => $settings['queue_driver']]);
                }

                if (! empty($settings['queue_timeout'])) {
                    config(['queue.connections.database.retry_after' => (int) $settings['queue_timeout']]);
                    config(['queue.connections.redis.retry_after' => (int) $settings['queue_timeout']]);
                }
            }
        } catch (\Throwable $e) {
            // table not ready yet (migration pending)
        }
    }
}
