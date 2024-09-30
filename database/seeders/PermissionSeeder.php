<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // User
        Permission::create(['name' => 'create users']);
        Permission::create(['name' => 'edit users']);
        Permission::create(['name' => 'delete users']);
        Permission::create(['name' => 'view users']);

        // Facture
        Permission::create(['name' => 'create factures']);
        Permission::create(['name' => 'edit factures']);
        Permission::create(['name' => 'delete factures']);
        Permission::create(['name' => 'view factures']);

        // Pesée
        Permission::create(['name' => 'create pesée']);
        Permission::create(['name' => 'edit pesée']);
        Permission::create(['name' => 'delete pesée']);
        Permission::create(['name' => 'view pesée']);
    }
}
