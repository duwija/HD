<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \RouterOS\Client;
use \RouterOS\Query;
use Exception;
use GuzzleHttp\Exception\GuzzleException;
Use GuzzleHttp\Clients;
use Xendit\Xendit;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
      public function schedule()
      {

         $today =date("Y-m-d");

        $ticket = \App\Ticket::orderBy('time', 'ASC')
        ->where('date', '=', $today )
        ->get();
            return view ('welcome',['ticket' =>$ticket]);

      }
    public function index()
    {
        $today =date("Y-m-d");

        $ticket = \App\Ticket::orderBy('time', 'ASC')
        ->where('date', '=', $today )
        ->get();
        
        $ticket_count = \App\Ticket::where('status', '=', 'Open' )
        ->count();

        $invoice_count = \App\Suminvoice::where('payment_status', '=', '0' )
        ->count();

        $ticket_count_today = \App\Ticket::where('date', '=', $today )
        ->count();
        $cust_active = \App\Customer::where('id_status', '=', '1' )
        
        ->count();
        $invoice_paid = \App\Suminvoice::where('payment_status', '=', '1' )
        ->where('payment_date', 'like',$today.'%' )
        ->count();






   return view ('home',['ticket' =>$ticket, 'ticket_count'=>$ticket_count, 'ticket_count_today'=>$ticket_count_today, 'cust_active'=>$cust_active, 'invoice_count' => $invoice_count, 'invoice_paid' => $invoice_paid] );
    
        
    }

    public function mikrotik()
    {






        try {

            $client = new Client([
                'host' => '103.156.74.1',
                'user' => 'duwija',
                'pass' => 'rh4ps0dy',
                'port' =>  8787
            ]);



// Create "where" Query object for RouterOS
            $query =
    // (new Query('/ip/hotspot/ip-binding/print'))
    //     ->where('mac-address', 'B0:4E:26:44:B5:35');


// (new Query('/ppp/secret/add '))
//         ->equal('name', 'mikrotikApi')
//         ->equal('password', 'mikrotikapi')
//         ->equal('comment', 'testcomment');

            (new Query('/ppp/secret/print'))

            ->where('name', 'mikrotikApi');


            $secrets = $client->query($query)->read();


            echo "Before update" . PHP_EOL;


            foreach ($secrets as $secret) {

    // Change password
                $query = (new Query('/ppp/secret/set'))
                ->equal('.id', $secret['.id'])
                ->equal('disabled', 'false')
                ->equal('comment', 'enable by');

    // Update query ordinary have no return
                $client->query($query)->read();
                echo "User Was  disabled" . PHP_EOL;
    //print_r($secret['disabled']);



            }

// Send query and read response from RouterOS
// $response = $client->query($query)->read();

// var_dump($response);


        } catch (Exception $ex) {
            abort(404, 'Github Repository not found');
        }









    }








// test only



    public function mikrotik_addsecreate()
    {

       try {

        $client = new Client([
            //to login to api
            'host' => '202.169.255.3',
            'user' => 'duwija',
            'pass' => 'rh4ps0dy',
            'port' => 8728,
            //data
            

        ]);
        $cid      = 'testing';
        $cidpass   = '1234';
        $comment   = 'comment';




// check user exist 
        $query_check =

        (new Query('/ppp/secret/print'))

        ->where('name',$cid);

        $users = $client->query($query_check)->read();


//var_dump($users);
            // if user exist
        if (!empty($users[0]['.id'])) {
            // set the user enable
         foreach ($users as $user) {

    // enable
            $query_enable = (new Query('/ppp/secret/set'))
            ->equal('.id', $user['.id'])
            ->equal('disabled', 'false');


            $result = $client->query($query_enable)->read();

// echo $result;

        }
    }

    else
    {

        $query_add =

        (new Query('/ppp/secret/add '))
        ->equal('name', $cid)
        ->equal('password', $cidpass)
        ->equal('comment', $comment)
        ->equal('profile', 'UPTO_20MBPS');


        $response = $client->query($query_add)->read();

    }

} catch (Exception $ex) {
    abort(404, 'Github Repository not found');
}


}

    public function mikrotik_disablesecreate()
    {

       try {

        $client = new Client([
            //to login to api
            'host' => '103.156.75.19',
            'user' => 'duwija',
            'pass' => 'rh4ps0dy',
            'port' => 8787,
            //data
            

        ]);
        $cid      = '121212';
      




// check user exist 
        $query_check =

        (new Query('/ppp/secret/print'))

        ->where('name',$cid);

        $users = $client->query($query_check)->read();


//var_dump($users);
            // if user exist
        if (!empty($users[0]['.id'])) {
            // set the user enable
         foreach ($users as $user) {

    // enable
            $query_enable = (new Query('/ppp/secret/set'))
            ->equal('.id', $user['.id'])
            ->equal('disabled', 'true');


            $result = $client->query($query_enable)->read();

// echo $result;

        }
    }


} catch (Exception $ex) {
    abort(404, 'Github Repository not found');
}


}

