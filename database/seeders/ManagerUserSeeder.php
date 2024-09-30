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
    }
}
