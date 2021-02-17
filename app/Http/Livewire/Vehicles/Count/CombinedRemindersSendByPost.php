<?php

namespace App\Http\Livewire\Vehicles\Count;

use Livewire\Component;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Vehicle;
use App\Models\Customer;

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
          $vehicle = Vehicle::has('Customer')
          ->whereBetween('ServDueDate', [$year.'-'.$month.'-01', $year.'-'.$month.'-31'])
          ->whereBetween('MOTDueDate', [$year.'-'.$month.'-01', $year.'-'.$month.'-31'])
          ->where('CustomerReference', '<>', 'INTERNAL')
          ->get();
          
          $combined_post_send = 0;
          foreach($vehicle as $veh_data)
          {
              
              $cust_email = $veh_data->customer['Email'];
              $cust_email2 = $veh_data->customer['Email2'];
              $cust_mobile = $veh_data->customer['Str1'];
              if($cust_email == '' and $cust_email2 == '' and $cust_mobile == '')
              {
                  $combined_post_send++;
              }
         
          }
        return view('livewire.vehicles.count.combined-reminders-send-by-post', ['combined_post_send'=>$combined_post_send]);
    }
}