public function mikrotik_statussecreate()
    {

       try {

        $client = new Client([
            //to login to api
            'host' => '103.156.75.19',
            'user' => 'duwija',
            'pass' => 'rh4ps0dy',
            'port' => 8787,
            //data
            

        ]);
        $cid      = '121212';
      




// check user exist 
        $query_check =

        (new Query('/ppp/secret/print'))

        ->where('name',$cid);

        $users = $client->query($query_check)->read();


//var_dump($users);
            // if user exist
        if (!empty($users[0]['.id'])) {
            // set the user enable
         foreach ($users as $user) {

    // enable
            $query_enable = (new Query('/ppp/secret/set'))
            ->equal('.id', $user['.id'])
            ->equal('disabled', 'true');


            $result = $client->query($query_enable)->read();

// echo $result;

        }
    }


} catch (Exception $ex) {
    abort(404, 'Github Repository not found');
}


}


public function mikrotik_status()
    {
        $result = 'unknow';

        try {

            $client = new Client([
                //to login to api
            'host' => '202.169.245.1',
            'user' => 'duwija',
            'pass' => 'rh4ps0dyv01c3#$',
            'port' => 8787,
            ]);

            $query =
            (new Query('/ppp/active/print'))
            ->where('name', 'novia@fam');


            $response = $client->query($query)->read();
          //  var_dump ($response);

            foreach ($response as $response) {
                $result = $response['uptime'];
            }
            if (!empty($result))
        {
            $status ='Online : '. $response['uptime'];
        }
       
        else
        {
            $status = 'Offline';
        }


        } catch (Exception $ex) {
            $status = 'Unknow';
        }

        
        return $status;

    }




//++++++++++++++++++++++++++++++++++++++++++


     public function mikrotik_addprofile()
    {

       try {

        $client = new Client([
            //to login to api
            'host' => '103.156.75.19',
            'user' => 'duwija',
            'pass' => 'rh4ps0dy',
            'port' => 8787,
            //data
            

        ]);
        $name      = 'UPTO_20M';
        $limit   = '10M/10M 20M/20M 7680k/7680k 16/16 8 5M/5M';
        $comment   = 'comment';




// check user exist 
        $query_check =

        (new Query('/ppp/profile/print'))

        ->where('name',$name);

        $profiles = $client->query($query_check)->read();


//var_dump($users);
            // if user exist
        if (!empty($profiles[0]['.id'])) {
            // set the user enable
         foreach ($profiles as $profile) {

    // enable
            $query_enable = (new Query('/ppp/profile/set'))
            ->equal('.id', $profile['.id'])
            ->equal('disabled', 'false');


            $result = $client->query($query_enable)->read();

// echo $result;

        }
    }

    else
    {

        $query_add =

        (new Query('/ppp/profile/add '))
        ->equal('name',$name)
        ->equal('rate-limit', $limit)
        ->equal('comment', $comment);


        $response = $client->query($query_add)->read();

    }

} catch (Exception $ex) {
    abort(404, 'Github Repository not found');
}


}




public function wa()
    {
  $client = new Clients(); 
        $result = $client->post('https://wapisender.com/api/v1/device-info', [
            'form_params' => [
                'key' => env('WAPISENDER_KEY'),
                'device' => env('WAPISENDER_PAYMENT'),
        ]
        ]);

    $result= $result->getBody();
    $array = json_decode($result, true);
    $message=$array['message'];
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
    $message=$array['data']['connection'];

    }

    return($message);
    }

    public function wa_payment($phone, $message)
    {

$client = new Clients(); 
$result = $client->post('https://wapisender.com/api/v1/send-message', [
    'form_params' => [
        'key' => env('WAPISENDER_KEY'),
        'device' => env('WAPISENDER_PAYMENT'),
        // 'group_id' => '3013',
        'destination' => $phone,
        'message' => $message,
    ]
]);

echo $result->getStatusCode();
        // 200
         $result->getHeader('content-type');
        // // 'application/json; charset=utf8'
         echo $result->getBody();

    }

    public function xendit()
    {


Xendit::setApiKey('xnd_development_jDSCoSFFyJpKTkyIXg7Je6frM1Cz4QnQkJn5pKZv5q6ZEHOqlWazGM5jgAGHL9');

$params = ['external_id' => '11111111111',
    'payer_email' => 'sample_email@xendit.co',
    'description' => 'Trip to Bali',
    'amount' => 4000000
];

$createInvoice = \Xendit\Invoice::create($params);
 $array = json_decode(json_encode($createInvoice, true));
 dd ($array);


    }


}
