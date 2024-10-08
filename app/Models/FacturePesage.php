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


    public function bonPesee()
    {
        return $this->belongsTo(BonPesee::class);
    }

    public function pv()
    {
        return $this->belongsTo(Pv::class);
    }
}
