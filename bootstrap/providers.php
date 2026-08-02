<?php

use App\Providers\AppServiceProvider;
use App\Providers\DashboardCacheProvider;
use App\Providers\VillageSettingServiceProvider;

return [
    AppServiceProvider::class,
    VillageSettingServiceProvider::class,
    DashboardCacheProvider::class,
];
