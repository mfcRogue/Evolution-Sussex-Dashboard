<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use Codexshaper\WooCommerce\Facades\Product;
use Codexshaper\WooCommerce\Facades\Attribute;
use Codexshaper\WooCommerce\Facades\WooCommerce;
use Illuminate\Support\Facades\DB;
use Storage;
use Symfony\Component\HttpFoundation\File\UploadedFile;


class AutoTraderController extends Controller
{
    //
    public function index()
    {
    }
    public function getwoolist()
    {
        //get woo commerce product list
        $products = Product::all();
        //dump($products);
        foreach($products as $product)
        {
            dump($product);
            $count = count($product->images);
            echo"$count";
        }
       
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
        $response2 = $client->get("https://api-sandbox.autotrader.co.uk/service/stock-management/search?advertiserId=$trader_id&pageSize=20&page=1", [
            'headers' => [
                'Content-Type' => 'application/json;charset=UTF-8',
                'Authorization' => "Bearer {$token}",

            ],
            ]);
            //decode response
            $response2 = json_decode($response2->getBody(), true);

            //db enum, new , update,
            //set all enum for auto trader and images to delete
            //any existing vehicles will be updated
            //any new vehicle will be new
            DB::table('autotrader')->update(['status' => 'delete']);
            DB::table('autotrader_images')->update(['status' => 'delete']);
            //get every current Auto trader vehicle reg
            dump($response2);
            foreach ($response2['results'] as $value) {
                //get reg number
                $reg = $value['vehicle']['registration'];
                $stockid = $value['metadata']['stockId'];
                //get images
                $images = $value['media']['images'];
                //for each image for each vehicle
                foreach($images as $image)
                {
                    //for some reason this is an array, break down to get link
                    foreach($image as $href)
                    {
                        // for each image for each vehicle update or insert
                        
                        DB::table('autotrader_images')
                        ->updateOrInsert(
                        ['reg' => $reg , 'status' => 'update', 'href' => $href], ['reg' => $reg , 'status' => 'new', 'href' => $href]
                        );
                    }
                    
                }
                

            //for each vehicle update or insert new record with status being 0
                DB::table('autotrader')
                ->updateOrInsert(
                ['reg' => $reg , 'status' => 'update', 'stockId'=> $stockid], ['reg' => $reg , 'status' => 'new', 'stockId'=> $stockid]
                );
            }
            //delete all vehicles which now no longer exist
            DB::table('autotrader')->where('status', '=', 'delete')->delete();
            DB::table('autotrader_images')->where('status', '=', 'delete')->delete();
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
    ->limit(1)
    ->get();
    // loop through and grab reg
    foreach($autotrader as $trader_data){

        //stockid from DB
        //this is recommmended by Auto trader API team
        $stockId = $trader_data->stockId;

        //get auto trader API data for this reg number
        $response2 = $client->get("https://api-sandbox.autotrader.co.uk/service/stock-management/search?stockId=$stockId&advertiserId=$trader_id", [
            'headers' => [
                'Content-Type' => 'application/json;charset=UTF-8',
                'Authorization' => "Bearer {$token}",
            ],
            ]);
        
        $response2 = json_decode($response2->getBody(), true);
        //dump($response2);
        foreach ($response2['results'] as $value) {
            //get database information required    
            $reg = $value['vehicle']['registration'];
            $make = $value['vehicle']['make'];
            $model = $value['vehicle']['model'];
            $model = $value['vehicle']['model'];
            $images = $value['media']['images'];
        
           foreach($images as $image)
            {
                $url = $image['href'];
                $info = pathinfo($url);
                $contents = file_get_contents($url);
                $file ='storage/'. $info['basename'];
                file_put_contents($file, $contents);
                $uploaded_file = new UploadedFile($file, $info['basename']);
                $uploaded_files[] = 'https://dashboard.evosussex.co.uk/storage/'. $info['basename'];
                
            }
    
            $newArray = array();
            foreach($uploaded_files as $key => $val){
	            $newArray['images'][$key] = array('src'=>$val);
            }
            
            

            $product_name = $make . ' ' . $model;
            //use make and model as product name, woocommerce automatically adds unique number to end if multiple names exist
            $description = $value['adverts']['retailAdverts']['description2'];
            $description_short = $product_name . ' ' .$value['vehicle']['derivative'];
            //string converstion required using strval as int not valid for price
            $price = strval($value['adverts']['retailAdverts']['price']['amountGBP']);
            //images not present as we will need to pull them and store them locally before displaying
            //also images here caused timeout issues
            //used vehicle id 35
            //attributes data pulled directly from Autotrader website, concerted to string using strval to stop null values breaking
                $data = [
                'name'              => $product_name,
                'type'              => 'simple',
                'regular_price'     => $price,
                'description'       => $description,
                'short_description' => $description_short,
                'categories' => [
                    [
                    'id' => 35,
                    ],
                ],
                'attributes' => [
                    [
                        'name' => 'Body Type',
                        'position' => 0,
                        'visible' => true,
                        'variation' => true,
                        'options' => [
                        strval($value['vehicle']['bodyType']),
                        ]
                    ],
                    [
                        'name' => 'Ownership Condition',
                        'position' => 0,
                        'visible' => true,
                        'variation' => true,
                        'options' => [
                        strval($value['vehicle']['ownershipCondition']),
                        ]
                    ],
                    [
                        'name' => 'Generation',
                        'position' => 0,
                        'visible' => true,
                        'variation' => true,
                        'options' => [
                        strval($value['vehicle']['generation']),
                        ]
                    ],
                    [
                        'name' => 'Derivative',
                        'position' => 0,
                        'visible' => true,
                        'variation' => true,
                        'options' => [
                        strval($value['vehicle']['derivative']),
                        ]
                    ],
                    [
                        'name' => 'Vehicle Type',
                        'position' => 0,
                        'visible' => true,
                        'variation' => true,
                        'options' => [
                        strval($value['vehicle']['vehicleType']),
                        ]
                    ],
                    [
                        'name' => 'Trim',
                        'position' => 0,
                        'visible' => true,
                        'variation' => true,
                        'options' => [
                        strval($value['vehicle']['trim']),
                        ]
                    ],
                    [
                        'name' => 'Body Type',
                        'position' => 0,
                        'visible' => true,
                        'variation' => true,
                        'options' => [
                        strval($value['vehicle']['bodyType']),
                        ]
                    ],
                    
                    [
                        'name' => 'Fuel Type',
                        'position' => 0,
                        'visible' => true,
                        'variation' => true,
                        'options' => [
                        strval($value['vehicle']['fuelType']),
                        ]
                    ],
                    [
                        'name' => 'Cab Type',
                        'position' => 0,
                        'visible' => true,
                        'variation' => true,
                        'options' => [
                            strval($value['vehicle']['cabType']),
                        ]
                    ],
                    [
                        'name' => 'Fuel Type',
                        'position' => 0,
                        'visible' => true,
                        'variation' => true,
                        'options' => [
                        strval($value['vehicle']['fuelType']),
                        ]
                    ],
                    [
                        'name' => 'Cab Type',
                        'position' => 0,
                        'visible' => true,
                        'variation' => true,
                        'options' => [
                        strval($value['vehicle']['cabType']),
                        ]
                    ],
                    [
                        'name' => 'Transmission Type',
                        'position' => 0,
                        'visible' => true,
                        'variation' => true,
                        'options' => [
                        strval($value['vehicle']['transmissionType']),
                        ]
                    ],
                    [
                        'name' => 'Wheelbase Type',
                        'position' => 0,
                        'visible' => true,
                        'variation' => true,
                        'options' => [
                        strval($value['vehicle']['wheelbaseType']),
                        ]
                    ],
                    [
                        'name' => 'Roof Height Type',
                        'position' => 0,
                        'visible' => true,
                        'variation' => true,
                        'options' => [
                        strval($value['vehicle']['roofHeightType']),
                        ]
                    ],
                    [
                        'name' => 'Drive Train',
                        'position' => 0,
                        'visible' => true,
                        'variation' => true,
                        'options' => [
                        strval($value['vehicle']['drivetrain']),
                        ]
                    ],
                    [
                        'name' => 'Seats',
                        'position' => 0,
                        'visible' => true,
                        'variation' => true,
                        'options' => [
                            strval($value['vehicle']['seats']),
                        ]
                    ],
                    [
                        'name' => 'Doors',
                        'position' => 0,
                        'visible' => true,
                        'variation' => true,
                        'options' => [
                            strval($value['vehicle']['doors']),
                        ]
                    ],
                    [
                        'name' => 'Top Speed MPH',
                        'position' => 0,
                        'visible' => true,
                        'variation' => true,
                        'options' => [
                            strval($value['vehicle']['topSpeedMPH']),
                        ]
                    ],
                    [
                        'name' => '0-60 MPH in Seconds',
                        'position' => 0,
                        'visible' => true,
                        'variation' => true,
                        'options' => [
                            strval($value['vehicle']['zeroToSixtyMPHSeconds']),
                        ]
                    ],
                    [
                        'name' => 'Engine Size in Litres',
                        'position' => 0,
                        'visible' => true,
                        'variation' => true,
                        'options' => [
                            strval($value['vehicle']['badgeEngineSizeLitres']),
                        ]
                    ],
                    [
                        'name' => 'Engine Capacity CC',
                        'position' => 0,
                        'visible' => true,
                        'variation' => true,
                        'options' => [
                            strval($value['vehicle']['engineCapacityCC']),
                        ]
                    ],
                    [
                        'name' => 'Engine Power BHP',
                        'position' => 0,
                        'visible' => true,
                        'variation' => true,
                        'options' => [
                            strval($value['vehicle']['enginePowerBHP']),
                        ]
                    ],
                    [
                        'name' => 'Fuel Capacity Litres',
                        'position' => 0,
                        'visible' => true,
                        'variation' => true,
                        'options' => [
                            strval($value['vehicle']['fuelCapacityLitres']),
                        ]
                    ],
                    [
                        'name' => 'Emission Class',
                        'position' => 0,
                        'visible' => true,
                        'variation' => true,
                        'options' => [
                        strval($value['vehicle']['emissionClass']),
                        ]
                    ],
                    [
                        'name' => 'Fuel Economy WLTP Combined MPG',
                        'position' => 0,
                        'visible' => true,
                        'variation' => true,
                        'options' => [
                            strval($value['vehicle']['fuelEconomyWLTPCombinedMPG']),
                        ]
                    ],
                    [
                        'name' => 'Boot Space (Seats Up) in Litres',
                        'position' => 0,
                        'visible' => true,
                        'variation' => true,
                        'options' => [
                            strval($value['vehicle']['bootSpaceSeatsUpLitres']),
                        ]
                    ],
                    [
                        'name' => 'Insurance Group',
                        'position' => 0,
                        'visible' => true,
                        'variation' => true,
                        'options' => [
                        strval($value['vehicle']['insuranceGroup']),
                        ]
                    ],
                    [
                        'name' => 'Odometer Reading in Miles',
                        'position' => 0,
                        'visible' => true,
                        'variation' => true,
                        'options' => [
                            strval($value['vehicle']['odometerReadingMiles']),
                        ]
                    ],
                ],
                
                'images' => $newArray['images']
        
            ];
            $product = Product::create($data);
            $affected = DB::table('autotrader')
            ->where('stockId', $stockId)
            ->update(['status' => 'update']);
        }
        //dd($data);
    //end for each 
    }

    }
}
