<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//use Nexmo Facade
use Nexmo\Laravel\Facade\Nexmo;
//use database
use Illuminate\Support\Facades\DB;
//use string features
use Illuminate\Support\Str;

class SMSController extends Controller
{
    public function dashboard()
    {
        $sms_active = DB::table('conversations')
        ->select('conversations.archived', 'conversations.created', 'conversations.number', 'conversations.updated')
        ->join('messages', 'conversations.number', '=', 'messages.number')
        //
        //@@ Issue string in customers has space after inital code 
        //@@ Can't find away to alter for the time
        //->join('customers', 'conversations.number', '=', 'customers.Str1')
        ->whereNull('conversations.archived')
        ->get();
        return view('sms.dashboard', ['sms_active'=>$sms_active]);
    }
    public function new()
    {
        return view('sms.new');
    } 
    public function test()
    {
    /*Nexmo::message()->send([
        'to'   => '447876438542',
        'from' => '447507332161',
        'text' => 'Using the facade to send a message.'
    ]);*/
    }

    public function recieve(Request $request)
    {
    /*Nexmo::message()->send([
        'to'   => '447876438542',
        'from' => '447507332161',
        'text' => 'Using the facade to send a message.'
    ]);
    */

     //remove leading 44
     $numberStripped = substr($request->msisdn, 2);
     //replace with 0
     $validNumber= "0$numberStripped";
     //insert into DB
     DB::table('messages')->insert(
         [
         'number' =>  $validNumber,
         'message' => $request->text,
         'created' => now(),
         'user' => '0',
         'nexmo_id'=>  $request->messageId
         ]
     );

    }
}
