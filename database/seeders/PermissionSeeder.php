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

        // Rapport
        Permission::create(['name' => 'create rapports']);
        Permission::create(['name' => 'edit rapports']);
        Permission::create(['name' => 'delete rapports']);
        Permission::create(['name' => 'view rapports']);

        // Caisse
        Permission::create(['name' => 'create caisses']);
        Permission::create(['name' => 'edit caisses']);
        Permission::create(['name' => 'delete caisses']);
        Permission::create(['name' => 'view caisses']);

        // Réglémentations
        Permission::create(['name' => 'create reglementations']);
        Permission::create(['name' => 'edit reglementations']);
        Permission::create(['name' => 'delete reglementations']);
        Permission::create(['name' => 'view reglementations']);
    }
}
