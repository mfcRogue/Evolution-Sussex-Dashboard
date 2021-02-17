<?php

namespace App\Http\Livewire\Vehicles\Count;

use Livewire\Component;
//use Illuminate\Support\Facades\DB;
use App\Models\Vehicle;


class MOTReminders extends Component
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

        /*$mot_due = Vehicle::all()
        ->whereNotBetween('ServDueDate', [$year.'-'.$month.'-01', $year.'-'.$month.'-31'])
        ->whereBetween('MOTDueDate', [$year.'-'.$month.'-01', $year.'-'.$month.'-31'])
        ->where('CustomerReference', '<>', 'INTERNAL')
        ->count(); 
        */
        $mot_due = 0;
        return view('livewire.vehicles.count.m-o-t-reminders', ['mot_due' => $mot_due]);
    }
}
