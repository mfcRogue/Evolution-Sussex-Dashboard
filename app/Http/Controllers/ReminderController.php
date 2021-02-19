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
            ->count();
            echo"$combined_count_due_email";
    
        

        return view('reminder.dashboard', ['combined_count_due' => $combined_count_due]);
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
        //
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
