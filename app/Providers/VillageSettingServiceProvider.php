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
            }
        } catch (\Throwable $e) {
            // table not ready yet (migration pending)
        }
    }
}
