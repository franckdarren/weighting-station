<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FactureImmobilisation extends Model
{
    use HasFactory;

    protected $fillable = [
        'numero',
        'date_sortie',
        'duree_immobilisation',

        'bon_immobilisation_id',
        'quittance_pesage_id',
    ];


    public function bonImmobilisation()
    {
        return $this->belongsTo(BonImmobilisation::class);
    }
}
