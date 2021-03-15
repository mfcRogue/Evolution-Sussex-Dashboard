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
}
