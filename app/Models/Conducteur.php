<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conducteur extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'prenoms',
        'permis_conduire',
        'licence_transport',
        'nature_piece_identite',
        'numero_piece_identite',
        'date_validite_piece_identite',
    ];


    public function bonPesees()
    {
        return $this->hasMany(BonPesee::class);
    }
}
