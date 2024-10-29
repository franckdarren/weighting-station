<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Fortify\Fortify;
use Laravel\Jetstream\Jetstream;
use Illuminate\Support\Facades\Hash;
use App\Actions\Jetstream\DeleteUser;
use Illuminate\Support\ServiceProvider;

class JetstreamServiceProvider extends ServiceProvider
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
        Fortify::authenticateUsing(function (Request $request) {
            $user = User::where('email', $request->email)->first();

            if ($user && Hash::check($request->password, $user->password)) {
                // Vérifier le statut de l'utilisateur
                if ($user->status === 'Actif') {
                    return $user;
                } elseif ($user->status === 'Suspendu') {
                    // Message d'erreur pour un utilisateur suspendu
                    session()->flash('auth_error', 'Votre compte est suspendu.');
                    return null;
                } elseif ($user->status === 'Désactivé') {
                    // Message d'erreur pour un utilisateur désactivé
                    session()->flash('auth_error', 'Votre compte a été désactivé.');
                    return null;
                }
            }

            // Message d'erreur général pour email/mot de passe incorrects
            session()->flash('auth_error', 'Les informations de connexion sont incorrectes.');
            return null;
        });

        $this->configurePermissions();

        Jetstream::deleteUsersUsing(DeleteUser::class);
    }


    /**
     * Configure the permissions that are available within the application.
     */
    protected function configurePermissions(): void
    {
        Jetstream::defaultApiTokenPermissions(['read']);

        Jetstream::permissions([
            'create',
            'read',
            'update',
            'delete',
        ]);
    }
}
