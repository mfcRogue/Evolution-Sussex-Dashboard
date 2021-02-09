<?php

namespace App\Http\Livewire\Vehicles\Count;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class MOTRemindersSendByPost extends Component
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
         $mot_due = DB::table('vehicles')
         ->whereNotBetween('ServDueDate', [$year.'-'.$month.'-01', $year.'-'.$month.'-31'])
         ->whereBetween('MOTDueDate', [$year.'-'.$month.'-01', $year.'-'.$month.'-31'])
         ->where('CustomerReference', '<>', 'INTERNAL')
         ->get();
 
         $count = 0;
         
         foreach($mot_due as $vehicle_data)
         {
             $mot_post_send = DB::table('customer')
             ->where('Reference', '=', $vehicle_data->CustomerReference)
             ->where('Str1', '<>', '')
             ->where('Email', '=', '')
             ->where('Email2', '=', '')
             ->get();
             foreach($mot_post_send as $ses)
             {
              $count++;
             }
         }
         $mot_post_send = $count;
        return view('livewire.vehicles.count.m-o-t-reminders-send-by-post', ['mot_post_send'=> $mot_post_send]);
    }
}
