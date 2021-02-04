<?php

namespace App\Http\Livewire\Vehicles\Count;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class ServiceReminders extends Component
{
    public function render()
    {
    //get month +1
    $month = date('M', strtotime(now()->addMonth()));
    //if month is december next year is required
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
    ->count();
        return view('livewire.vehicles.count.service-reminders', ['service_due' => $service_due]);
    }
}
