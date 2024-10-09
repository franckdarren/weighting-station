<?php

namespace App\Listeners;
use Illuminate\Auth\Events\Login;
use Spatie\Activitylog\Models\Activity;

use IlluminateAuthEventsLogin;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LogSuccessfulLogin
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Login $event): void
    {
        activity()
            ->causedBy($event->user)
            ->log('Utilisateur connecté');
    }
}
