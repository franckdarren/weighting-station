<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['name' => 'Manager']);
        Role::create(['name' => 'Opérateur primaire']);
        Role::create(['name' => 'Opérateur facture']);
        Role::create(['name' => 'Opérateur caisse']);
        Role::create(['name' => 'Administrateur']);
    }
}
