<?php

namespace App\Http\Livewire\Vehicles\Count;

use Livewire\Component;
use Illuminate\Support\Facades\DB;


class CombinedRemindersSendByPost extends Component
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
          $combined_due = DB::table('vehicles')
          ->whereBetween('ServDueDate', [$year.'-'.$month.'-01', $year.'-'.$month.'-31'])
          ->whereBetween('MOTDueDate', [$year.'-'.$month.'-01', $year.'-'.$month.'-31'])
          ->where('CustomerReference', '<>', 'INTERNAL')
          ->get();
  
          $count = 0;
          
          foreach($combined_due as $vehicle_data)
          {
              $combined_post_send = DB::table('customer')
              ->where('Reference', '=', $vehicle_data->CustomerReference)
              ->where('Str1', '=', '')
              ->where('Email', '=', '')
              ->where('Email2', '=', '')
              ->get();
              

              foreach($combined_post_send as $ses)
              {
               $count++;
              }
          }
          $combined_post_send = $count;
        return view('livewire.vehicles.count.combined-reminders-send-by-post', ['combined_post_send'=>$combined_post_send]);
    }
}
