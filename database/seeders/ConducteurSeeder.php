<?php

namespace Database\Seeders;

use App\Models\Conducteur;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ConducteurSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Conducteur::factory()->count(20)->create();
    }
}
