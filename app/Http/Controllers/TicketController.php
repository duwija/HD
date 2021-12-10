<?php

namespace App\Http\Controllers;

use App\Tiket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use \Auth;
use \RouterOS\Client;
use \RouterOS\Query;
Use GuzzleHttp\Clients;
use Exception;
use PDF;
class TicketController extends Controller
{
     public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.

     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ticket = \App\Ticket::orderBy('id', 'DESC')->get();
        
        
        return view ('ticket/index',['ticket' =>$ticket]);
    }
public function myticket()
    {
        $id = Auth::user()->id;
        $ticket = \App\Ticket::orderBy('id', 'DESC')
        ->where('assign_to', $id)
        ->get();
        
        
        return view ('ticket/myticket',['ticket' =>$ticket, 'title'=> 'Ticket List | My Ticket']);
    }



public function view($id)
    {
       
       
        $ticket = \App\Ticket::orderBy('id', 'DESC')
        ->where('id_customer','=', $id)
        ->get();
        
        
        return view ('ticket/index',['ticket' =>$ticket]);
        
        
        
    }

    public function search(Request $request)
    {
       $date_from = ($request['date_from']);
       $date_end = ($request['date_end']);
       
        $ticket = \App\Ticket::orderBy('id', 'DESC')
        ->whereBetween('date',[($request['date_from']), ($request['date_end'])])
        ->get();
        
    
        return view ('ticket/index',['ticket' =>$ticket, 'date_from' =>$date_from, 'date_end'  =>$date_end]);
        
        
        
    }




    public function uncloseticket()
    {
        $id = Auth::user()->id;
        $ticket = \App\Ticket::orderBy('id', 'DESC')
        ->where('assign_to','=', $id)
        ->where('status','!=', 'Close')
        ->get();
        
        
        return view ('ticket/myticket',['ticket' =>$ticket, 'title'=>'Ticket List | My UnClose Ticket']);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        
        $category = \App\Ticketcategorie::pluck('name', 'id');
        $user= \App\User::pluck('name', 'id');
        $status = \App\Statuscustomer::pluck('name', 'id');
        $distpoint = \App\Distpoint::pluck('name', 'id');
        $plan = \App\Plan::pluck('name', 'id');
        $customer_coordinate = \App\Customer::where('id', $id)->pluck('coordinate');
       

    $customer = \App\Customer::where('customers.id', $id)
    ->Join('distpoints', 'customers.id_distpoint', '=', 'distpoints.id')
    ->Join('statuscustomers', 'customers.id_status', '=', 'statuscustomers.id')
    ->Join('plans', 'customers.id_plan', '=', 'plans.id')
    ->select('customers.*','distpoints.name as distpoint_name','statuscustomers.name as status_name','plans.name as plan_name')->first();

    if ( $customer == null)
    {
        return abort(404);
    }
    else
    {
        
     //   dd($customer);
        if ($customer_coordinate == null)
        
        {
            $customer_coordinate ='-8.471722, 115.289472';
        }
        

        
$config['center'] = $customer_coordinate;
$config['zoom'] = '13';
//$this->googlemaps->initialize($config);

$marker = array();
$marker['position'] =$customer_coordinate;
$marker['draggable'] = true;
$marker['ondragend'] = 'updateDatabase(event.latLng.lat(), event.latLng.lng());';

    app('map')->initialize($config);
        
        app('map')->add_marker($marker);
        $map = app('map')->create_map();

        
        return view ('ticket/create',['customer' => $customer, 'map' => $map, 'status' => $status, 'distpoint'=>$distpoint, 'plan' => $plan, 'category'=>$category, 'user'=>$user  ] );
    }
}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

       // dd ($request);
        //
        $member = $request->input('member');
        if ($member == null)
        {
            $member ="";
        }
        else{


        
        $member = implode(',', $member);
    }
      //  dd ($member);
        $description=$request->input('description');
        $dom = new \DomDocument();
        $dom->loadHtml($description, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);    
        $images = $dom->getElementsByTagName('img');
 
        foreach($images as $key => $img){
            $data = $img->getAttribute('src');
 
            list($type, $data) = explode(';', $data);
            list(, $data)      = explode(',', $data);
            $data = base64_decode($data);
 
            $image_name= "/upload/ticket/" . time().$key.'.png';
            $path = public_path() . $image_name;
 
            file_put_contents($path, $data);
            
            $img->removeAttribute('src');
            $img->setAttribute('src', $image_name);
        }
 
        $description = $dom->saveHTML();
        \App\Ticket::create([
            'id_customer' => ($request['id_customer']),
            'called_by' => ($request['called_by']),
            'phone' => ($request['phone']), 
            'status' => ($request['status']),
            'id_categori' => ($request['id_categori']),
            'tittle' => ($request['tittle']),
            // 'description' => ($request['description']),
             'description' => $description,
            'assign_to' => ($request['assign_to']),
            'member' => ($member),
            'date' => ($request['date']),
            'time' => ($request['time']),
            'create_by' => ($request['create_by']),
            'updated_at' => ($request['created_at']),

            

           
        ]);

      return redirect ('/ticket')->with('success','Item created successfully!');


    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Tiket  $tiket
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ticket = \App\Ticket::findOrFail($id);

        $category = \App\Ticketcategorie::pluck('name', 'id');
        $user= \App\User::pluck('name', 'id');
       
        $distpoint = \App\Distpoint::pluck('name', 'id');

        $plan = \App\Plan::pluck('name', 'id');
        $user = \App\User::pluck('name', 'id');
        $users = \App\User::pluck('name', 'id');
     
        

        
         return view ('ticket/show',['ticket' => $ticket, 'distpoint'=>$distpoint,'user'=>$user,'users'=>$users, 'plan' => $plan, 'category'=>$category ] );
     //return view ('ticket/show',['ticket' => $ticket] );
    }


 public function print_ticket($id)
 {
    $ticket = \App\Ticket::findOrFail($id);

        $category = \App\Ticketcategorie::pluck('name', 'id');
        $user= \App\User::pluck('name', 'id');
       
        $distpoint = \App\Distpoint::pluck('name', 'id');

        $plan = \App\Plan::pluck('name', 'id');
        $user = \App\User::pluck('name', 'id');
        $users = \App\User::pluck('name', 'id');
 
     
  $pdf = PDF::loadview('pdf',['ticket' => $ticket, 'distpoint'=>$distpoint,'user'=>$user,'users'=>$users, 'plan' => $plan, 'category'=>$category ] );
  return $pdf->download('Ticket-pdf'.$id);

        
     //return view ('ticket/show',['ticket' => $ticket] );
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Tiket  $tiket
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
         $ticket = \App\Ticket::findOrFail($id);
         $customer = \App\Customer::findOrFail($ticket->id_customer);

        $category = \App\Ticketcategorie::pluck('name', 'id');
        $user= \App\User::pluck('name', 'id');
       
        $distpoint = \App\Distpoint::pluck('name', 'id');

        $plan = \App\Plan::pluck('name', 'id');
        $user = \App\User::pluck('name', 'id');
        return view ('ticket/edit',['ticket' => $ticket, 'customer' =>$customer, 'distpoint'=>$distpoint,'user'=>$user, 'plan' => $plan, 'category'=>$category ] );

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tiket  $tiket
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tiket $tiket)
    {
        //
    }

    public function editticket(Request $request, $id)
    {
        $member = $request->input('member');
        if ($member == null)
        {
            $member ="";
        }
        else{


        
        $member = implode(',', $member);
    }

        \App\Ticket::where('id', $id)
            ->update([
                'status' => $request->status,
                 'assign_to' => ($request['assign_to']),
                  'member' => ($member),
                 'date' => ($request['date']),
                  'time' => ($request['time']),

            ]);
            $url ='/ticket/'.$request->id;
        return redirect ($url)->with('success','Item updated successfully!');
    }

    public function updateassign(Request $request, $id)
    {
    // $member = $request->input('member');
    //     if ($member == null)
    //     {
    //         $member ="";
    //     }
    //     else{


        
    //     $member = implode(',', $member);
    // }

    //     \App\Ticket::where('id', $id)
    //         ->update([
    //          'assign_to' => ($request['assign_to']),
    //         'member' => ($member),
                

    //         ]);
    //         $url ='ticket/'.$request->id;
    //    return redirect ($url)->with('success','Item updated successfully!');
    }
     
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tiket  $tiket
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tiket $tiket)
    {
        //
    }


public function wa_ticket(Request $request)
{
//dd ($request);
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

    return redirect ('/ticket/'.$request->id_ticket)->with('success','Message '.$array['status'].' - '.$array['message']); 


}
}
