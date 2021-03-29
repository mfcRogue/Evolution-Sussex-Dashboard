<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

use Illuminate\Support\Str;
//use database
use Illuminate\Support\Facades\DB;
//use account CSV model
use App\Models\AccountCSV;




class AccountsController extends Controller
{
    //
    public function index()
    {
        return view('accounts.dashboard');

    }
    


    public function upload(Request $request)
    {

   
        $validatedData = $request->validate([
            'file' => 'required',
    
           ]);
        //get name of file
        $name = $request->file('file')->getClientOriginalName();
        $path = Storage::disk('local')->putFileAs('public/files', $request->file('file'), $name);

        $fp =  fopen('../storage/app/'. $path, 'r');
       
        $data = array_map('str_getcsv', file('../storage/app/'. $path));
      
        $csv_data = array_slice($data, 0, 1000);
  
        
        foreach($data as $csv)
        {
            $contains =  Str::contains($csv['1'], "Inverted");

            if($contains)
            {
                $csv['2'] = $csv['2'] * -1;
                $csv['3'] = $csv['3'] * -1;               
            }
            
            DB::table('accounts')->insert([
                'col0' =>  $csv['0'],
                'col1' =>  $csv['1'],
                'col2' =>  $csv['2'],
                'col3' =>  $csv['3'],

            ]);
            

        }
        $data = AccountCSV::get();

        $csvExporter = new \Laracsv\Export();
        $csvExporter->build($data, ['col0', 'col1', 'col2', 'col3'], [
            'header' => false,
        ]);
        $csvExporter->download($name);
        DB::table('accounts')->truncate();

        fclose($fp);
        $delete = Storage::disk('local')->delete($path);
        //dump($delete);

   
        return redirect()->back()->with('status', 'Completed');
        
    }

}