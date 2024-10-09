<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Filament\Notifications\Livewire\DatabaseNotifications;

class FilamentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Ajout de l'écoute des notifications dans la méthode boot
        DatabaseNotifications::trigger('filament.notifications.database-notifications-trigger');
    }
}
