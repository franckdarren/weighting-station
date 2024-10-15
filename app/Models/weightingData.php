<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class weightingData extends Model
{
    protected $fillable = [
        'Numero',
        'Produits_transportes',
        'Provenance',
        'Destination',
        'Lineaire_parcouru',
        'Lineaire_restant',
        'Poids',
        'Surchage',
        'Vitesse',
        'Poids_E1',
        'Poids_E2',
        'Poids_E3',
        'Poids_E4',
        'Poids_E5',
        'Poids_E6',
        'Vehicule_id',
        'Conducteur_id'
        // 'id',
        // 'weighing1ID',
        // 'vehicleID',
        // 'plateFront',
        // 'plateBack',
        // 'vehicleType',
        // 'vehicleTypeOrdering',
        // 'date',
        // 'totalWeight',
        // 'overload',
        // 'companyID',
        // 'companyName',
        // 'materialID',
        // 'materialName',
        // 'scaleID',
        // 'userID',
        // 'sync',
        // 'scaleType',
        // 'isDeleted',
        // 'weighingDimensionId',
        // 'weighingNo',
        // 'unetSent',
        // 'totalWeightLimit',
        // 'totalWeightLimitTolerance',
        // 'emptyWeight',
        // 'speed',
        // 'isUnetSent'
    ];

    protected $table = 'bon_pesees';

    use HasFactory;
}
