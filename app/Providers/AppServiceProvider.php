<?php

namespace App\Providers;

use App\Models\Ders;
use App\Models\Episode;
use App\Observers\DersObserver;
use App\Observers\EpisodeObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Ders::observe(DersObserver::class);
        Episode::observe(EpisodeObserver::class);
    }
}
