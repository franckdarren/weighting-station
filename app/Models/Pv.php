<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pv extends Model
{
    use HasFactory;

    protected $fillable = [
        'numero',
        'surchage_e1',
        'surchage_e2',
        'surchage_e3',
        'surchage_e4',
        'surchage_e5',
        'surchage_e6',

        'amendes_surchage_e1',
        'amendes_surchage_e2',
        'amendes_surchage_e3',
        'amendes_surchage_e4',
        'amendes_surchage_e5',
        'amendes_surchage_e6',

        'montant_amendes',

        'bon_pesee_id',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($pv) {
            // Récupérer le dernier pv
            $lastPv = self::orderBy('id', 'desc')->first();

            // Déterminer le prochain numéro
            if ($lastPv) {
                $lastId = (int) str_replace('PV-', '', $lastPv->numero);
                $nextId = $lastId + 1;
            } else {
                $nextId = 1; // Premier pv
            }

            // Générer le numéro
            $pv->numero = 'PV-' . $nextId;
        });
    }

    public function bonPesee()
    {
        return $this->belongsTo(BonPesee::class);
    }

    public function FacturePesage()
    {
        return $this->hasOne(FacturePesage::class);
    }
}
