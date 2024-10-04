<?php

namespace Database\Factories;

use App\Models\BonPesee;
use App\Models\Vehicule;
use App\Models\Conducteur;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BonPesee>
 */
class BonPeseeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = BonPesee::class;

    public function definition(): array
    {
        // Récupération d'un véhicule aléatoire
        $vehicule = Vehicule::inRandomOrder()->first();

        // Récupéreration de la limite de poids du type de véhicule associé
        $limite_poids = $vehicule->typeVehicule->limite_poids;

        // Généreration d'un poids aléatoire qui respecte certaines conditions
        $poids = $this->faker->numberBetween(30000, ($limite_poids + 15000));

        // Calcule de la surcharge
        $surcharge = 0;
        if ($poids > $limite_poids) {
            $surcharge = $poids - $limite_poids;
        }

        return [
            'numero' => $this->faker->unique()->bothify('BP-#####'),
            'produits_transportes' => $this->faker->randomElement(['DEBITE OKOUME', 'BANANE', 'METAL', 'GRAVIER', 'MANGANESE']),
            'provenance' => $this->faker->city,
            'destination' => $this->faker->city,
            'lineaire_parcouru' => $this->faker->numberBetween(10, 200),
            'lineaire_restant' => $this->faker->numberBetween(10, 200),
            'vitesse' => $this->faker->randomFloat(2, 5, 8),
            'poids' => $poids,
            'surchage' => $surcharge,
            'vehicule_id' => $vehicule->id,
            'conducteur_id' => Conducteur::inRandomOrder()->first()->id,
        ];
    }
}
