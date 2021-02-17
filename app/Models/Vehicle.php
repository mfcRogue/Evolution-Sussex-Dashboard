<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Customer;

class Vehicle extends Model
{
    use HasFactory;
    protected $table = 'vehicles';
    protected $primaryKey = 'VehicleID';
   
    public function Customer()
    {

        return $this->belongsTo(Customer::class,  'CustomerReference', 'Reference')
        ->where('Reference', '<>', 'INTERNAL');
    }

}
