<?php

namespace App\Http\Livewire\Vehicles;

use Livewire\Component;


class Reminder extends Component
{
    public function render()
    {
        //get month
        $month = date('m', strtotime(now()->addMonth()));
        if($month == 12)
        {
            $year = date('Y', strtotime(now()->addYear()));    
        }
        else
        {
            $year = date('Y', strtotime(now()));
        }



foreach ($post->RegNo as $Regno) {
    echo"$Regno";
}
        return view('livewire.vehicles.reminder', ['year' => $year]);
    }
}
