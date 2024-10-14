<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class ManagerUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer l'utilisateur manager
        $manager = User::create([
            'name' => 'Default Manager',
            'code' => 'Manager',
            'email' => 'manager@manager.com',
            'password' => bcrypt('password'), // Changez le mot de passe si nécessaire
        ]);

        $role = Role::where('name', 'Manager')->first();

        if ($role) {
            $manager->assignRole($role);
        } else {
            $this->command->error('Le rôle Manager n\'existe pas dans la base de données.');
        }

        // Créer l'utilisateur Opérateur primaire
        $primaire = User::create([
            'name' => 'Opérateur Primaire',
            'code' => 'Primaire',
            'email' => 'primaire@primaire.com',
            'password' => bcrypt('password'), // Changez le mot de passe si nécessaire
        ]);

        $role = Role::where('name', 'Opérateur primaire')->first();

        if ($role) {
            $primaire->assignRole($role);
        } else {
            $this->command->error('Le rôle Opérateur primaire n\'existe pas dans la base de données.');
        }

        // Créer l'utilisateur Opérateur facture
        $facture = User::create([
            'name' => 'Opérateur Facture',
            'code' => 'Facture',
            'email' => 'facture@facture.com',
            'password' => bcrypt('password'), // Changez le mot de passe si nécessaire
        ]);

        $role = Role::where('name', 'Opérateur facture')->first();

        if ($role) {
            $facture->assignRole($role);
        } else {
            $this->command->error('Le rôle Opérateur facture n\'existe pas dans la base de données.');
        }

        // Créer l'utilisateur Opérateur caisse
        $caisse = User::create([
            'name' => 'Opérateur Caisse',
            'code' => 'Caisse',
            'email' => 'caisse@caisse.com',
            'password' => bcrypt('password'), // Changez le mot de passe si nécessaire
        ]);

        $role = Role::where('name', 'Opérateur caisse')->first();

        if ($role) {
            $caisse->assignRole($role);
        } else {
            $this->command->error('Le rôle Opérateur caisse n\'existe pas dans la base de données.');
        }

        // Créer l'utilisateur Administrateur
        $caisse = User::create([
            'name' => 'Administrateur',
            'code' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('password'), // Changez le mot de passe si nécessaire
        ]);

        $role = Role::where('name', 'Administrateur')->first();

        if ($role) {
            $caisse->assignRole($role);
        } else {
            $this->command->error('Le rôle Opérateur Administrateur n\'existe pas dans la base de données.');
        }
    }
}
