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
 
    public function vehicle()
    {
        return $this->hasMany('app\Models\Vehicle',  'CustomerReference', 'Reference');
    }

}
