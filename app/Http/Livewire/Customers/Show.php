<?php

namespace App\Http\Livewire\Customers;


use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Show extends Component
{
    public function render()
    {

        $customers = DB::table('customer')->paginate(25);
        return view('livewire.customers.show' , ['customers' => $customers]);
    }
}
