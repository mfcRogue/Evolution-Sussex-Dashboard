<?php

namespace App\Http\Livewire\Vehicles\Count;

use Livewire\Component;
//use Illuminate\Support\Facades\DB;
use App\Models\Vehicle;
use App\Models\Customer;

class CombinedReminders extends Component
{
    public function render()
    {

       //get month +1
        $month = date('m', strtotime(now()->addMonth()));
        //if month is december next year is required
        if($month == 12)
        {
            $year = date('Y', strtotime(now()->addYear()));
        }
        else
        {
            $year = date('Y', strtotime(now()));
        }
        

        $vehicle = Vehicle::has('Customer')
    
        ->whereBetween('ServDueDate', [$year.'-'.$month.'-01', $year.'-'.$month.'-31'])
        ->whereBetween('MOTDueDate', [$year.'-'.$month.'-01', $year.'-'.$month.'-31'])
        ->count();
        
        //dd($vehicle);
        //$count = 0;
        //foreach($vehicle as $veh_data)
        //{
        //    $vehicle= $count++;
        //}
        
            
            
            //dd($veh_data->customer->Reference);        
        //dd($vehicle);




        //$vehicle = 79;

        return view('livewire.vehicles.count.combined-reminders', ['combined_due'=>$vehicle]);
    }
}
