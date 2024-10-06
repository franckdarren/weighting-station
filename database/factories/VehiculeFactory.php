<?php

namespace Database\Factories;

use App\Models\Vehicule;
use App\Models\TypeVehicule;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vehicule>
 */
class VehiculeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Vehicule::class;

    public function definition(): array
    {
        return [
            'plaque_immatriculation' => strtoupper($this->faker->bothify('??-###-??')),
            'carte_grise' => $this->faker->unique()->bothify('####-####-####'),
            'statut' => $this->faker->randomElement(['Particulier', 'Entreprise']),
            'nom_proprietaire' => $this->faker->name,
            'entreprise' => $this->faker->company,
            'en_convoi' => false,
            'nb_vehicule' => 0,
            'type_vehicule_id' => TypeVehicule::inRandomOrder()->first()->id,
        ];
    }
}
