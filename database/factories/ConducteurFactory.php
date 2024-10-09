<?php

namespace Database\Factories;

use App\Models\Conducteur;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Conducteur>
 */
class ConducteurFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Conducteur::class;

    public function definition(): array
    {
        return [
            'nom' => $this->faker->lastName,
            'prenoms' => $this->faker->firstName,
            'permis_conduire' => $this->faker->bothify('PC-####-####'),
            'licence_transport' => $this->faker->bothify('LT-####-####'),
            'nature_piece_identite' => $this->faker->randomElement(['CNI', 'Passeport', 'Permis de conduire']),
            'numero_piece_identite' => $this->faker->bothify('PI-####-####'),
            'date_validite_piece_identite' => $this->faker->dateTimeBetween('now', '+5 years'),
        ];
    }
}
