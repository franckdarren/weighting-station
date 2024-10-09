<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacturePesage extends Model
{
    use HasFactory;

    protected $fillable = [
        'numero',
        'type',
        'forfait_usage',
        'montant_total',
        'statut',

        'bon_pesee_id',
        'pv_id',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($facture) {
            // Récupérer la derniere facture
            $lastFacture = self::orderBy('id', 'desc')->first();

            // Déterminer le prochain numéro
            if ($lastFacture) {
                $lastId = (int) str_replace('F-', '', $lastFacture->numero);
                $nextId = $lastId + 1;
            } else {
                $nextId = 1; // Premiere facture
            }

            // Générer le numéro
            $facture->numero = 'F-' . $nextId;
        });
    }

    public function bonPesee()
    {
        return $this->belongsTo(BonPesee::class);
    }

    public function pv()
    {
        return $this->belongsTo(Pv::class);
    }
}
