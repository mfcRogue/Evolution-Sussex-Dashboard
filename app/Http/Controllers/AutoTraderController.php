<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use Codexshaper\WooCommerce\Facades\Product;
use Codexshaper\WooCommerce\Facades\Attribute;
use Codexshaper\WooCommerce\Facades\WooCommerce;

use Illuminate\Support\Facades\DB;

class AutoTraderController extends Controller
{
    //
    public function index()
    {
        //get trader ID from .env file
        //this is supplied by Auto Trader
        $trader_id = env('AUTOTRADER_ID');
        //start new Guzzle Clinent
        $client = new Client();

        //post authenticate to Auto Trader
        //URL sandbox is for testing
        //content type must be www-form-urlencoded
        //documentation: https://developers.autotrader.co.uk/api#instructions
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
        //get token, this is needed for auth
        $token = $response['access_token'];

        //get vehicle information
        // use header Auth => Bearer {token}
        //get specific information
        $response2 = $client->get("https://api-sandbox.autotrader.co.uk/service/stock-management/vehicles?registration=$reg&advertiserId=$trader_id", [
            'headers' => [
                'Content-Type' => 'application/json;charset=UTF-8',
                'Authorization' => "Bearer {$token}",
            ],
            ]);

            $response2 = json_decode($response2->getBody(), true);

            //for each vehicle
            foreach ($response2['results'] as $value) {
                $reg = $value['vehicle']['registration'];
                $image = $value['media']['images'];
                $description = $value['adverts']['retailAdverts']['description2'];
                $price = $value['adverts']['forecourtPrice']['amountGBP'];
                //convert from href (auto trader) to src (woocommerce)
                unset($images);
                //remove images before loop to stop aggregation
                foreach($image as $links)
                {
                    $oldarr = $links['href'];
                    $newarr['src'] =  $oldarr;
                    $oldarr  = $newarr;
                    unset($newarr);

                    $images[] = $oldarr;
                }




                //get feature list for every vehicle
               $response3 = $client->get("https://api-sandbox.autotrader.co.uk/service/stock-management/vehicles?registration=$reg&features=true&advertiserId=$trader_id", [
                    'headers' => [
                        'Content-Type' => 'application/json;charset=UTF-8',
                        'Authorization' => "Bearer {$token}",

                    ],
                    ]);

                    $response3 = json_decode($response3->getBody(), true);


                $make = $response3['vehicle']['make'];
                $model = $response3['vehicle']['model'];

                $name = $make .' '. $model;

                echo"$reg | $name | $description | £$price";
                dump($images);
                dump($value);
                dump($response3);


            }
            //$products = Product::get()->where('name', '=', $name);
            //dump($products);
            /*$categories = [
              [
                    'id' => 35,
                ],
            ];

            /*$product                    = new Product;
            $product->name              = $name;
            $product->type              = 'simple';
            $product->regular_price     = $price;
            $product->description       = 'Product Description';
            $product->short_description = $description;
            $product->categories        = $categories;
            $product->images            = $images;
            $product->save();
            */

    }
    public function getwoolist()
    {
        //get woo commerce list
        return WooCommerce::all('products');
        dump($products);


    }
    public function getlist()
    {
    /*
    *   Get complete list of all auto trader vehicles currently active
    *   Add +1 to status records
    *   Store list in DB
    *   Either update if exists or insert if it doesn't
    *   Set the status back to 0 as it still exists as a listed item on Auto trader
    *   Delete anything that is over 1 as that item now no longer exists in DB
    */

     //get trader ID from .env file
        //this is supplied by Auto Trader
        $trader_id = env('AUTOTRADER_ID');
        //start new Guzzle Clinent
        $client = new Client();

        //post authenticate to Auto Trader
        //URL sandbox is for testing
        //content type must be www-form-urlencoded
        //documentation: https://developers.autotrader.co.uk/api#instructions
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
        //get token, this is needed for auth
        $token = $response['access_token'];

        //get vehicle information
        // use header Auth => Bearer {token}
        //search? gets every vehicle on the Advertiser ID
        $response2 = $client->get("https://api-sandbox.autotrader.co.uk/service/stock-management/search?advertiserId=$trader_id", [
            'headers' => [
                'Content-Type' => 'application/json;charset=UTF-8',
                'Authorization' => "Bearer {$token}",

            ],
            ]);
            //decode response
            $response2 = json_decode($response2->getBody(), true);

            //increment status db record by 1
            DB::table('autotrader')->update(['status' => 'delete']);
            //get every current Auto trader vehicle reg
            foreach ($response2['results'] as $value) {
                $reg = $value['vehicle']['registration'];

            //for each vehicle update or insert new record with status being 0
                DB::table('autotrader')
                ->updateOrInsert(
                ['reg' => $reg , 'status' => 'update'], ['reg' => $reg , 'status' => 'new']
                );
            }
            //delete all vehicles which now no longer exist
            DB::table('autotrader')->where('status', '=', 'delete')->delete();
    }

    public function getnew()
    {
    /*
    *   Seach Database for new records
    *   Get auto trader base information
    *   Convert Base information into Wordpress / Ecommerce
    *
    *
    *
    */
    // auth with auto trader api
      //get trader ID from .env file
        //this is supplied by Auto Trader
        $trader_id = env('AUTOTRADER_ID');
        //start new Guzzle Clinent
        $client = new Client();

        //post authenticate to Auto Trader
        //URL sandbox is for testing
        //content type must be www-form-urlencoded
        //documentation: https://developers.autotrader.co.uk/api#instructions
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
    //get token, this is needed for auth
    $token = $response['access_token'];


    //get every new record from the DB
    $autotrader = DB::table('autotrader')
    ->where('status', '=', 'new')
    ->get();
    // loop through and grab reg
    foreach($autotrader as $trader_data){

        //reg from DB
        $reg = $trader_data->reg;

        //get auto trader API data for this reg number
        $response2 = $client->get("https://api-sandbox.autotrader.co.uk/service/stock-management/vehicles?registration=$reg&advertiserId=$trader_id", [
            'headers' => [
                'Content-Type' => 'application/json;charset=UTF-8',
                'Authorization' => "Bearer {$token}",
            ],
            ]);

            $response2 = json_decode($response2->getBody(), true);
            foreach ($response2 as $value) {
                $at_reg = $value['registration'];
                $at_vin = $value['vin'];
                echo"<pre>$at_vin | $at_reg</pre>";
                dump($value);
            }

    }

    }
}
