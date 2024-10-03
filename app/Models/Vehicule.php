<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicule extends Model
{
    use HasFactory;

    protected $fillable = [
        'plaque_immatriculation',
        'carte_grise',
        'statut',
        'nom_proprietaire',
        'entreprise',
        'en_convoi',
        'nb_vehicule',
        'type_vehicule_id',
    ];

    public function bonPesees()
    {
        return $this->hasMany(BonPesee::class);
    }

    public function typeVehicule()
    {
        return $this->belongsTo(TypeVehicule::class);
    }
}
