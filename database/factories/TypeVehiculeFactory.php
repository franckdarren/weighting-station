<?php

namespace Database\Factories;

use App\Models\TypeVehicule;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TypeVehicule>
 */
class TypeVehiculeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = TypeVehicule::class;

    public function definition(): array
    {
        // Générer une valeur pour limite_poids
        $limite_poids = $this->faker->numberBetween(30000, 70000);

        return [
            'nom' => 'VEHICULE A ESSIEUX',
            'limite_poids' => $limite_poids,
            'tolerance_limite_poids' => $limite_poids,
            'nb_essieux' => 6,
            'nb_groupe_essieux' => 3,
            
        ];
    }
}
