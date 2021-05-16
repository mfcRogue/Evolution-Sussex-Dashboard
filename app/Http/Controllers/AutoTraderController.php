<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;

class AutoTraderController extends Controller
{
    //
    public function index()
    {
        $trader_id = env('AUTOTRADER_ID');
        $client = new Client();

        $response = $client->post('https://api-sandbox.autotrader.co.uk/authenticate', [
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded',
            ],
            'form_params' => [
                'key' => env('AUTOTRADER_KEY'),
                'secret' => env('AUTOTRADER_SECRET'),

            ],
        ]);

        // You need to parse the response body
        // This will parse it into an array

        $response = json_decode($response->getBody(), true);
        $token = $response['access_token'];
        $expiry  = $response['expires'];
        //dd($response);
        //$client2 = new Client();

        $response2 = $client->get("https://api-sandbox.autotrader.co.uk/service/stock-management/search?advertiserId=$trader_id", [
            'headers' => [
                'Content-Type' => 'application/json;charset=UTF-8',
                'Authorization' => "Bearer {$token}",

            ],
            ]);
            //dump($response2);
            $response2 = json_decode($response2->getBody(), true);



            //dump($response2['results']);
            $i = 0;
            foreach ($response2['results'] as $value) {
                echo($value['vehicle']['registration']);
                echo($value['vehicle']['make']);
                echo($value['vehicle']['model']);
                foreach ($value['media']['images'] as $images) {
                    echo"<pre>";
                    echo($images['href']);
                    echo"</pre>";
                }
                $i++;


            }


    }
}
