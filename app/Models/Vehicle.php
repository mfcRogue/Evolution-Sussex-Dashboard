<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;
    protected $table = 'vehicles';
  
    public function customer()
    {
        return $this->belongsTo(Customer::class,  'Reference', 'CustomerRefernce');
    }

}
