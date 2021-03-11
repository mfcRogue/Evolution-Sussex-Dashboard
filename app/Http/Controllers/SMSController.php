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
    // Dashboard shows current (live) conversdations and lists them in a table
    // return view sms dashboard

    public function dashboard()
    {
        $sms_active = DB::table('conversations')
        ->select('archived', 'created', 'number', 'updated', 'id')
        ->whereNull('conversations.archived')
        ->get();
        return view('sms.dashboard', ['sms_active'=>$sms_active]);
    }

    //Archive shows archived conversations and lists them in a table

    public function archived()
    {
        $sms_active = DB::table('conversations')
        ->select('archived', 'created', 'number', 'updated', 'id')
        ->whereNotnull('conversations.archived')
        ->get();

        return view('sms.archived', ['sms_active'=>$sms_active]);
    }

    //new shows form for users sending new SMS messages
    
    public function new()
    {
        return view('sms.new');
    } 

    // Send proccess the new form request and sends via the Nexmo API

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

    //recieve will pull data from the Nexmo API and alert users a new message has been recieved
    
    public function recieve(Request $request)
    {

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

     DB::table('conversations')
     ->updateOrInsert(
         ['number' => $validNumber],
         ['number' => $validNumber, 'updated' => now(), 'archived' => null]
     );

    }

    //Archive sets the conversation selected to archive mode
    //set archive time to now
    
    public function archive($id)
    {
        $affected = DB::table('conversations')
        ->where('id', $id)
        ->update(['archived' => now()
        ]);
        
        return redirect()->back()->with('status', 'Conversation Archived');

    }

    //activate sets the conversation selected to active
    //set archive time to null

    public function activate($id)
    {
        $affected = DB::table('conversations')
        ->where('id', $id)
        ->update(['archived' => null
        ]);
        
        return redirect()->back()->with('status', 'Conversation Now Active');
    }

    //view sees specific messages grouped based on mobile number
    //join conversations and messages via mobile number
    //order by created date, newest first
    //paginate by 5 - links auto generated by laravel

    public function view()
    {
        $sms_messages = DB::table('conversations')
        ->select('conversations.archived', 'messages.created', 'conversations.number', 'conversations.updated', 'conversations.id', 'messages.message', 'messages.user')
        ->join('messages', 'conversations.number','=', 'messages.number')
        ->orderBy('messages.created', 'desc')
        ->paginate(5);
        //->get();
        return view('sms.view', ['sms_messages'=>$sms_messages]);
    }
}
