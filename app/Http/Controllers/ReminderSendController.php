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

        /*******************
        * 
        * Combined service reminders
        * 
        *******************/

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

        foreach($combined_data_due as $mail_data)
        {
            $data = [
                'RegNo' => $mail_data->RegNo,
                'Make' => $mail_data->Make,
                'Model' => $mail_data->Model,
                'ServDueDate' => date('d/m/Y', strtotime($mail_data->ServDueDate)),
                'MOTDueDate' => date('d/m/Y', strtotime($mail_data->MOTDueDate)),
                'CustName' => $mail_data->Name,
                'CustForename' => $mail_data->Forename,
                'CustTitle' => $mail_data->Title,
                'Email1'=>$mail_data->Email,
                'Email2'=>$mail_data->Email2
            ];
            //if customer has both emails set Email to "To" and Email2 as CC
            if (!empty($mail_data->Email) and !empty($mail_data->Email2)) {
                Mail::to($mail_data->Email)
                ->cc($mail_data->Email2)
                ->bcc("service@evosussex.co.uk")
                ->send(new CombinedReminder($data));

                
            }
            //else if Email 2 is only set set Email2
            elseif(empty($mail_data->Email) and !empty($mail_data->Email2))
            {
                Mail::to($mail_data->Email2)
                ->bcc("service@evosussex.co.uk")
                ->send(new CombinedReminder($data));

            }
            elseif(!empty($mail_data->Email) and empty($mail_data->Email2))
            {
                Mail::to($mail_data->Email)
                ->bcc("service@evosussex.co.uk")
                ->send(new CombinedReminder($data));
            }
            //use return render to view email and testing
            //return (new CombinedReminder($data))->render();
            
            //use to send mail via .env settings

            unset($data);
            unset($mail_data);

        }
           

        /*******************
        * 
        * Service only service reminders
        * 
        *******************/

        $service_data_due = DB::table('vehicles')
        ->join('customers', 'CustomerReference', '=', 'Reference')
        ->select('RegNo','Make','Model','ServDueDate', 'MOTDueDate', 'customers.Email', 'customers.Email2', 'customers.Str1', 'customers.Name', 'customers.Title', 'customers.Forename')
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

        foreach($service_data_due as $mail_data)
        {
            $data = [
                'RegNo' => $mail_data->RegNo,
                'Make' => $mail_data->Make,
                'Model' => $mail_data->Model,
                'ServDueDate' => date('d/m/Y', strtotime($mail_data->ServDueDate)),
                'MOTDueDate' => date('d/m/Y', strtotime($mail_data->MOTDueDate)),
                'CustName' => $mail_data->Name,
                'CustForename' => $mail_data->Forename,
                'CustTitle' => $mail_data->Title,
                'Email1'=>$mail_data->Email,
                'Email2'=>$mail_data->Email2
            ];
            //if customer has both emails set Email to "To" and Email2 as CC
            if (!empty($mail_data->Email) and !empty($mail_data->Email2)) 
            {

                Mail::to($mail_data->Email)
                ->cc($mail_data->Email2)
                ->bcc("service@evosussex.co.uk")
                ->send(new ServiceReminder($data));     

            }
            //else if Email 2 is only set set Email2
            elseif(empty($mail_data->Email) and !empty($mail_data->Email2))
            {

                Mail::to($mail_data->Email2)
                ->bcc("service@evosussex.co.uk")
                ->send(new ServiceReminder($data));

            }
            elseif(!empty($mail_data->Email) and empty($mail_data->Email2))
            {

                Mail::to($mail_data->Email)
                ->bcc("service@evosussex.co.uk")
                ->send(new ServiceReminder($data));

            }
            //use return render to view email and testing
            //return (new ServiceReminder($data))->render();
            
        }

        /*******************
        * 
        * MOT only service reminders
        * 
        ********************/

        $mot_data_due = DB::table('vehicles')
        ->join('customers', 'CustomerReference', '=', 'Reference')
        ->select('RegNo','Make','Model','ServDueDate', 'MOTDueDate', 'customers.Email', 'customers.Email2', 'customers.Str1', 'customers.Name', 'customers.Title', 'customers.Forename')
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

        foreach($mot_data_due as $mail_data)
        {
            $data = [
                'RegNo' => $mail_data->RegNo,
                'Make' => $mail_data->Make,
                'Model' => $mail_data->Model,
                'ServDueDate' => date('d/m/Y', strtotime($mail_data->ServDueDate)),
                'MOTDueDate' => date('d/m/Y', strtotime($mail_data->MOTDueDate)),
                'CustName' => $mail_data->Name,
                'CustForename' => $mail_data->Forename,
                'CustTitle' => $mail_data->Title,
                'Email1'=>$mail_data->Email,
                'Email2'=>$mail_data->Email2
            ];
            //if customer has both emails set Email to "To" and Email2 as CC
            if (!empty($mail_data->Email) and !empty($mail_data->Email2)) 
            {

                Mail::to($mail_data->Email)
                ->cc($mail_data->Email2)
                ->bcc("service@evosussex.co.uk")
                ->send(new MOTReminder($data));

            
            }
            //else if Email 2 is only set set Email2
            elseif(empty($mail_data->Email) and !empty($mail_data->Email2))
            {

                Mail::to($mail_data->Email2)
                ->bcc("service@evosussex.co.uk")
                ->send(new MOTReminder($data));

            }
            elseif(!empty($mail_data->Email) and empty($mail_data->Email2))
            {

                Mail::to($mail_data->Email)
                ->bcc("service@evosussex.co.uk")
                ->send(new MOTReminder($data));

            }
            //use return render to view email and testing
            //return (new ServiceReminder($data))->render();


            //redirect back to mainscreen
            return redirect()->route('reminder.dashboard')->with('status', 'Email Reminders Sent');
            
        }

    }

    public function sms($month)
    {
        $year = date('Y', strtotime(now()));

        /*******************
        * 
        * Combined service reminders
        * 
        *******************/

        $combined_data_due = DB::table('vehicles')
        ->join('customers', 'CustomerReference', '=', 'Reference')
        ->select('RegNo','Make','Model','ServDueDate', 'MOTDueDate', 'customers.Email', 'customers.Email2', 'customers.Str1', 'customers.Name', 'customers.Title', 'customers.Forename')
        ->whereBetween('ServDueDate', [$year.'-'.$month.'-01', $year.'-'.$month.'-31'])
        ->whereBetween('MOTDueDate', [$year.'-'.$month.'-01', $year.'-'.$month.'-31'])
        ->where('CustomerReference', '<>', 'INTERNAL')
        ->where('customers.Email', '=', '')
        ->where('customers.Email2', '=', '')
        ->where('customers.Str1', '<>', '')
        ->get();

        //remove any spaces
        
        foreach($combined_data_due as $sms_data)
        {
            $sms_number = str_replace(' ', '', $sms_data->Str1);
             //remove leading 0
            $number_stripped = substr($sms_number, 1);
            //add 44 required for Nexmo API
            $valid_number = "44$number_stripped";
            //once validated, push to Nexmo Function
            
            $message = 'Dear '. $sms_data->Title . ' ' . $sms_data->Name . ' your ' . $sms_data->Make . ' ' . $sms_data->Model . ' is coming due for its service and MOT, to book in please contact David on 01273 388804, service@evosussex.co.uk or reply to this message. Many thanks Brighton Mitsubishi';
            echo"<p>$message</p>";
        }
            //dump($combined_data_due);

        /****************
         * ***
        * 
        * MOT only service reminders
        * 
        *******************/

        $mot_data_due = DB::table('vehicles')
        ->join('customers', 'CustomerReference', '=', 'Reference')
        ->select('RegNo','Make','Model','ServDueDate', 'MOTDueDate', 'customers.Email', 'customers.Email2', 'customers.Str1', 'customers.Name', 'customers.Title', 'customers.Forename')
        ->whereNotBetween('ServDueDate', [$year.'-'.$month.'-01', $year.'-'.$month.'-31'])
        ->whereBetween('MOTDueDate', [$year.'-'.$month.'-01', $year.'-'.$month.'-31'])
        ->where('CustomerReference', '<>', 'INTERNAL')
        ->where('customers.Email', '=', '')
        ->where('customers.Email2', '=', '')
        ->where('customers.Str1', '<>', '')
        ->get();
        foreach($mot_data_due as $sms_data)
        {
            $sms_number = str_replace(' ', '', $sms_data->Str1);
            //remove leading 0
            $number_stripped = substr($sms_number, 1);
            //add 44 required for Nexmo API
            $valid_number = "44$number_stripped";
            //once validated, push to Nexmo Function
            $message = 'Dear '. $sms_data->Title . ' ' . $sms_data->Name . ' your ' . $sms_data->Make . ' ' . $sms_data->Model . ' is coming due for its MOT, to book in please contact David on 01273 388804, service@evosussex.co.uk or reply to this message. Many thanks Brighton Mitsubishi';
        }
        //dump($mot_data_due);



        /*******************
        * 
        * Service only service reminders
        * 
        *******************/

        $service_data_due = DB::table('vehicles')
        ->join('customers', 'CustomerReference', '=', 'Reference')
        ->select('RegNo','Make','Model','ServDueDate', 'MOTDueDate', 'customers.Email', 'customers.Email2', 'customers.Str1', 'customers.Name', 'customers.Title', 'customers.Forename')
        ->whereBetween('ServDueDate', [$year.'-'.$month.'-01', $year.'-'.$month.'-31'])
        ->whereNotBetween('MOTDueDate', [$year.'-'.$month.'-01', $year.'-'.$month.'-31'])
        ->where('CustomerReference', '<>', 'INTERNAL')
        ->where('customers.Email', '=', '')
        ->where('customers.Email2', '=', '')
        ->where('customers.Str1', '<>', '')
        ->get();
        foreach($service_data_due as $sms_data)
        {
        $sms_number = str_replace(' ', '', $sms_data->Str1);
        //remove leading 0
        $number_stripped = substr($sms_number, 1);
        //add 44 required for Nexmo API
        $valid_number = "44$number_stripped";
        //once validated, push to Nexmo Function
        $message = 'Dear '. $sms_data->Title . ' ' . $sms_data->Name . ' your ' . $sms_data->Make . ' ' . $sms_data->Model . ' is coming due for its service, to book in please contact David on 01273 388804, service@evosussex.co.uk or reply to this message. Many thanks Brighton Mitsubishi';

        }
        //dump($service_data_due);

        return redirect()->back()->with('status', 'SMS Messages sent');
    }

    public function print($month)
    {

        $year = date('Y', strtotime(now()));

        
        /*******************
        * 
        * Service and MOT service reminders
        * 
        *******************/


        $combined_data_due = DB::table('vehicles')
        ->join('customers', 'CustomerReference', '=', 'Reference')
        ->select('RegNo','Make','Model','ServDueDate', 'MOTDueDate', 'customers.Email', 'customers.Email2', 'customers.Str1', 'customers.Name', 'customers.Title', 'customers.Forename')
        ->whereBetween('ServDueDate', [$year.'-'.$month.'-01', $year.'-'.$month.'-31'])
        ->whereBetween('MOTDueDate', [$year.'-'.$month.'-01', $year.'-'.$month.'-31'])
        ->where('CustomerReference', '<>', 'INTERNAL')
        ->where('customers.Email', '=', '')
        ->where('customers.Email2', '=', '')
        ->where('customers.Str1', '=', '')
        ->get();

        
        /*******************
        * 
        * MOT only service reminders
        * 
        *******************/

        $mot_data_due = DB::table('vehicles')
        ->join('customers', 'CustomerReference', '=', 'Reference')
        ->select('RegNo','Make','Model','ServDueDate', 'MOTDueDate', 'customers.Email', 'customers.Email2', 'customers.Str1', 'customers.Name', 'customers.Title', 'customers.Forename', 'customers.Street 1', 'customers.Street 2', 'customers.Town', 'customers.County', 'customers.Postcode')
        ->whereNotBetween('ServDueDate', [$year.'-'.$month.'-01', $year.'-'.$month.'-31'])
        ->whereBetween('MOTDueDate', [$year.'-'.$month.'-01', $year.'-'.$month.'-31'])
        ->where('CustomerReference', '<>', 'INTERNAL')
        ->where('customers.Email', '=', '')
        ->where('customers.Email2', '=', '')
        ->where('customers.Str1', '=', '')
        ->get();

        /*******************
        * 
        * Service only service reminders
        * 
        *******************/

        $service_data_due = DB::table('vehicles')
        ->join('customers', 'CustomerReference', '=', 'Reference')
        ->select('RegNo','Make','Model','ServDueDate', 'MOTDueDate', 'customers.Email', 'customers.Email2', 'customers.Str1', 'customers.Name', 'customers.Title', 'customers.Forename', 'customers.Street 1')
        ->whereBetween('ServDueDate', [$year.'-'.$month.'-01', $year.'-'.$month.'-31'])
        ->whereNotBetween('MOTDueDate', [$year.'-'.$month.'-01', $year.'-'.$month.'-31'])
        ->where('CustomerReference', '<>', 'INTERNAL')
        ->where('customers.Email', '=', '')
        ->where('customers.Email2', '=', '')
        ->where('customers.Str1', '=', '')
        ->get();
        
        return view('reminder.post.reminder', ['month'=>$month, 'combined_data_due'=>$combined_data_due, 'mot_data_due'=>$mot_data_due, 'service_data_due'=>$service_data_due]);
    }

}
