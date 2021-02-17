<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Vehicle;

class Customer extends Model
{
    use HasFactory;
    protected $table = 'customer';
    protected $primaryKey = 'CustomerID';
 
    public function Vehicle()
    {
        return $this->hasMany(Vehicle::class,  'Reference', 'CustomerReference');
    }

}
