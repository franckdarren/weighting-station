<?php

namespace Database\Seeders;

use App\Models\BonPesee;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BonPeseeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BonPesee::factory()->count(100)->create();
    }
}
