<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//use Nexmo Facade
use Nexmo\Laravel\Facade\Nexmo;
//use database
use Illuminate\Support\Facades\DB;
//use string features
use Illuminate\Support\Str;
//use Mail
use Illuminate\Support\Facades\Mail;
//mail templates
use App\Mail\CombinedReminder;
use App\Mail\ServiceReminder;
use App\Mail\MOTReminder;

class ReminderSendController extends Controller
{
    //
    public function email($month)
    {
        $year = date('Y', strtotime(now()));


        $combined_data_due = DB::table('vehicles')
        ->join('customers', 'CustomerReference', '=', 'Reference')
        ->select('RegNo','Make','Model','ServDueDate', 'MOTDueDate', 'customers.Email', 'customers.Email2', 'customers.Str1', 'customers.Name', 'customers.Title', 'customers.Forename')
        ->whereBetween('ServDueDate', [$year.'-'.$month.'-01', $year.'-'.$month.'-31'])
        ->whereBetween('MOTDueDate', [$year.'-'.$month.'-01', $year.'-'.$month.'-31'])
        ->where('CustomerReference', '<>', 'INTERNAL')
        ->where('customers.Email', '<>', '')
        ->where('customers.Email2', '<>', '')
        ->orWhere(function($query) use($month, $year) {
            $query
            ->whereBetween('ServDueDate', [$year.'-'.$month.'-01', $year.'-'.$month.'-31'])
            ->whereBetween('MOTDueDate', [$year.'-'.$month.'-01', $year.'-'.$month.'-31'])
            ->where('CustomerReference', '<>', 'INTERNAL')
            ->where('customers.Email', '<>', '')
            ->where('customers.Email2', '=', '');
        })
        ->orWhere(function($query) use($month, $year) {
            $query
            ->whereBetween('ServDueDate', [$year.'-'.$month.'-01', $year.'-'.$month.'-31'])
            ->whereBetween('MOTDueDate', [$year.'-'.$month.'-01', $year.'-'.$month.'-31'])
            ->where('CustomerReference', '<>', 'INTERNAL')
            ->where('customers.Email', '=', '')
            ->where('customers.Email2', '<>', '');
        })
        ->get();
       //dump($combined_data_due);

            foreach($combined_data_due as $mail_data)
            {
                $data = [
                'RegNo' => $mail_data->RegNo,
                'Make' => $mail_data->Make,
                'Model' => $mail_data->Model,
                'ServDueDate' => date('d-m-Y', strtotime($mail_data->ServDueDate)),
                'MOTDueDate' => date('d-m-Y', strtotime($mail_data->MOTDueDate)),
                'CustName' => $mail_data->Name,
                'CustForename' => $mail_data->Forename,
                'CustTitle' => $mail_data->Title
                ];
                //if customer has both emails set Email to "To" and Email2 as CC
                if (!empty($mail_data->Email) and !empty($mail_data->Email2)) {

                    dump($mail_data->Email, $mail_data->Emai2);
                }
                //else if Email 2 is only set set Email2
                elseif(empty($mail_data->Email) and !empty($mail_data->Email2))
                {
                    dump($mail_data->Email2);
                }
                else{
                    dump($mail_data->Email);
                }
                
                return (new CombinedReminder($data))->render();
            }
 
           /* Mail::to("roguegfh@gmail.com")
            ->send(new CombinedReminder($data));*/


        
      /*

        $service_data_due = DB::table('vehicles')
        ->join('customers', 'CustomerReference', '=', 'Reference')
        ->select('RegNo','ServDueDate', 'MOTDueDate', 'customers.Email', 'customers.Email2', 'customers.Str1', 'customers.Name', 'customers.Title')
        ->whereBetween('ServDueDate', [$year.'-'.$month.'-01', $year.'-'.$month.'-31'])
        ->whereNotBetween('MOTDueDate', [$year.'-'.$month.'-01', $year.'-'.$month.'-31'])
        ->where('CustomerReference', '<>', 'INTERNAL')
        ->where('customers.Email', '<>', '')
        ->where('customers.Email2', '<>', '')
        ->orWhere(function($query) use($month, $year) {
            $query
            ->whereBetween('ServDueDate', [$year.'-'.$month.'-01', $year.'-'.$month.'-31'])
            ->whereNotBetween('MOTDueDate', [$year.'-'.$month.'-01', $year.'-'.$month.'-31'])
            ->where('CustomerReference', '<>', 'INTERNAL')
            ->where('customers.Email', '<>', '')
            ->where('customers.Email2', '=', '');
        })
        ->orWhere(function($query) use($month, $year) {
            $query
            ->whereBetween('ServDueDate', [$year.'-'.$month.'-01', $year.'-'.$month.'-31'])
            ->whereNotBetween('MOTDueDate', [$year.'-'.$month.'-01', $year.'-'.$month.'-31'])
            ->where('CustomerReference', '<>', 'INTERNAL')
            ->where('customers.Email', '=', '')
            ->where('customers.Email2', '<>', '');
        })
        ->get();
        dump($service_data_due);
       
        $mot_data_due = DB::table('vehicles')
        ->join('customers', 'CustomerReference', '=', 'Reference')
        ->select('RegNo','ServDueDate', 'MOTDueDate', 'customers.Email', 'customers.Email2', 'customers.Str1', 'customers.Name', 'customers.Title')
        ->whereNotBetween('ServDueDate', [$year.'-'.$month.'-01', $year.'-'.$month.'-31'])
        ->whereBetween('MOTDueDate', [$year.'-'.$month.'-01', $year.'-'.$month.'-31'])
        ->where('CustomerReference', '<>', 'INTERNAL')
        ->where('customers.Email', '<>', '')
        ->where('customers.Email2', '<>', '')
        ->orWhere(function($query) use($month, $year) {
            $query
            ->whereNotBetween('ServDueDate', [$year.'-'.$month.'-01', $year.'-'.$month.'-31'])
            ->whereBetween('MOTDueDate', [$year.'-'.$month.'-01', $year.'-'.$month.'-31'])
            ->where('CustomerReference', '<>', 'INTERNAL')
            ->where('customers.Email', '<>', '')
            ->where('customers.Email2', '=', '');
        })
        ->orWhere(function($query) use($month, $year) {
            $query
            ->whereNotBetween('ServDueDate', [$year.'-'.$month.'-01', $year.'-'.$month.'-31'])
            ->whereBetween('MOTDueDate', [$year.'-'.$month.'-01', $year.'-'.$month.'-31'])
            ->where('CustomerReference', '<>', 'INTERNAL')
            ->where('customers.Email', '=', '')
            ->where('customers.Email2', '<>', '');
        })
        ->get();

        dump($mot_data_due);
        */
    }

}
