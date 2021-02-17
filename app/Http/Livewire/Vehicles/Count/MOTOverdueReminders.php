<?php

namespace App\Http\Livewire\Vehicles\Count;

use Livewire\Component;
use Illuminate\Support\Facades\DB;


class MOTOverdueReminders extends Component
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
        /*
        $mot_overdue = DB::table('vehicles')
        ->whereNotBetween('ServDueDate', [$year.'-'.$month.'-01', $year.'-'.$month.'-31'])
        ->whereBetween('MOTDueDate', [$year.'-'.$month.'-01', $year.'-'.$month.'-31'])
        ->count();
        */
        $mot_overdue = 0;
        return view('livewire.vehicles.count.m-o-t-overdue-reminders', ['mot_overdue'=>$mot_overdue]);
    }
}
