<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeVehicule extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'limite_poids',
        'tolerance_limite_poids',
        'nb_essieux',
        'nb_groupe_essieux',
    ];

    public function vehicules()
    {
        return $this->hasMany(Vehicule::class);
    }
}
