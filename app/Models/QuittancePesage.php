<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuittancePesage extends Model
{
    use HasFactory;

    protected $fillable = [
        'numero',
        'duree_operation',
        'tarif',

        'bon_pesee_id',
        'pv_id',
        'facture_immobilisation_id',
    ];


    public function bonPesee()
    {
        return $this->belongsTo(BonPesee::class);
    }

    public function pv()
    {
        return $this->belongsTo(Pv::class);
    }

    public function factureImmobilisation()
    {
        return $this->belongsTo(FactureImmobilisation::class);
    }
}
