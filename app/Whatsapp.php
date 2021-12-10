<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Exception;
use GuzzleHttp\Exception\GuzzleException;
Use GuzzleHttp\Clients;
use Xendit\Xendit;


class Whatsapp extends Model
{
    //


    public static function wa_payment()
    {
    	        $message_payment="";
        try{

             $client = new Clients(); 
        $result = $client->post('https://wapisender.com/api/v1/device-info', [
            'form_params' => [
                'key' => env('WAPISENDER_KEY'),
                'device' => env('WAPISENDER_PAYMENT'),
        ]
        ]);

    $result= $result->getBody();
    $array = json_decode($result, true);
    $message_payment = ($array['status']);


    if ($array['message'] == "Device disconnect")
    {
        $result = $client->post('https://wapisender.com/api/v1/restart-device', [
            'form_params' => [
                'key' => env('WAPISENDER_KEY'),
                'device' => env('WAPISENDER_PAYMENT'),
        ]
        ]);
         $result= $result->getBody();
    $array = json_decode($result, true);
   
   
    $message_payment = ($array['data']['connection']);
    }

    
}
        
     catch (Exception $e)
     {
        $message_payment ="error";
     }

     return ($message_payment);

    }


 public static function wa_noc()
 {


        $message_noc="";
        try{

             $client = new Clients(); 
        $result = $client->post('https://wapisender.com/api/v1/device-info', [
            'form_params' => [
                'key' => env('WAPISENDER_KEY'),
                'device' => env('WAPISENDER_TICKET'),
        ]
        ]);

    $result= $result->getBody();
    $array = json_decode($result, true);
    $message_noc = ($array['status']);


    if ($array['message'] == "Device disconnect")
    {
        $result = $client->post('https://wapisender.com/api/v1/restart-device', [
            'form_params' => [
                'key' => env('WAPISENDER_KEY'),
                'device' => env('WAPISENDER_TICKET'),
        ]
        ]);
         $result= $result->getBody();
    $array = json_decode($result, true);
   
   
    $message_noc = ($array['data']['connection']);
    }

    
}
        
     catch (Exception $e)
     {
        $message_noc ="error";
     }
      return ($message_noc);

 }


}
