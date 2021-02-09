<?php

namespace App\Http\Livewire\Vehicles\Count;

use Livewire\Component;
use Illuminate\Support\Facades\DB;


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
                $combined_due = DB::table('vehicles')
                ->whereBetween('ServDueDate', [$year.'-'.$month.'-01', $year.'-'.$month.'-31'])
                ->whereBetween('MOTDueDate', [$year.'-'.$month.'-01', $year.'-'.$month.'-31'])
                ->where('CustomerReference', '<>', 'INTERNAL')
                ->get();
                $count = 0;
                foreach($combined_due as $vehicle_data)
                {
                
                    $combined_email_send = DB::table('customer')
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
                    
                    foreach($combined_email_send as $ses)
                    {
                        $count++;
                    }
        
                }
                $combined_email_send = $count;
        return view('livewire.vehicles.count.combined-reminders-send-by-email', ['combined_email_send'=>$combined_email_send]);
    }
}
