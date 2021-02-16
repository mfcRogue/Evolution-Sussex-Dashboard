<?php

namespace App\Http\Livewire\Vehicles\Count;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class MOTRemindersSendByEmail extends Component
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
       /* $mot_due = DB::table('vehicles')
        ->whereNotBetween('ServDueDate', [$year.'-'.$month.'-01', $year.'-'.$month.'-31'])
        ->whereBetween('MOTDueDate', [$year.'-'.$month.'-01', $year.'-'.$month.'-31'])
        ->where('CustomerReference', '<>', 'INTERNAL')
        ->get();
        $count = 0;
        foreach($mot_due as $vehicle_data)
        {
        
            $mot_email_send = DB::table('customer')
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
            
            foreach($mot_email_send as $ses)
            {
                $count++;
            }

        }
        */
        $mot_email_send = 0;
    return view('livewire.vehicles.count.m-o-t-reminders-send-by-email', ['mot_email_send' =>$mot_email_send]);
    }
}
