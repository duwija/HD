<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use \RouterOS\Client;
use \RouterOS\Query;
Use GuzzleHttp\Clients;
use \App\Customer;

use Exception;
class CustomerController extends Controller
{
    

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response

     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function search(Request $request)
    {
        $val =$request->search ;
        $customer = \App\Customer::orderBy('id', 'DESC')
        ->where('name', 'LIKE', "%".$val."%") 
        ->orWhere('customer_id', 'LIKE', "%".$val."%") 
        ->orWhere('address', 'LIKE', "%".$val."%") 
         ->orWhere('phone', 'LIKE', "%".$val."%") 
        ->get();
        
        
        return view ('customer/index',['customer' =>$customer]);
    }
    public function index()
    {
        //
        $customer = \App\Customer::orderBy('id','DESC')->get();
        //$customer =DB::table('customers')->get();
       // dump($customer);
        return view ('customer/index',['customer' =>$customer]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $status = \App\Statuscustomer::pluck('name', 'id');
        $distpoint = \App\Distpoint::pluck('name', 'id');
        $distrouter = \App\Distrouter::pluck('name', 'id');
        $plan = \App\Plan::pluck('name', 'id');
        //
        $config['center'] = env('COORDINATE_CENTER');
        $config['zoom'] = '13';
//$this->googlemaps->initialize($config);

        $marker = array();
        $marker['position'] = env('COORDINATE_CENTER');
        $marker['draggable'] = true;
        $marker['ondragend'] = 'updateDatabase(event.latLng.lat(), event.latLng.lng());';

        app('map')->initialize($config);
        
        app('map')->add_marker($marker);
        $map = app('map')->create_map();

        
        return view ('customer/create',['map' => $map, 'status' => $status, 'distpoint' => $distpoint, 'distrouter' => $distrouter, 'plan' => $plan  ] );

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//dd($request);
        $request ->validate([

            'customer_id' => 'required',
            'name' => 'required',
            'contact_name' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'npwp'  => 'nullable|numeric',
            'tax' => 'required|numeric',
            'email' => 'nullable|email',
        ]);

        $messege ='';
        try
        {

            $status = \App\Statuscustomer::Where('id',$request->id_status)->first();
            if ((!empty($request->id_distrouter)) and (!empty($request->id_plan)) and ($status->name == 'Active')) 
            {

              $distrouter = \App\distrouter::Where('id',$request->id_distrouter)->first();
              $plan = \App\plan::Where('id',$request->id_plan)->first();

                        
                  \App\Distrouter::mikrotik_addprofile($distrouter->ip,$distrouter->user,$distrouter->password,$distrouter->port,$plan->name,$plan->speed,$plan->description);
                  \App\Distrouter::mikrotik_addsecreate($distrouter->ip,$distrouter->user,$distrouter->password,$distrouter->port,$request->customer_id,$request->password,$plan->name,$request->name);
             

                  }              
       } catch (Exception $e)

       { 
        $messege =" Field to Access to Router, please check connection between System and Router";

    } finally {


        try{
           \App\customer::create($request->all());
       }
       catch (Exeption $e)
       {
           $messege .=" * Field add user on system, please remove manually user on Router";
       }finally {

           $messege .=" *  User Successfuly added on system ";
       }

   }


     //  else
     //  {
     //     $messege ='Item created successfully ** User In Distribution Router NOT created ** !!';
     // }


       // $this->mikrotik($request->name,$request->customer_id,$request->password);
       // \App\Distrouter::mikrotik_addsecreate($ip,$user,$pass,$port,$request->customer_id,$pass,$request->name);

   return redirect ('/customer/')->with('success',$messege);




}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $customer = \App\Customer::findOrFail($id);
        //$customer =DB::table('customers')->get();
      // dd($customer);

      if  (\App\Customer::findOrFail($id) ->coordinate == null)
      {
        $coordinate =env('COORDINATE_CENTER');
    }
    else
    {
        $coordinate =\App\Customer::findOrFail($id) ->coordinate;
    }


    $config['center'] = $coordinate;
    $config['zoom'] = '13';
//$this->googlemaps->initialize($config);

    $marker = array();
    $marker['position'] = $coordinate;
        //$marker['draggable'] = true;
        //$marker['ondragend'] = 'updateDatabase(event.latLng.lat(), event.latLng.lng());';

    app('map')->initialize($config);

    app('map')->add_marker($marker);
    $map = app('map')->create_map();
    return view ('customer/show',['customer' =>$customer,'map' => $map]);
}

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $status = \App\Statuscustomer::pluck('name', 'id');
        $distpoint = \App\Distpoint::pluck('name', 'id');
        $distrouter = \App\Distrouter::pluck('name', 'id');
        $plan = \App\Plan::pluck('name', 'id');
        // $topologycustomer = \App\topologycustomer::findOrFail($id);
       //  $customer_coordinate = \App\Customer::findOrFail($id);


