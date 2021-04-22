<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;

class LoanCarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //show table of all loan cars
        $loancars = DB::table('loan_cars')
            ->join('vehicles', 'reg_no', '=', 'RegNo')
            ->select('id', 'reg_no', 'mileage', 'vehicles.ServDueDate', 'vehicles.MOTDueDate')
            ->orderBy('vehicles.MOTDueDate', 'asc')
            ->get();

        return view('loancar.index', ['loancars'=>$loancars]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //Create new loan car form
        return view('loancar.create');
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
        $validatedData = $request->validate([
            'regnumber' => 'required|exists:vehicles,RegNo|unique:loan_cars,reg_no',
        ]);
        DB::table('loan_cars')->insert(
            [
            'reg_no' => $request->regnumber,
            ]
        );
        return redirect('loancar/dashboard')->with('status', 'Loan Car added');
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
    public function edit(Request $request, $id)
        {
        //show edit form
        $loancars = DB::table('loan_cars')
        ->join('vehicles', 'reg_no', '=', 'RegNo')
        ->select('id', 'reg_no', 'mileage', 'vehicles.ServDueDate', 'vehicles.MOTDueDate')
        ->orderBy('vehicles.MOTDueDate', 'asc')
        ->where('id', '=', $id)
        ->get();

        return view('loancar.edit', ['loancars'=>$loancars, 'request'=>$request]);
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
        $validatedData = $request->validate([
            'regnumber' => 'required|exists:vehicles,RegNo',
            'mileage' => 'numeric',
        ]);
        $update = DB::table('loan_cars')
              ->where('id', $id)
              ->update([
                'reg_no' => $request->regnumber,
                'mileage' => $request->mileage
              ]);
        return redirect('loancar/dashboard')->with('status', 'Loan Car updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //delete record, return to index
        DB::table('loan_cars')->where('id', '=', $id)->delete();
        return redirect('loancar/dashboard')->with('status', 'Loan Car Deleted');

    }
}
