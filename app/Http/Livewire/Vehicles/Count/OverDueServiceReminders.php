<?php

namespace App\Http\Livewire\Vehicles\Count;
use Illuminate\Support\Facades\DB;


use Livewire\Component;

class OverDueServiceReminders extends Component
{
    public function render()
    {
        //get month
        $month = date('m', strtotime(now()));
        if($month == 12)
        {
            $year = date('Y', strtotime(now()->addYear()));    
        }
        else
        {
            $year = date('Y', strtotime(now()));
        }
        $service_overdue = DB::table('vehicles')
        ->whereBetween('ServDueDate', [$year.'-'.$month.'-01', $year.'-'.$month.'-31'])
        ->whereNotBetween('MOTDueDate', [$year.'-'.$month.'-01', $year.'-'.$month.'-31'])
        ->count();
        return view('livewire.vehicles.count.over-due-service-reminders', ['service_overdue' => $service_overdue]);
    }
}
