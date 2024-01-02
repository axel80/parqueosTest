<?php

namespace App\Models\Transactions;

use App\Models\Catalogs\Vehicle;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayRecord extends Model
{
    use HasFactory;
    protected $fillable = [
        'vehicle_id',
        'license_plate',
        'total_stay_minutes',
        'total_stay_payment',
        'date_time_payment',
        'period_start',
        'period_end'
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
}
