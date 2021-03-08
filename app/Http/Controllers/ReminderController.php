<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReminderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $month_next = date('m', strtotime(now()->addMonth()));
        $month_now = date('m', strtotime(now()));
        if($month_next == 12)
        {
            $year = date('Y', strtotime(now()->addYear()));    
        }
        else
        {
            $year = date('Y', strtotime(now()));
        }
        /*
        //
        // Combined Service and MOT Reminders, 5 queries , due, overdue, email, sms, post
        // Due is simple - any record between dates (next month)
        // Ovedue - any record bewtween dated (current month
        // Email Due -joned query with `customers` - Where both email and email 2, or email / email 2 are not blank (can't use null due to import restrictions)
        // SMS Due - joined query with `customers` - Where emails are blank but Str1 - Mobile number is not
        // Post Due - joined query with `customers` - Where emails and Str (Mobile) are all blank
        //
        */
        //get combined service and MOT Due Dates for next month
        $combined_count_due = DB::table('vehicles')
            //->join('customers', 'CustomerReference', '=', 'Reference')
            ->select('SevDueDate', 'MOTDueDate')
            ->whereBetween('ServDueDate', [$year.'-'.$month_next.'-01', $year.'-'.$month_next.'-31'])
            ->whereBetween('MOTDueDate', [$year.'-'.$month_next.'-01', $year.'-'.$month_next.'-31'])
            ->where('CustomerReference', '<>', 'INTERNAL')
            ->count();

        //get combined service and MOT Due Dates for Email Sending next month
        $combined_count_due_email = DB::table('vehicles')
            ->join('customers', 'CustomerReference', '=', 'Reference')
            ->select('SevDueDate', 'MOTDueDate', 'customers.Email', 'customers.Email2')
            ->whereBetween('ServDueDate', [$year.'-'.$month_next.'-01', $year.'-'.$month_next.'-31'])
            ->whereBetween('MOTDueDate', [$year.'-'.$month_next.'-01', $year.'-'.$month_next.'-31'])
            ->where('CustomerReference', '<>', 'INTERNAL')
            ->where('customers.Email', '<>', '')
            ->where('customers.Email2', '<>', '')
            ->orWhere(function($query) use($month_next, $year) {
                $query
                ->whereBetween('ServDueDate', [$year.'-'.$month_next.'-01', $year.'-'.$month_next.'-31'])
                ->whereBetween('MOTDueDate', [$year.'-'.$month_next.'-01', $year.'-'.$month_next.'-31'])
                ->where('CustomerReference', '<>', 'INTERNAL')
                ->where('customers.Email', '<>', '')
                ->where('customers.Email2', '=', '');
            })
            ->orWhere(function($query) use($month_next, $year) {
                $query
                ->whereBetween('ServDueDate', [$year.'-'.$month_next.'-01', $year.'-'.$month_next.'-31'])
                ->whereBetween('MOTDueDate', [$year.'-'.$month_next.'-01', $year.'-'.$month_next.'-31'])
                ->where('CustomerReference', '<>', 'INTERNAL')
                ->where('customers.Email', '=', '')
                ->where('customers.Email2', '<>', '');
            })
            ->count();

        //get combined service and MOT Due Dates for SMS Sending next month
        $combined_count_due_sms = DB::table('vehicles')
            ->join('customers', 'CustomerReference', '=', 'Reference')
            ->select('SevDueDate', 'MOTDueDate', 'customers.Email', 'customers.Email2')
            ->whereBetween('ServDueDate', [$year.'-'.$month_next.'-01', $year.'-'.$month_next.'-31'])
            ->whereBetween('MOTDueDate', [$year.'-'.$month_next.'-01', $year.'-'.$month_next.'-31'])
            ->where('CustomerReference', '<>', 'INTERNAL')
            ->where('customers.Email', '=', '')
            ->where('customers.Email2', '=', '')
            ->where('customers.Str1', '<>', '')
            ->count();

        //get combined service and MOT Due Dates for Post Sending next month
        $combined_count_due_post = DB::table('vehicles')
            ->join('customers', 'CustomerReference', '=', 'Reference')
            ->select('SevDueDate', 'MOTDueDate', 'customers.Email', 'customers.Email2')
            ->whereBetween('ServDueDate', [$year.'-'.$month_next.'-01', $year.'-'.$month_next.'-31'])
            ->whereBetween('MOTDueDate', [$year.'-'.$month_next.'-01', $year.'-'.$month_next.'-31'])
            ->where('CustomerReference', '<>', 'INTERNAL')
            ->where('customers.Email', '=', '')
            ->where('customers.Email2', '=', '')
            ->where('customers.Str1', '=', '')
            ->count();
          

        //get combined service and MOT overDue Dates
        $combined_count_due_overdue = DB::table('vehicles')
            ->join('customers', 'CustomerReference', '=', 'Reference')
            ->select('SevDueDate', 'MOTDueDate', 'customers.Email', 'customers.Email2')
            ->whereBetween('ServDueDate', [$year.'-'.$month_now.'-01', $year.'-'.$month_now.'-31'])
            ->whereBetween('MOTDueDate', [$year.'-'.$month_now.'-01', $year.'-'.$month_now.'-31'])
            ->where('CustomerReference', '<>', 'INTERNAL')
            ->count();
        
        /*
        //
        // MOT Reminders, 5 queries , due, overdue, email, sms, post
        // Due is simple - any record between dates (next month)
        // Ovedue - any record bewtween dated (current month
        // Email Due -joned query with `customers` - Where both email and email 2, or email / email 2 are not blank (can't use null due to import restrictions)
        // SMS Due - joined query with `customers` - Where emails are blank but Str1 - Mobile number is not
        // Post Due - joined query with `customers` - Where emails and Str (Mobile) are all blank
        //
        */
        //get combined service and MOT Due Dates for next month
        $mot_count_due = DB::table('vehicles')
            //->join('customers', 'CustomerReference', '=', 'Reference')
            ->select('SevDueDate', 'MOTDueDate')
            ->whereNotBetween('ServDueDate', [$year.'-'.$month_next.'-01', $year.'-'.$month_next.'-31'])
            ->whereBetween('MOTDueDate', [$year.'-'.$month_next.'-01', $year.'-'.$month_next.'-31'])
            ->where('CustomerReference', '<>', 'INTERNAL')
            ->count();

        //get MOT Due Dates for Email Sending next month
        $mot_count_due_email = DB::table('vehicles')
            ->join('customers', 'CustomerReference', '=', 'Reference')
            ->select('SevDueDate', 'MOTDueDate', 'customers.Email', 'customers.Email2')
            ->whereNotBetween('ServDueDate', [$year.'-'.$month_next.'-01', $year.'-'.$month_next.'-31'])
            ->whereBetween('MOTDueDate', [$year.'-'.$month_next.'-01', $year.'-'.$month_next.'-31'])
            ->where('CustomerReference', '<>', 'INTERNAL')
            ->where('customers.Email', '<>', '')
            ->where('customers.Email2', '<>', '')
            ->orWhere(function($query) use($month_next, $year) {
                $query
                ->whereNotBetween('ServDueDate', [$year.'-'.$month_next.'-01', $year.'-'.$month_next.'-31'])
                ->whereBetween('MOTDueDate', [$year.'-'.$month_next.'-01', $year.'-'.$month_next.'-31'])
                ->where('CustomerReference', '<>', 'INTERNAL')
                ->where('customers.Email', '<>', '')
                ->where('customers.Email2', '=', '');
            })
            ->orWhere(function($query) use($month_next, $year) {
                $query
                ->whereNotBetween('ServDueDate', [$year.'-'.$month_next.'-01', $year.'-'.$month_next.'-31'])
                ->whereBetween('MOTDueDate', [$year.'-'.$month_next.'-01', $year.'-'.$month_next.'-31'])
                ->where('CustomerReference', '<>', 'INTERNAL')
                ->where('customers.Email', '=', '')
                ->where('customers.Email2', '<>', '');
            })
            ->count();

        //get  MOT Due Dates for SMS Sending next month
        $mot_count_due_sms = DB::table('vehicles')
            ->join('customers', 'CustomerReference', '=', 'Reference')
            ->select('SevDueDate', 'MOTDueDate', 'customers.Email', 'customers.Email2')
            ->whereNotBetween('ServDueDate', [$year.'-'.$month_next.'-01', $year.'-'.$month_next.'-31'])
            ->whereBetween('MOTDueDate', [$year.'-'.$month_next.'-01', $year.'-'.$month_next.'-31'])
            ->where('CustomerReference', '<>', 'INTERNAL')
            ->where('customers.Email', '=', '')
            ->where('customers.Email2', '=', '')
            ->where('customers.Str1', '<>', '')
            ->count();

        //get MOT Due Dates for Post Sending next month
        $mot_count_due_post = DB::table('vehicles')
            ->join('customers', 'CustomerReference', '=', 'Reference')
            ->select('SevDueDate', 'MOTDueDate', 'customers.Email', 'customers.Email2')
            ->whereNotBetween('ServDueDate', [$year.'-'.$month_next.'-01', $year.'-'.$month_next.'-31'])
            ->whereBetween('MOTDueDate', [$year.'-'.$month_next.'-01', $year.'-'.$month_next.'-31'])
            ->where('CustomerReference', '<>', 'INTERNAL')
            ->where('customers.Email', '=', '')
            ->where('customers.Email2', '=', '')
            ->where('customers.Str1', '=', '')
            ->count();
          

        //get MOT overDue Dates
        $mot_count_due_overdue = DB::table('vehicles')
            ->join('customers', 'CustomerReference', '=', 'Reference')
            ->select('SevDueDate', 'MOTDueDate', 'customers.Email', 'customers.Email2')
            ->whereNotBetween('ServDueDate', [$year.'-'.$month_now.'-01', $year.'-'.$month_now.'-31'])
            ->whereBetween('MOTDueDate', [$year.'-'.$month_now.'-01', $year.'-'.$month_now.'-31'])
            ->where('CustomerReference', '<>', 'INTERNAL')
            ->count();
        
               /*
        //
        // Service Reminders, 5 queries , due, overdue, email, sms, post
        // Due is simple - any record between dates (next month)
        // Ovedue - any record bewtween dated (current month
        // Email Due -joned query with `customers` - Where both email and email 2, or email / email 2 are not blank (can't use null due to import restrictions)
        // SMS Due - joined query with `customers` - Where emails are blank but Str1 - Mobile number is not
        // Post Due - joined query with `customers` - Where emails and Str (Mobile) are all blank
        //
        */

        //get  service due datesfor next month
        $service_count_due = DB::table('vehicles')
        //->join('customers', 'CustomerReference', '=', 'Reference')
        ->select('SevDueDate', 'MOTDueDate')
        ->whereBetween('ServDueDate', [$year.'-'.$month_next.'-01', $year.'-'.$month_next.'-31'])
        ->whereNotBetween('MOTDueDate', [$year.'-'.$month_next.'-01', $year.'-'.$month_next.'-31'])
        ->where('CustomerReference', '<>', 'INTERNAL')
        ->count();

        //get service Due Dates for Email Sending next month
        $service_count_due_email = DB::table('vehicles')
            ->join('customers', 'CustomerReference', '=', 'Reference')
            ->select('SevDueDate', 'MOTDueDate', 'customers.Email', 'customers.Email2')
            ->whereBetween('ServDueDate', [$year.'-'.$month_next.'-01', $year.'-'.$month_next.'-31'])
            ->whereNotBetween('MOTDueDate', [$year.'-'.$month_next.'-01', $year.'-'.$month_next.'-31'])
            ->where('CustomerReference', '<>', 'INTERNAL')
            ->where('customers.Email', '<>', '')
            ->where('customers.Email2', '<>', '')
            ->orWhere(function($query) use($month_next, $year) {
                $query
                ->whereBetween('ServDueDate', [$year.'-'.$month_next.'-01', $year.'-'.$month_next.'-31'])
                ->whereNotBetween('MOTDueDate', [$year.'-'.$month_next.'-01', $year.'-'.$month_next.'-31'])
                ->where('CustomerReference', '<>', 'INTERNAL')
                ->where('customers.Email', '<>', '')
                ->where('customers.Email2', '=', '');
            })
            ->orWhere(function($query) use($month_next, $year) {
                $query
                ->whereBetween('ServDueDate', [$year.'-'.$month_next.'-01', $year.'-'.$month_next.'-31'])
                ->whereNotBetween('MOTDueDate', [$year.'-'.$month_next.'-01', $year.'-'.$month_next.'-31'])
                ->where('CustomerReference', '<>', 'INTERNAL')
                ->where('customers.Email', '=', '')
                ->where('customers.Email2', '<>', '');
            })
            ->count();

        //get  service Due Dates for SMS Sending next month
        $service_count_due_sms = DB::table('vehicles')
            ->join('customers', 'CustomerReference', '=', 'Reference')
            ->select('SevDueDate', 'MOTDueDate', 'customers.Email', 'customers.Email2')
            ->whereBetween('ServDueDate', [$year.'-'.$month_next.'-01', $year.'-'.$month_next.'-31'])
            ->whereNotBetween('MOTDueDate', [$year.'-'.$month_next.'-01', $year.'-'.$month_next.'-31'])
            ->where('CustomerReference', '<>', 'INTERNAL')
            ->where('customers.Email', '=', '')
            ->where('customers.Email2', '=', '')
            ->where('customers.Str1', '<>', '')
            ->count();

        //get service Due Dates for Post Sending next month
        $service_count_due_post = DB::table('vehicles')
            ->join('customers', 'CustomerReference', '=', 'Reference')
            ->select('SevDueDate', 'MOTDueDate', 'customers.Email', 'customers.Email2')
            ->whereBetween('ServDueDate', [$year.'-'.$month_next.'-01', $year.'-'.$month_next.'-31'])
            ->whereNotBetween('MOTDueDate', [$year.'-'.$month_next.'-01', $year.'-'.$month_next.'-31'])
            ->where('CustomerReference', '<>', 'INTERNAL')
            ->where('customers.Email', '=', '')
            ->where('customers.Email2', '=', '')
            ->where('customers.Str1', '=', '')
            ->count();
        

        //get service overDue Dates
        $service_count_due_overdue = DB::table('vehicles')
            ->join('customers', 'CustomerReference', '=', 'Reference')
            ->select('SevDueDate', 'MOTDueDate', 'customers.Email', 'customers.Email2')
            ->whereBetween('ServDueDate', [$year.'-'.$month_now.'-01', $year.'-'.$month_now.'-31'])
            ->whereNotBetween('MOTDueDate', [$year.'-'.$month_now.'-01', $year.'-'.$month_now.'-31'])
            ->where('CustomerReference', '<>', 'INTERNAL')
            ->count();
        

        return view('reminder.dashboard', ['combined_count_due' => $combined_count_due, 'combined_count_due_email'=> $combined_count_due_email, 'combined_count_due_sms'=>$combined_count_due_sms, 'combined_count_due_post'=>$combined_count_due_post, 'combined_count_due_overdue'=>$combined_count_due_overdue, 'mot_count_due' => $mot_count_due, 'mot_count_due_email'=> $mot_count_due_email, 'mot_count_due_sms'=>$mot_count_due_sms, 'mot_count_due_post'=>$mot_count_due_post, 'mot_count_due_overdue'=>$mot_count_due_overdue, 'service_count_due' => $service_count_due, 'service_count_due_email'=> $service_count_due_email, 'service_count_due_sms'=>$service_count_due_sms, 'service_count_due_post'=>$service_count_due_post, 'service_count_due_overdue'=>$service_count_due_overdue, 'month'=>$month_next]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $month
     * @return \Illuminate\Http\Response
     */
    public function list_due($month)
    {
        //** get current year**//
        // to do 
        // Make date more flexible to help next year during Dec / Jan
        //* *// 
        $year = date('Y', strtotime(now()));
        
        //** combined list **//
        $combined_data_due = DB::table('vehicles')
        ->select('RegNo','ServDueDate', 'MOTDueDate', 'customers.Email', 'customers.Email2', 'customers.Str1', 'customers.Name', 'customers.Title')
        ->whereBetween('ServDueDate', [$year.'-'.$month.'-01', $year.'-'.$month.'-31'])
        ->whereBetween('MOTDueDate', [$year.'-'.$month.'-01', $year.'-'.$month.'-31'])
        ->where('CustomerReference', '<>', 'INTERNAL')
        ->join('customers', 'CustomerReference', '=', 'Reference')
        ->get();

        //** service only list **//
        $service_data_due = DB::table('vehicles')
        ->select('RegNo', 'ServDueDate', 'MOTDueDate', 'customers.Email', 'customers.Email2', 'customers.Str1', 'customers.Name', 'customers.Title')
        ->whereBetween('ServDueDate', [$year.'-'.$month.'-01', $year.'-'.$month.'-31'])
        ->whereNotBetween('MOTDueDate', [$year.'-'.$month.'-01', $year.'-'.$month.'-31'])
        ->where('CustomerReference', '<>', 'INTERNAL')
        ->join('customers', 'CustomerReference', '=', 'Reference')
        ->get();

        //** mot  only list **//
        $mot_data_due = DB::table('vehicles')
        ->select('RegNo', 'ServDueDate', 'MOTDueDate', 'customers.Email', 'customers.Email2', 'customers.Str1', 'customers.Name', 'customers.Title')
        ->whereNotBetween('ServDueDate', [$year.'-'.$month.'-01', $year.'-'.$month.'-31'])
        ->whereBetween('MOTDueDate', [$year.'-'.$month.'-01', $year.'-'.$month.'-31'])
        ->where('CustomerReference', '<>', 'INTERNAL')
        ->join('customers', 'CustomerReference', '=', 'Reference')
        ->get();

        return view('reminder.list_due', ['month'=>$month, 'combined_data_due'=>$combined_data_due, 'service_data_due'=>$service_data_due, 'mot_data_due'=>$mot_data_due]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
