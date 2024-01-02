<?php

namespace App\Models\Catalogs;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'fee', 'recurrent'
    ];


    public function vehicle(){
        return $this->hasMany(Vehicle::class);
    }
}
