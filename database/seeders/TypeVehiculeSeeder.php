<?php

namespace Database\Seeders;

use App\Models\TypeVehicule;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TypeVehiculeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TypeVehicule::factory()->count(5)->create();
    }
}
