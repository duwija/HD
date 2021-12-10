<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
use \Auth;
Use GuzzleHttp\Clients;

use Xendit\Xendit;
use Exception;   
use DB;

class SuminvoiceController extends Controller
{
     public function __construct()
    {
        //$this->middleware('auth');
        $this->middleware('auth', ['except' => ['print']]); 

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
         $suminvoice = \App\Suminvoice::orderBy('id', 'DESC')
        ->where('payment_status','=', '0')
        ->get();
        
        
        return view ('suminvoice/index',['suminvoice' =>$suminvoice]);
    }
    public function transaction()
    {
        //
        $user= \App\User::pluck('name', 'id');
         $suminvoice = \App\Suminvoice::orderBy('payment_date', 'ASC')
        ->whereNotNull('updated_by')
        ->whereBetween('payment_date',[(date('Y-m-1')), (date('Y-m-d'))])
        ->get();
        
       
        return view ('suminvoice/transaction',['suminvoice' =>$suminvoice, 'user'=>$user]);
    }
     public function searchtransaction(Request $request)
    {
        //
        //dd ($request);
        $date_from = ($request['date_from']);
        $date_end = ($request['date_end']);
        $updated_by = ($request['updated_by']);
        $user= \App\User::pluck('name', 'id');
        
        if (empty($updated_by))
        {


         $suminvoice = \App\Suminvoice::orderBy('payment_date', 'ASC')
        ->whereNotNull('updated_by')
        ->whereBetween('payment_date',[($request['date_from']), ($request['date_end'])])
        ->get();
        
    }
    else
    {

        $suminvoice = \App\Suminvoice::orderBy('payment_date', 'ASC')
        ->whereNotNull('updated_by')
        ->whereBetween('payment_date',[($request['date_from']), ($request['date_end'])])
         ->where('updated_by', 'LIKE', "%".$updated_by."%") 
        ->get();
        
    }
        
       
        return view ('suminvoice/transaction',['suminvoice' =>$suminvoice, 'user' =>$user, 'date_from'=>$date_from, 'date_end'=>$date_end ]);
    }
  public function mytransaction()
    {
        //
         $suminvoice = \App\Suminvoice::orderBy('payment_date', 'ASC')
        ->where('updated_by','=',  \Auth::user()->id)

        ->whereBetween('payment_date',[(date('Y-m-1')), (date('Y-m-d'))])
        ->get();
        
        
        return view ('suminvoice/mytransaction',['suminvoice' =>$suminvoice]);
    }
     public function searchmytransaction(Request $request)
    {
        //
        $date_from = ($request['date_from']);
        $date_end = ($request['date_end']);
        


         $suminvoice = \App\Suminvoice::orderBy('payment_date', 'ASC')
        //->whereNotNull('updated_by')
        ->where('updated_by','=',  \Auth::user()->id)
        ->whereBetween('payment_date',[($request['date_from']), ($request['date_end'])])
        ->get();
    
   
        
        //dd ($suminvoice);
        return view ('suminvoice/mytransaction',['suminvoice' =>$suminvoice,'date_from'=>$date_from, 'date_end'=>$date_end ]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

     public function xendit(Request $request)
    {
        
      if($request->header("X-CALLBACK-TOKEN") == "myoOCdWvUWsXWfmffsOy0DpfepvwNg6K1Bxw02uXKK4UuRYX"){
        return ($request);
    }
        return response()->json($request);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $msg="";  
        $array="";  
        $tempcode=sha1(time());
        $id = $request->invoice_item;

        // Create numbet Invoice
       $latest = \App\Suminvoice::latest('number')->first();
      
             if (!$latest) {
                $latest_number=1;
                }
                else
                {
                 $latest_number = $latest->number+1;
                }

       

     
        foreach ($id as $id) 
        {
         
            \App\Invoice::where('id', $id)->update([
                'payment_status' => 3,

                'tempcode' => $tempcode,
            ]);
           
        }
        

 $customers = \App\customer::Where('id',$request['id_customer'])->first();


if (!empty($customers->email))
{
 $email =$customers->email;

}

   
else

   { $email ="return@trikamedia.com";}

 try
{ 
        Xendit::setApiKey(env('XENDIT_KEY'));

        $params = [
            'external_id' => $customers->customer_id,
            'payer_email' => $email,
            'description' => $customers->name,
            'amount' => $request['total'],
        ];


    $createInvoice = \Xendit\Invoice::create($params);


    $array = json_decode(json_encode($createInvoice, true))->id;  
    if ($array)
    {
         $msg .="\nSuccess create invoice on Payment Gateway with id ".$array;
    }
else{$msg .="\n  <a style='color:red'> Error create invoice on Payment Gateway </a>";}
    
  }
  catch ( Exception $e)
  {
    $msg .="\n Error create invoice on Payment Gateway ";
  }
  finally {
      

        try
        {
       \App\Suminvoice::create([
            'id_customer' => ($request['id_customer']),
            'number' => $latest_number,
            'date' => date("Y-m-d"), 
            'payment_status' => 0,
             
            'tax' => ($request['tax']),
            'total_amount' =>($request['total']),
            'payment_id' => $array,
            'tempcode' => $tempcode,
              
             ]);
         $msg .= "\nsuccess create invoice on Helpdesk System";
        }
        catch (Exception $e)
        {
            $msg .="\nError create invoice on Helpdesk System";
        }
        finally {
           
            try
            {

       $message ="Yth. ".$customers->name." ";
       $message .="\n";
       $message .="\nTagihan Customer dengan CID *".$customers->customer_id."* sudah kami Terbitkan sebesar *Rp.".$request["total"]."*";
       $message .="\nSilahakan melakukan pembayaran sebelum tanggal 20-".date("m-Y", time());
       $message .="\nUntuk info lebih lengkap silahkan klik link berikut";
       $message .="\nhttp://".env("DOMAIN_NAME")."/suminvoice/".$tempcode."/print";
       $message .="\n";
       $message .="\n~ Trikamedia ~";

    
       $msgresult= \App\Suminvoice::wa_payment($customers->phone,$message);
         $msg .="\n Whatsapp : ".$msgresult;
         
            }
            catch (Exception $e)
            {
                  $msg .="\nError sent  invoice notification to Customer";
            }
            finally {

               

            }

        }
  }

 //dd ($msg);





      // \App\Suminvoice::xendit_create_invoice($id, $customers->customer_id, $customers->email, $customers->name, $request['total']);



       // $message ="Yth. ".$customers->name." ";
       // $message .="\n";
       // $message .="\nTagihan Customer dengan CID *".$customers->customer_id."* sudah kami Terbitkan sebesar *Rp.".$request["total"]."*";
       // $message .="\nSilahakan melakukan pembayaran sebelum tanggal 20-".date("m-Y", time());
       // $message .="\nUntuk info lebih lengkap silahkan klik link berikut";
       // $message .="\nhttp://".env("DOMAIN_NAME")."/suminvoice/".$request->tempcode."/print";
       // $message .="\n";
       // $message .="\n~ Trikamedia ~";

    
       //  \App\Suminvoice::wa_payment($customers->phone,$message);

       return redirect ('invoice/'.$request->id_customer)->with('info',$msg);
    }



    public function search(Request $request)
    {
       $date_from = ($request['date_from']);
       $date_end = ($request['date_end']);
       
        $suminvoice = \App\suminvoice::orderBy('recieve_payment', 'asc')
         ->where('updated_by','=',  \Auth::user()->id)
        ->whereBetween('date',[($request['date_from']), ($request['date_end'])])
        ->get();
        
    
        return view ('suminvoice/mytransaction',['suminvoice' =>$suminvoice, 'date_from' =>$date_from, 'date_end'  =>$date_end]);
        
        

    }

    public function searchinv(Request $request)
    {
        $date_from = ($request['date_from']);
        $date_end = ($request['date_end']);
        $payment_status = ($request['payment_status']);
        // dd($payment_status);
        if ($payment_status=="")
        {
          //  dd($payment_status);
            $suminvoice = \App\Suminvoice::orderBy('id', 'DESC')
         ->whereBetween('date',[($request['date_from']), ($request['date_end'])])
     
        ->get(); 
         }
         else
         {
        $suminvoice = \App\Suminvoice::orderBy('id', 'DESC')
         ->whereBetween('date',[($request['date_from']), ($request['date_end'])])
         ->where('payment_status','=',  $payment_status)
        ->get(); 
       
         }
       
        
        
        return view ('suminvoice/index',['suminvoice'=>$suminvoice, 'date_from'=>$date_from, 'date_end'=>$date_end,'payment_status' =>$payment_status]);
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
        //dd($id);
        $bank = \App\bank::pluck('name', 'id');
        $mount = now()->format('mY');
        $invoice = \App\Invoice::where('tempcode', $id)
                  
           ->where('payment_status', '=', 3)
           ->get();
        
           if (empty($invoice[0])){
          
         return abort(404);
}
else
{
            $invoice_code = \App\Invoice::where('tempcode', $id)->first();
            $suminvoice_number = \App\Suminvoice::where('tempcode', $id)->first();
            $customer = \App\Customer::where('customers.id', $invoice_code->id_customer)
    
    ->Join('statuscustomers', 'customers.id_status', '=', 'statuscustomers.id')
    ->Join('plans', 'customers.id_plan', '=', 'plans.id')
    ->select('customers.*','statuscustomers.name as status_name','plans.name as plan_name','plans.price as plan_price')->first();
    return view ('suminvoice/show',['invoice' =>$invoice, 'customer'=>$customer, 'bank'=>$bank, 'suminvoice_number' => $suminvoice_number]);
}

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
        public function print($id)
    {
        //
        $bank = \App\bank::pluck('name', 'id');
        $mount = now()->format('mY');
           $invoice = \App\Invoice::where('tempcode', $id)
                   
           ->where('payment_status', '=', 3)
           ->get();
           if (empty($invoice[0])){
          
         return abort(404);
}
else
{

           $invoice_code = \App\Invoice::where('tempcode', $id)->first();
            $suminvoice_number = \App\Suminvoice::where('tempcode', $id)->first();
           $customer = \App\Customer::where('customers.id', $invoice_code->id_customer)
    
    ->Join('statuscustomers', 'customers.id_status', '=', 'statuscustomers.id')
    ->Join('plans', 'customers.id_plan', '=', 'plans.id')
    ->select('customers.*','statuscustomers.name as status_name','plans.name as plan_name','plans.price as plan_price')->first();
    return view ('suminvoice/test',['invoice' =>$invoice, 'customer'=>$customer, 'bank'=>$bank, 'suminvoice_number' => $suminvoice_number]);
   }
    }
      public function dotmatrix($id)
    {
        //
        $bank = \App\bank::pluck('name', 'id');
        $mount = now()->format('mY');
           $invoice = \App\Invoice::where('tempcode', $id)        
           ->where('payment_status', '=', 3)
           ->get();

           if (empty($invoice[0])){
          
         return abort(404);
}
else
{
           $invoice_code = \App\Invoice::where('tempcode', $id)->first();
            $suminvoice_number = \App\Suminvoice::where('tempcode', $id)->first();
           $customer = \App\Customer::where('customers.id', $invoice_code->id_customer)
    
    ->Join('statuscustomers', 'customers.id_status', '=', 'statuscustomers.id')
    ->Join('plans', 'customers.id_plan', '=', 'plans.id')
    ->select('customers.*','statuscustomers.name as status_name','plans.name as plan_name','plans.price as plan_price')->first();
    return view ('suminvoice/dotmatrix',['invoice' =>$invoice, 'customer'=>$customer, 'bank'=>$bank, 'suminvoice_number' => $suminvoice_number]);
 }
}
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function verify($id)
    {
        
       $query = \App\Suminvoice::where('id', $id)
            ->update([
                'verify' =>'1']);
            return redirect ('/suminvoice/transaction')->with('success','Transaction was verified');
            }


    public function update(Request $request, $id)
    {
        
       $query = \App\Suminvoice::where('id', $id)
            ->update([
                'recieve_payment' => $request->recieve_payment,
                'payment_point' => $request->payment_point,
                'note' => $request->note,
                'updated_by' => $request->updated_by,
                  'payment_status' =>1,
                   'payment_date' =>now()->toDateTimeString(),


            ]);
           
            if($query)
            {

        $customers = \App\customer::Where('id',$request->id_customer)->first();
    
       $message ="Yth. ".$customers->name." ";
       $message .="\n";
       $message .="\nTerimakasih, Pembayaran tagihan Customer dengan CID ".$customers->customer_id." sudah kami *TERIMA* ";
       $message .="\nUntuk info lebih lengkap silahkan klik link";
       $message .="\nhttp://".env("DOMAIN_NAME")."/suminvoice/".$request->tempcode."/print";

       $message .="\n~ Payment System Trikamedia ~";
       $msg = \App\Suminvoice::wa_payment($customers->phone,$message);
      

        return redirect ('/suminvoice/'. $request->tempcode)->with('success',$msg);
    }
    else
    {
        return redirect ('/suminvoice/'. $request->tempcode)->with('warning',' Update Data Field');
    }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        \App\Suminvoice::where('id', $id)
            ->update([
                
                'updated_by' => $request->updated_by,
                  'payment_status' =>2,
                   'payment_date' =>now()->toDateTimeString(),


            ]);
        return redirect ('/suminvoice/'. $request->tempcode)->with('success','Item updated successfully!');
    }
    public function faktur (Request $request, $id)
    {
          $request->validate([
        'file' => 'required'
      ]); 

      if($request->file('file')) {
         $file = $request->file('file');
         $name = str_replace('-', ' ', $file->getClientOriginalName());
         $filename = time().'_'.$name;

         // File upload location
         $location = 'upload/tax';

         // Upload file
         $file->move($location,$filename);

         $id_customer = ($request['id_customer']);

        $tempcode = ($request['tempcode']);

         \App\Suminvoice::where('id', $id)
            ->update([
                
            'file' => $filename


            ]);


        return redirect ('/suminvoice/'.$tempcode)->with('success','file Updated successfully!');
      }else{
        return redirect ('/suminvoice'.$tempcode)->with('success','File Not Uploaded!');
      }
  }
}
