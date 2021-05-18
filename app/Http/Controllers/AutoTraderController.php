<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use Codexshaper\WooCommerce\Facades\Product;
use Codexshaper\WooCommerce\Facades\Attribute;

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
        //search? gets every vehicle on the Advertiser ID
        $response2 = $client->get("https://api-sandbox.autotrader.co.uk/service/stock-management/search?advertiserId=$trader_id", [
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
            $categories = [
                [
                    'id' => 35,
                ],
            ];
            
            $product                    = new Product;
            $product->name              = $name;
            $product->type              = 'simple';
            $product->regular_price     = $price
            $product->description       = 'Product Description';
            $product->short_description = $description;
            $product->categories        = $categories;
            $product->images            = $images;
            $product->save();
                                        

    }
    public function wordpress()
    {
        $data = [
            'name' => 'Simple Product',
            'type' => 'simple',
            'regular_price' => '10.00',
            'description' => 'Simple product full description.',
            'short_description' => 'Simple product short description.',
            'categories' => [
                [
                    'id' => 35
                ],
            ],
            'images' => [
                [
                    'src' => 'http://demo.woothemes.com/woocommerce/wp-content/uploads/sites/56/2013/06/T_2_front.jpg'
                ],
                [
                    'src' => 'http://demo.woothemes.com/woocommerce/wp-content/uploads/sites/56/2013/06/T_2_back.jpg'
                ]
            ]

        ];
        
       // $product = Product::create($data);
    }
}
