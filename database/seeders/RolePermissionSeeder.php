<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Récupéreration des rôles
        $manager = Role::where('name', 'Manager')->first();
        $operateurPrimaire = Role::where('name', 'Opérateur primaire')->first();
        $operateurFacture = Role::where('name', 'Opérateur facture')->first();
        $operateurCaisse = Role::where('name', 'Opérateur caisse')->first();
        $administrateur = Role::where('name', 'Administrateur')->first();


        // Récupérer les permissions
        $createUsers = Permission::where('name', 'create users')->first();
        $editUsers = Permission::where('name', 'edit users')->first();
        $deleteUsers = Permission::where('name', 'delete users')->first();
        $viewUsers = Permission::where('name', 'view users')->first();

        $createFactures = Permission::where('name', 'create factures')->first();
        $editFactures = Permission::where('name', 'edit factures')->first();
        $deleteFactures = Permission::where('name', 'delete factures')->first();
        $viewFactures = Permission::where('name', 'view factures')->first();

        $viewCaisses = Permission::where('name', 'view caisses')->first();
        $editCaisses = Permission::where('name', 'edit caisses')->first();

        $viewRapports = Permission::where('name', 'view rapports')->first();
        $editRapports = Permission::where('name', 'edit rapports')->first();

        $viewReglementations = Permission::where('name', 'view reglementations')->first();

        $createPesée = Permission::where('name', 'create pesée')->first();
        $editPesée = Permission::where('name', 'edit pesée')->first();
        $deletePesée = Permission::where('name', 'delete pesée')->first();
        $viewPesée = Permission::where('name', 'view pesée')->first();

        // Assigner des permissions aux rôles
        $manager->givePermissionTo([
            $createFactures,
            $editFactures,
            $deleteFactures,
            $viewFactures,

            $createUsers,
            $editUsers,
            $deleteUsers,
            $viewUsers,

            $createPesée,
            $editPesée,
            $deletePesée,
            $viewPesée,

            $viewCaisses,
            $editCaisses,

            $viewRapports,
            $editRapports,

            $viewReglementations,
        ]);

        $operateurPrimaire->givePermissionTo([
            $viewPesée
        ]);

        $operateurFacture->givePermissionTo([
            $viewFactures,
        ]);

        $operateurCaisse->givePermissionTo([
            $viewCaisses,
            $editCaisses,

        ]);

        $administrateur->givePermissionTo([
            $createUsers,
            $editUsers,
            $deleteUsers,
            $viewUsers,
        ]);
    }
}
