<?php

namespace App\Http\Livewire\Vehicles\Count;

use Livewire\Component;
use Illuminate\Support\Facades\DB;


class CombinedOverdueReminders extends Component
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
        $combined_overdue = DB::table('vehicles')
        ->whereBetween('ServDueDate', [$year.'-'.$month.'-01', $year.'-'.$month.'-31'])
        ->whereBetween('MOTDueDate', [$year.'-'.$month.'-01', $year.'-'.$month.'-31'])
        ->count();
        return view('livewire.vehicles.count.combined-overdue-reminders', ['combined_overdue'=>$combined_overdue]);
    }
}