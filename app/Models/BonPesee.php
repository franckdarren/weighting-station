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

        'vehicule_id',
        'conducteur_id',
    ];


    public function vehicule()
    {
        return $this->belongsTo(Vehicule::class);
    }

    public function conducteur()
    {
        return $this->belongsTo(Vehicule::class);
    }

    public function quittancePesage()
    {
        return $this->hasOne(QuittancePesage::class);
    }

    public function pv()
    {
        return $this->hasOne(Pv::class);
    }
}
