<?php

namespace App\Http\Livewire\Vehicles\Count;
use Illuminate\Support\Facades\DB;


use Livewire\Component;

class SendByText extends Component
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
        ->get();
        $count = 0;
        
        foreach($service_due as $vehicle_data)
        {
            $service_text_send = DB::table('customer')
            ->where('Reference', '=', $vehicle_data->CustomerReference)
            ->where('Email', '=', '')
            ->where('Email2', '=', '')
            ->whereNotNull('Str1')
            ->count();
            if($service_text_send == 1)
            {
                $count++;
            }
        }
        $service_text_send = $count;
        return view('livewire.vehicles.count.send-by-text', ['service_text_send' => $service_text_send]);
    }
}
