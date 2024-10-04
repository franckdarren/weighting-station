<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pv extends Model
{
    use HasFactory;

    protected $fillable = [
        'numero',
        'bon_pesee_id',
    ];


    public function bonImmobilisation()
    {
        return $this->hasOne(BonImmobilisation::class);
    }

    public function quittancePesage()
    {
        return $this->hasOne(QuittancePesage::class);
    }

    public function bonPesee()
    {
        return $this->belongsTo(BonPesee::class);
    }
}
