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
    public function send(Request $request)
    {
        //validate data
        //ensure both fields are filled out 
        //ensure number starts with 07 and 11 digits long
        $validatedData = $request->validate([
            'number' => 'required|starts_with:07|digits:11',
            'message' => 'required',
        ]);
        //remove leading 0
        $numberStripped = substr($request->number, 1);
        //add 44 required for Nexmo API
        $validNumber= "44$numberStripped";
        //once validated, push to Nexmo Function

        Nexmo::message()->send([
            'to'   => $validNumber,
            'from' => '447507332161',
            'text' => $request->message
        ]);

        DB::table('messages')->insert(
            [
            'number' => $request->number,
            'message' => $request->message,
            'created' => now(),
            'user' => $request->user()->id,
            'nexmo_id'=>$message['message-id']
            ]
        );
        //create or update conversation
        DB::table('conversations')
        ->updateOrInsert(
            ['number' => $request->number],
            ['number' => $request->number, 'updated' => now(), 'archived' => null]
        );
        return redirect('sms/dashboard');
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
