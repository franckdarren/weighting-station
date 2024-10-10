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
    protected $model = BonPesee::class;

    public function definition(): array
    {

        // Récupération d'un véhicule aléatoire
        $vehicule = Vehicule::inRandomOrder()->first();

        // Récupéreration de la limite de poids du type de véhicule associé
        $limite_poids = $vehicule->typeVehicule->limite_poids;

        // Génération d'un poids aléatoire qui respecte certaines conditions
        $poids = $this->faker->numberBetween(70000, ($limite_poids + 25000));

        // Calcul de la surcharge
        $surcharge = 0;
        if ($poids > $limite_poids) {
            $surcharge = $poids - $limite_poids;
        }

        // Génération des poids aléatoires pour poids_E1 à poids_E6 avec les nouvelles contraintes
        $parts = $this->randomWeightDistribution($poids, $surcharge);

        return [
            'produits_transportes' => $this->faker->randomElement(['DEBITE OKOUME', 'BANANE', 'METAL', 'GRAVIER', 'MANGANESE']),
            'provenance' => $this->faker->city,
            'destination' => $this->faker->city,
            'lineaire_parcouru' => $this->faker->numberBetween(10, 200),
            'lineaire_restant' => $this->faker->numberBetween(10, 200),
            'vitesse' => $this->faker->randomFloat(2, 5, 10),
            'poids' => $poids,
            'surchage' => $surcharge,
            'vehicule_id' => $vehicule->id,
            'conducteur_id' => Conducteur::inRandomOrder()->first()->id,

            'poids_E1' => $parts[0],
            'poids_E2' => $parts[1],
            'poids_E3' => $parts[2],
            'poids_E4' => $parts[3],
            'poids_E5' => $parts[4],
            'poids_E6' => $parts[5],
        ];
    }

    /**
     * Répartir un poids total en 6 parties aléatoires dont la somme est égale à $poids
     * avec une contrainte de minimum et maximum pour chaque partie.
     */
    private function randomWeightDistribution(int $poids, int $surcharge): array
    {
        // Définir les limites de poids pour chaque section
        $minWeight = 5000;
        $maxWeight = 14000;

        // Si la surcharge est présente, ajuster les limites
        if ($surcharge > 0) {
            $maxWeight = $poids; // Pas de limite supérieure si surcharge
        }

        $weights = [];

        // Répartir aléatoirement les poids avec les contraintes
        $remainingWeight = $poids;
        for ($i = 0; $i < 5; $i++) {
            // Générer un poids aléatoire dans les limites
            $weight = $this->faker->numberBetween($minWeight, min($maxWeight, $remainingWeight - ($minWeight * (5 - $i))));

            $weights[] = $weight;
            $remainingWeight -= $weight;
        }

        // Le dernier poids prend le reste
        $weights[] = $remainingWeight;

        return $weights;
    }
}
