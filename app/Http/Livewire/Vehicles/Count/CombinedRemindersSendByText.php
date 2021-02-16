<?php

namespace App\Http\Livewire\Vehicles\Count;

use Livewire\Component;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Vehicle;
use App\Models\Customer;

class CombinedRemindersSendByText extends Component
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

                  $combined_text_send = Customer::whereHas('vehicle', function (Builder $query) use($year, $month)  {
                    $query
                    //->whereBetween('ServDueDate', [$year.'-'.$month.'-01', $year.'-'.$month.'-31'])
                    //->whereBetween('MOTDueDate', [$year.'-'.$month.'-01', $year.'-'.$month.'-31'])
                    ->where('Reference', '<>', 'INTERNAL')
                    ->where('Email', '=', '')
                    ->where('Email2', '=', '')
                    ->where('Str1', '<>', '');
                })->count();
                

        return view('livewire.vehicles.count.combined-reminders-send-by-text', ['combined_text_send'=>$combined_text_send]);
    }
}
