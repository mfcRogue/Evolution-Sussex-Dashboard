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
    public function test()
    {
    /*Nexmo::message()->send([
        'to'   => '447876438542',
        'from' => '447507332161',
        'text' => 'Using the facade to send a message.'
    ]);*/
    }

    public function recieve()
    {
    Nexmo::message()->send([
        'to'   => '447876438542',
        'from' => '447507332161',
        'text' => 'Using the facade to send a message.'
    ]);
    }
}
