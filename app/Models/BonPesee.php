<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BonPesee extends Model
{
    use HasFactory;

    protected $fillable = [
        'numero',
        'produits_transportes',
        'provenance',
        'destination',
        'lineaire_parcouru',
        'lineaire_restant',
        'poids',
        'surchage',
        'vitesse',

        'poids_E1',
        'poids_E2',
        'poids_E3',
        'poids_E4',
        'poids_E5',
        'poids_E6',


        'vehicule_id',
        'conducteur_id',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($bonPesee) {
            // Récupérer le dernier bon de pesée
            $lastBonPesee = self::orderBy('id', 'desc')->first();

            // Déterminer le prochain numéro
            if ($lastBonPesee) {
                $lastId = (int) str_replace('BP-', '', $lastBonPesee->numero);
                $nextId = $lastId + 1;
            } else {
                $nextId = 1; // Premier bon de pesée
            }

            // Générer le numéro
            $bonPesee->numero = 'BP-' . str_pad($nextId, 6, '0', STR_PAD_LEFT);
        });
    }


    public function vehicule()
    {
        return $this->belongsTo(Vehicule::class);
    }

    public function conducteur()
    {
        return $this->belongsTo(Conducteur::class);
    }

    public function FacturePesage()
    {
        return $this->hasOne(FacturePesage::class);
    }

    public function pv()
    {
        return $this->hasOne(Pv::class);
    }
}
