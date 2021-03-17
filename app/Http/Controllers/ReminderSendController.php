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
        ->select('RegNo','ServDueDate', 'MOTDueDate', 'customers.Email', 'customers.Email2', 'customers.Str1', 'customers.Name', 'customers.Title')
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
        dump($combined_data_due);

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
    }

}
