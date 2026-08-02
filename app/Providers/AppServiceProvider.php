<?php

namespace App\Providers;

use App\Dashboard\WidgetFactory;
use App\Dashboard\WidgetManager;
use App\Dashboard\WidgetRegistry;
use App\Models\Berita;
use App\Models\DocumentVersion;
use App\Models\Event;
use App\Models\PengajuanSurat;
use App\Models\User;
use App\Policies\BeritaPolicy;
use App\Policies\DocumentVersionPolicy;
use App\Policies\EventPolicy;
use App\Policies\PengajuanSuratPolicy;
use App\Policies\UserPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(WidgetRegistry::class);
        $this->app->singleton(WidgetFactory::class);
        $this->app->singleton(WidgetManager::class);
    }

    public function boot(): void
    {
        Gate::policy(PengajuanSurat::class, PengajuanSuratPolicy::class);
        Gate::policy(User::class, UserPolicy::class);
        Gate::policy(Berita::class, BeritaPolicy::class);
        Gate::policy(Event::class, EventPolicy::class);
        Gate::policy(DocumentVersion::class, DocumentVersionPolicy::class);
    }
}
