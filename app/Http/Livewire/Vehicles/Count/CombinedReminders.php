<?php

namespace App\Http\Livewire\Vehicles\Count;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Models\Vehicle;

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
        
       $vehicle = Vehicle::all()
       ->whereBetween('ServDueDate', [$year.'-'.$month.'-01', $year.'-'.$month.'-31'])
       ->whereBetween('MOTDueDate', [$year.'-'.$month.'-01', $year.'-'.$month.'-31'])
       ->where('CustomerReference', '<>', 'INTERNAL')->count();
            //$count =0;
            //*$combined_due = DB::table('vehicles')
            //->whereBetween('ServDueDate', [$year.'-'.$month.'-01', $year.'-'.$month.'-31'])
            //->whereBetween('MOTDueDate', [$year.'-'.$month.'-01', $year.'-'.$month.'-31'])
            //->where('CustomerReference', '<>', 'INTERNAL')
            //->count();
        
            //** debug only */
            /* $combined_due_get = DB::table('vehicles')
            ->whereBetween('ServDueDate', [$year.'-'.$month.'-01', $year.'-'.$month.'-31'])
            ->whereBetween('MOTDueDate', [$year.'-'.$month.'-01', $year.'-'.$month.'-31'])
            ->where('CustomerReference', '<>', 'INTERNAL')
            ->get();
            foreach($combined_due_get as $vehicle_data)
            {   
                $combined_email_send = DB::table('customer')
                ->where('Reference', '=', $vehicle_data->CustomerReference)
                ->get();
                foreach($combined_email_send as $ses)
                {
                    $count++;
                    dump($ses->Reference);
                }
            }
            */


        return view('livewire.vehicles.count.combined-reminders', ['combined_due'=>$vehicle]);
    }
}
