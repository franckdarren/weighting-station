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

        // Récupéreration de la limite de poids du type de véhicule associé
        $limite_poids = 84000;

        // Génération d'un poids aléatoire qui respecte certaines conditions
        $poids = $this->faker->numberBetween(70000, ($limite_poids + 25000));

        // Calcul de la surcharge
        $surcharge = 0;
        if ($poids > $limite_poids) {
            $surcharge = $poids - $limite_poids;
        }

        // Génération des poids aléatoires pour poids_E1 à poids_E6 avec les nouvelles contraintes
        $parts = $this->randomWeightDistribution($poids, $surcharge);

        // Génération de la vitesse
        $vitesse = $this->faker->randomFloat(2, 3, 10);

        // Déterminer la description en fonction de la vitesse
        if ($vitesse > 8) {
            $description = 'Excès de vitesse';
        } elseif ($vitesse < 5) {
            $description = 'Vitesse trop basse';
        } else {
            $description = 'Vitesse normale';
        }

        return [
            'produits_transportes' => $this->faker->randomElement(['DEBITE OKOUME', 'BANANE', 'METAL', 'GRAVIER', 'MANGANESE']),
            'vitesse' => $vitesse,
            'plaque_immatriculation'  => strtoupper($this->faker->bothify('??-###-??')),
            'entreprise' => $this->faker->company,
            'description' => $description,
            'poids' => $poids,
            'surchage' => $surcharge,

            'poids_E1' => $parts[0],
            'poids_E2' => $parts[1],
            'poids_E3' => $parts[2],
            'poids_E4' => $parts[3],
            'poids_E5' => $parts[4],
            'poids_E6' => $parts[5],
            'poids_E7' => $parts[6],

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
        for ($i = 0; $i < 6; $i++) {
            // Générer un poids aléatoire dans les limites
            $weight = $this->faker->numberBetween($minWeight, min($maxWeight, $remainingWeight - ($minWeight * (6 - $i))));

            $weights[] = $weight;
            $remainingWeight -= $weight;
        }

        // Le dernier poids prend le reste
        $weights[] = $remainingWeight;

        return $weights;
    }
}
