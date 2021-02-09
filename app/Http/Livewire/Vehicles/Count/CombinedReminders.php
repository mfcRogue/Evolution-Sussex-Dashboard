<?php

namespace App\Http\Livewire\Vehicles\Count;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

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
            $combined_due = DB::table('vehicles')
            ->whereBetween('ServDueDate', [$year.'-'.$month.'-01', $year.'-'.$month.'-31'])
            ->whereBetween('MOTDueDate', [$year.'-'.$month.'-01', $year.'-'.$month.'-31'])
            ->where('CustomerReference', '<>', 'INTERNAL')
            ->count();
        return view('livewire.vehicles.count.combined-reminders', ['combined_due'=>$combined_due]);
    }
}
