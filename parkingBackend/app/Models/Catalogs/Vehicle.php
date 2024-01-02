<?php

namespace App\Models\Catalogs;

use App\Models\Transactions\DetailStay;
use App\Models\Transactions\PayRecord;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;


    protected $fillable = [
        'vehicle_type_id',
        'license_plate',
        'owner_name'
    ];

    public function vehicleType()
    {
        return $this->belongsTo(VehicleType::class, 'vehicle_type_id');
    }

    public function detailStay()
    {
        return $this->hasMany(DetailStay::class);
    }

    public function payRecord()
    {
        return $this->hasMany(PayRecord::class);
    }
}
