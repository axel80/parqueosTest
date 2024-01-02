<?php

namespace App\Models\Transactions;

use App\Models\Catalogs\Vehicle;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailStay extends Model
{
    use HasFactory;

    protected $fillable = [
        'vehicle_id', 'check_in_type', 'check_out_time', 'payment_amunt', 'total_stay_minutes'
    ];

    public function vehicle(){
        return $this->belongsTo(Vehicle::class);
    }

}