        if  (\App\Customer::findOrFail($id)->coordinate == null)
        {
            $coordinate =env('COORDINATE_CENTER');
        }
        else
        {
            $coordinate =\App\Customer::findOrFail($id)->coordinate;
        }
        //
        $config['center'] =  $coordinate;
        $config['zoom'] = '13';
//$this->googlemaps->initialize($config);

        $marker = array();
        $marker['position'] = $coordinate;
        $marker['draggable'] = true;
        $marker['ondragend'] = 'updateDatabase(event.latLng.lat(), event.latLng.lng());';

        app('map')->initialize($config);
        
        app('map')->add_marker($marker);
        $map = app('map')->create_map();

        
        return view ('customer/edit',['customer' => \App\Customer::findOrFail($id),'map' => $map, 'status' => $status, 'distpoint' => $distpoint, 'distrouter' => $distrouter, 'plan' => $plan ] );

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

     public function update_status(Request $request)
    {
try
{
      $id = $request->id;
      $status = $request->status;
      if($status==0)
      {
      foreach ($id as $id) 
        {

          $customers = \App\customer::Where('id',$id)->first();
          $distrouter = \App\distrouter::withTrashed()->Where('id',$customers->id_distrouter)->first();
            \App\customer::where('id', $id)->update([
                'id_status' => 4,

            ]);
             \App\Distrouter::mikrotik_disable($distrouter->ip,$distrouter->user,$distrouter->password,$distrouter->port,$customers->customer_id);
           
        }
      }
      if ($status==1) {
            foreach ($id as $id) 
        {

          $customers = \App\customer::Where('id',$id)->first();
          $distrouter = \App\distrouter::withTrashed()->Where('id',$customers->id_distrouter)->first();
            \App\customer::where('id', $id)->update([
                'id_status' => 2,

            ]);
             \App\Distrouter::mikrotik_enable($distrouter->ip,$distrouter->user,$distrouter->password,$distrouter->port,$customers->customer_id);
           
        }
        
      }
      return redirect ('/customer/')->with('success','Item Updates successfully!'); 
    }
        catch (Exception $ex)
        {
          return redirect ('/customer/'.$id)->with('warning','Item Updates FIELD!'); 
        }
        
        


    }
    public function update(Request $request, $id)
    {
        //
       // dd($request);
        $request ->validate([
            'name' => 'required',
            
            'contact_name' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'npwp'  => 'nullable|numeric',
            'tax' => 'nullable|numeric',
            'email' => 'nullable|email',
        ]);

        $customers = \App\customer::Where('id',$id)->first();
        $plan = \App\plan::withTrashed()->Where('id',$customers->id_plan)->first();

        $status = \App\Statuscustomer::withTrashed()->Where('id',$request->id_status)->first();
        $distrouter = \App\distrouter::withTrashed()->Where('id',$customers->id_distrouter)->first();
      //  $distrouter_new = \App\distrouter::withTrashed()->Where('id',$customers->id_distrouter)->first();


          if ((($status->name == 'Active') OR ($status->name == 'Company_Properti')) and ($plan->id == $request->id_plan) and ($distrouter->id == $request->id_distrouter))
        {
            try
            {
          $plan_new = \App\plan::Where('id',$request->id_plan)->first();
          $distrouter_new = \App\distrouter::Where('id',$request->id_distrouter)->first();
          \App\Distrouter::mikrotik_addprofile($distrouter_new->ip,$distrouter_new->user,$distrouter_new->password,$distrouter_new->port,$plan_new->name,$plan_new->speed,$plan_new->description);
          \App\Distrouter::mikrotik_addsecreate($distrouter_new->ip,$distrouter_new->user,$distrouter_new->password,$distrouter_new->port,$customers->customer_id,$request->password,$plan_new->name,$request->name);
        }catch (Exception $ex) {

          }
        }

        else if ((($status->name != 'Active') OR ($status->name == 'Company_Properti')) and ($plan->id == $request->id_plan) and ($distrouter->id == $request->id_distrouter))
        {
            try {
              echo '2';

              \App\Distrouter::mikrotik_disable($distrouter->ip,$distrouter->user,$distrouter->password,$distrouter->port,$customers->customer_id);
          }

          catch (Exception $ex) {

          }
      }
      else if ((($status->name == 'Active') OR ($status->name == 'Company_Properti')) and (($plan->id != $request->id_plan) or ($distrouter->id != $request->id_distrouter)))
      {

        try
        {
          echo '3';
          $plan_new = \App\plan::Where('id',$request->id_plan)->first();
          $distrouter_new = \App\distrouter::Where('id',$request->id_distrouter)->first();
          \App\Distrouter::mikrotik_remove($distrouter->ip,$distrouter->user,$distrouter->password,$distrouter->port,$customers->customer_id);
          \App\Distrouter::mikrotik_addprofile($distrouter_new->ip,$distrouter_new->user,$distrouter_new->password,$distrouter_new->port,$plan_new->name,$plan_new->speed,$plan_new->description);
          \App\Distrouter::mikrotik_addsecreate($distrouter_new->ip,$distrouter_new->user,$distrouter_new->password,$distrouter_new->port,$customers->customer_id,$request->password,$plan_new->name,$request->name);

      }
      catch (Exception $ex) {

      }
  }

  else if ((($status->name != 'Active') OR ($status->name == 'Company_Properti')) and (($plan->id != $request->id_plan) or ($distrouter->id != $request->id_distrouter)))
  {

    try{
      echo '4';

      $plan_new = \App\plan::Where('id',$request->id_plan)->first();
      $distrouter_new = \App\distrouter::Where('id',$request->id_distrouter)->first();
      \App\Distrouter::mikrotik_remove($distrouter->ip,$distrouter->user,$distrouter->password,$distrouter->port,$customers->customer_id);
      \App\Distrouter::mikrotik_addprofile($distrouter_new->ip,$distrouter_new->user,$distrouter_new->password,$distrouter_new->port,$plan_new->name,$plan_new->speed,$plan_new->description);
      \App\Distrouter::mikrotik_addsecreate($distrouter_new->ip,$distrouter_new->user,$distrouter_new->password,$distrouter_new->port,$customers->customer_id,$request->password,$plan_new->name,$request->name);
      \App\Distrouter::mikrotik_disable($distrouter_new->ip,$distrouter_new->user,$distrouter_new->password,$distrouter_new->port,$customers->customer_id);

  }
  catch (Exception $ex) {

  }
}

try
{



    \App\Customer::where('id', $id)
    ->update([

        'name' => $request->name,
        'password' => $request->password,
        'contact_name' => $request->contact_name,
        'phone' => $request->phone,
        'address' => $request->address,
        'npwp'  => $request->npwp,
        'tax' => $request->tax,
        'email' => $request->email,
        'id_plan' => $request->id_plan,
        'id_distpoint' => $request->id_distpoint,
        'id_distrouter' => $request->id_distrouter,
        'id_status' => $request->id_status,
        'coordinate' => $request->coordinate,
        'note' => $request->note,
        'updated_by' => $request->updated_by,
        'updated_at' => $request->updated_at,


    ]);


    return redirect ('/customer/'.$id)->with('success','Item Updates successfully!'); 
}
catch (Exception $ex) {
    return redirect ('/customer/'.$id)->with('success','Item Updates FIELD!!'); 
}
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      try
      {
      $customers = \App\customer::Where('id',$id)->first();
       $distrouter = \App\distrouter::withTrashed()->Where('id',$customers->id_distrouter)->first();
      \App\Customer::destroy($id);
      \App\Distrouter::mikrotik_remove($distrouter->ip,$distrouter->user,$distrouter->password,$distrouter->port,$customers->customer_id);
      return redirect ('/customer/')->with('success','Item deleted successfully!');
      }
  catch (Exception $ex) {
return redirect ('/customer/')->with('success','Field!');
  }
  }

//   public function mikrotik($name, $customerid, $password)
//   {


//     $client = new Client([
//         'host' => '202.169.255.3',
//         'user' => 'duwija',
//         'pass' => 'rh4ps0dy',
//         'port' =>  8728
//     ]);


// // Create "where" Query object for RouterOS
//     $query =
//     // (new Query('/ip/hotspot/ip-binding/print'))
//     //     ->where('mac-address', 'B0:4E:26:44:B5:35');


//     (new Query('/ppp/secret/add '))
//     ->equal('name', $customerid)
//     ->equal('password', $password)
//     ->equal('comment', $name);

// // (new Query('/ppp/secret/print'))

// //  ->where('name', 'mikrotikApi');



// // $secrets = $client->query($query)->read();

// // echo "Before update" . PHP_EOL;


// //        foreach ($secrets as $secret) {

// //     // Change password
// //     $query = (new Query('/ppp/secret/set'))
// //         ->equal('.id', $secret['.id'])
// //         ->equal('disabled', 'false');

// //     // Update query ordinary have no return
// //     $client->query($query)->read();
// //     echo "User Was  Update" . PHP_EOL;
// //     print_r($secret['disabled']);

// // }

// // Send query and read response from RouterOS
//     $response = $client->query($query)->read();

//  // var_dump($response);
// }



public function wa_customer(Request $request)
{
// dd ($request->message);
    $client = new Clients(); 
    $result = $client->post('https://wapisender.com/api/v1/send-message', [
        'form_params' => [
            'key' => env('WAPISENDER_KEY'),
            'device' => $request->device,
        // 'group_id' => '3013',
            'destination' => $request->phone,
            'message' =>$request->message,
        ]
    ]);

// echo $result->getStatusCode();
//         // 200
//          $result->getHeader('content-type');
        // // 'application/json; charset=utf8'
    $result= $result->getBody();
    $array = json_decode($result, true);

    return redirect ('/customer/'.$request->id_customer)->with('success','Message '.$array['status'].' - '.$array['message']); 


}



}
