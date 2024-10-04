<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BonImmobilisation extends Model
{
    use HasFactory;

    protected $fillable = [
        'numero',
        'date_entree',
        'duree',
        'emplacement',
        'nom_prenoms_client',
        'nature_piece_identite',
        'numero_piece_identite',
        'date_validite_piece_identite',

        'pv_id',
        'facture_immobilisation_id',
    ];


    public function factureImmobilisation()
    {
        return $this->hasOne(FactureImmobilisation::class);
    }

    public function pv()
    {
        return $this->belongsTo(Pv::class);
    }
}
