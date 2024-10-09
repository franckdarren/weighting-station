<?php

namespace App\Providers;

use App\Models\BonPesee;
use App\Observers\BonPeseeObserver;
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
        //Observable pour la création automatique des pvs
        BonPesee::observe(BonPeseeObserver::class);
    }
}
