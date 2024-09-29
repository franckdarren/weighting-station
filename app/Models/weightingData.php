<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class weightingData extends Model
{
    protected $fillable = [
        'id',
        'weighing1ID',
        'vehicleID',
        'plateFront',
        'plateBack',
        'vehicleType',
        'vehicleTypeOrdering',
        'date',
        'totalWeight',
        'overload',
        'companyID',
        'companyName',
        'materialID',
        'materialName',
        'scaleID',
        'userID',
        'sync',
        'scaleType',
        'isDeleted',
        'weighingDimensionId',
        'weighingNo',
        'unetSent',
        'totalWeightLimit',
        'totalWeightLimitTolerance',
        'emptyWeight',
        'speed',
        'isUnetSent'
    ];

    protected $table = 'weighting_data';

    use HasFactory;
}
