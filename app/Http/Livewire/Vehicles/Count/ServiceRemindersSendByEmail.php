<?php

namespace App\Http\Livewire\Vehicles\Count;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class ServiceRemindersSendByEmail extends Component
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
         $service_due = DB::table('vehicles')
         ->whereBetween('ServDueDate', [$year.'-'.$month.'-01', $year.'-'.$month.'-31'])
         ->whereNotBetween('MOTDueDate', [$year.'-'.$month.'-01', $year.'-'.$month.'-31'])
         ->get();
         $count = 0;
         foreach($service_due as $vehicle_data)
         {
            
             $service_email_send = DB::table('customer')
             ->where('Reference', '=', $vehicle_data->CustomerReference)
             ->where('Email', '<>', '')
             ->where('Email2', '=', '')
             ->orWhere(function($query) use ($vehicle_data) {
                 $query
                 ->where('Email', '=', '')
                 ->where('Email2', '<>', '')
                 ->where('Reference', '=', $vehicle_data->CustomerReference);
             })
             ->orWhere(function($query) use ($vehicle_data) {
                $query
                ->where('Email', '<>', '')
                ->where('Email2', '<>', '')
                ->where('Reference', '=', $vehicle_data->CustomerReference);
            })
             ->get();
             //dump($service_email_send);

            // if($service_email_send == 1)
            // {
                foreach($service_email_send as $ses)
                {
                 $count++;
                }
                
             //}
         }
         $service_email_send = $count;
        return view('livewire.vehicles.count.service-reminders-send-by-email', ['service_email_send' => $service_email_send]);
    }
}
