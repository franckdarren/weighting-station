<?php

namespace App\Observers;

use App\Models\Pv;
use App\Models\BonPesee;
use App\Models\FacturePesage;

class BonPeseeObserver
{
    /**
     * Handle the BonPesee "created" event.
     */
    public function created(BonPesee $bonPesee): void
    {
        // Vérifie si la vitesse est entre 5 et 8km/h
        if ($bonPesee->vitesse >= 5 && $bonPesee->vitesse <= 8) {
            // Vérifie si la surcharge est supérieure à 0 pour créer un PV
            if ($bonPesee->surchage > 0) {
                $pv = Pv::create([
                    'surchage_e1' => $bonPesee->poids_E1 > 14000 ? $bonPesee->poids_E1 - 14000 : 0,
                    'surchage_e2' => $bonPesee->poids_E2 > 14000 ? $bonPesee->poids_E2 - 14000 : 0,
                    'surchage_e3' => $bonPesee->poids_E3 > 14000 ? $bonPesee->poids_E3 - 14000 : 0,
                    'surchage_e4' => $bonPesee->poids_E4 > 14000 ? $bonPesee->poids_E4 - 14000 : 0,
                    'surchage_e5' => $bonPesee->poids_E5 > 14000 ? $bonPesee->poids_E5 - 14000 : 0,
                    'surchage_e6' => $bonPesee->poids_E6 > 14000 ? $bonPesee->poids_E6 - 14000 : 0,
                    'amendes_surchage_e1' => $bonPesee->poids_E1 > 14000 ? ($bonPesee->poids_E1 - 14000) * 75 : 0,
                    'amendes_surchage_e2' => $bonPesee->poids_E2 > 14000 ? ($bonPesee->poids_E2 - 14000) * 75 : 0,
                    'amendes_surchage_e3' => $bonPesee->poids_E3 > 14000 ? ($bonPesee->poids_E3 - 14000) * 75 : 0,
                    'amendes_surchage_e4' => $bonPesee->poids_E4 > 14000 ? ($bonPesee->poids_E4 - 14000) * 75 : 0,
                    'amendes_surchage_e5' => $bonPesee->poids_E5 > 14000 ? ($bonPesee->poids_E5 - 14000) * 75 : 0,
                    'amendes_surchage_e6' => $bonPesee->poids_E6 > 14000 ? ($bonPesee->poids_E6 - 14000) * 75 : 0,
                    'montant_amendes' => ($bonPesee->poids_E1 > 14000 ? ($bonPesee->poids_E1 - 14000) * 75 : 0) +
                        ($bonPesee->poids_E2 > 14000 ? ($bonPesee->poids_E2 - 14000) * 75 : 0) +
                        ($bonPesee->poids_E3 > 14000 ? ($bonPesee->poids_E3 - 14000) * 75 : 0) +
                        ($bonPesee->poids_E4 > 14000 ? ($bonPesee->poids_E4 - 14000) * 75 : 0) +
                        ($bonPesee->poids_E5 > 14000 ? ($bonPesee->poids_E5 - 14000) * 75 : 0) +
                        ($bonPesee->poids_E6 > 14000 ? ($bonPesee->poids_E6 - 14000) * 75 : 0),
                    'bon_pesee_id' => $bonPesee->id,
                ]);

                // Création de la facture avec PV lié
                FacturePesage::create([
                    'type' => 'Surcharge',
                    'forfait_usage' => 8500,
                    'montant_total' => $pv->montant_amendes + 8500,
                    'bon_pesee_id' => $bonPesee->id,
                    'pv_id' => $pv->id,
                ]);
            } else {
                // Si la surcharge est nulle, création de la facture sans PV
                FacturePesage::create([
                    'type' => 'Normal',
                    'forfait_usage' => 8500,
                    'montant_total' => 8500,
                    'bon_pesee_id' => $bonPesee->id,
                ]);
            }
        }
    }


    /**
     * Handle the BonPesee "updated" event.
     */
    public function updated(BonPesee $bonPesee): void
    {
        //
    }

    /**
     * Handle the BonPesee "deleted" event.
     */
    public function deleted(BonPesee $bonPesee): void
    {
        //
    }

    /**
     * Handle the BonPesee "restored" event.
     */
    public function restored(BonPesee $bonPesee): void
    {
        //
    }

    /**
     * Handle the BonPesee "force deleted" event.
     */
    public function forceDeleted(BonPesee $bonPesee): void
    {
        //
    }

    // private function generateIncrementedPvNumber()
    // {
    //     // Récupérer le dernier PV créé
    //     $lastPv = Pv::orderBy('id', 'desc')->first();

    //     if (!$lastPv) {
    //         // Si aucun PV n'existe encore, retourner le premier numéro
    //         return '00001';
    //     }

    //     // Extraire la partie numérique du dernier numéro de PV
    //     $lastNumber = (int) str_replace('PV-', '', $lastPv->numero);

    //     // Incrémenter le numéro
    //     $newNumber = $lastNumber + 1;

    //     // Retourner le nouveau numéro formaté avec 5 chiffres
    //     return str_pad($newNumber, 5, '0', STR_PAD_LEFT);
    // }
}
