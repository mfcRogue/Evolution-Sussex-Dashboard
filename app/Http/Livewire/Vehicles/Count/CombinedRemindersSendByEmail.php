<?php

namespace App\Http\Livewire\Vehicles\Count;

use Livewire\Component;
//use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Vehicle;
use App\Models\Customer;


class CombinedRemindersSendByEmail extends Component
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

        $vehicle = Vehicle::has('Customer')
        ->whereBetween('ServDueDate', [$year.'-'.$month.'-01', $year.'-'.$month.'-31'])
        ->whereBetween('MOTDueDate', [$year.'-'.$month.'-01', $year.'-'.$month.'-31'])
        ->where('CustomerReference', '<>', 'INTERNAL')
        //->get();
        
        $combined_email_send = 0;
        foreach($vehicle as $veh_data)
        {
            
            $cust_email = $veh_data->customer['Email'];
            $cust_email2 = $veh_data->customer['Email2'];
            if($cust_email <> '' or $cust_email2 <> '')
            {
                $combined_email_send++;
            }
       
        }
        return view('livewire.vehicles.count.combined-reminders-send-by-email', ['combined_email_send'=>$combined_email_send]);
    }
}
