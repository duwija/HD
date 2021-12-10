<?php



namespace App\Http\Controllers;
use App\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
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
    if ((Auth::user()->privilege)=="admin")
    
 {
     
   
 $suminvoice = \App\Suminvoice::orderBy('id', 'DESC')
        ->whereBetween('date',[(date('y-m-1')), (date('y-m-d'))])
        ->get();
       // dd ($suminvoice);
        return view ('suminvoice/index',['suminvoice' =>$suminvoice]);

  
              
   }
   else
   {
      return redirect()->back()->with('error','Sorry, You Are Not Allowed to Access Destination page !!');
   }
 }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        //
     $mount = now()->format('mY');
     $invoice = \App\Invoice::where('id_customer', $id)
     ->where('payment_status', '=', 0)
     ->get(); 

     $customer = \App\Customer::where('customers.id', $id)
     ->Join('statuscustomers', 'customers.id_status', '=', 'statuscustomers.id')
     ->Join('plans', 'customers.id_plan', '=', 'plans.id')
     ->select('customers.*','statuscustomers.name as status_name','plans.name as plan_name','plans.price as plan_price')->first();

     if (empty($customer)){

       return abort(404);
   }
   else
   {


    //$customer = \App\customer::findOrFail($id);
          // dd ($invoice);

    return view ('invoice/create',['invoice' =>$invoice, 'customer'=>$customer]);
         // return redirect ('/distpoint')->with('success','Item updated successfully!');
}
}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function createinvoice(Request $request)
    {
        //dd($request);
        $id = $request->invoice_item;


        $tempcode=sha1(time());

        foreach ($id as $id) 
        {

            \App\Invoice::where('id', $id)->update([
                'tempcode' => $tempcode,
            ]);

        }
        
        $invoice =\App\Invoice::where('tempcode', $tempcode)
        ->where('id_customer', '=', $request->id_customer)
        ->get();
         //  dd($invoice);
        $customer = \App\Customer::where('customers.id',$request->id_customer )

        ->Join('statuscustomers', 'customers.id_status', '=', 'statuscustomers.id')
        ->Join('plans', 'customers.id_plan', '=', 'plans.id')
        ->select('customers.*','statuscustomers.name as status_name','plans.name as plan_name','plans.price as plan_price')->first();
    //$customer = \App\customer::findOrFail($id);

        
        return view ('invoice/invoicesum',['invoice' =>$invoice, 'customer'=>$customer]);


        
    }
    public function store(Request $request)
    {
        //

       $periode_month= $request->input('periode_month');
       $periode_year=$request->input('periode_year');
       $periode = $periode_month.$periode_year;
       if (($request['monthly_fee'])==1)
       {

        $check_invoice = \App\invoice::where('id_customer', $request['id_customer'])->Where('periode', $periode)->Where('monthly_fee','1')->first();
        //dd($check_invoice);

        if (!$check_invoice)
        {




            $request ->validate([
                'id_customer' => 'required',
                'monthly_fee' => 'required',
                'description' => 'required',
                'qty' => 'required',
                'amount' => 'required',

            ]);



            \App\Invoice::create([
                'id_customer' => ($request['id_customer']),
                'monthly_fee' => ($request['monthly_fee']),
                'periode' => $periode, 
                'description' => ($request['description']),
                'qty' => ($request['qty']),
                'amount' => ($request['amount']),
            ]);

            // \Log::channel('invoice')->info('INVOICE CREATED to '.$customer["name"].' with amount = '.$customer["price"].' MANUALLY' );      
            return redirect ('/invoice/'.$request['id_customer'].'/create')->with('success','Item created successfully!');
        }
        else
        {

            return redirect ('/invoice/'.$request['id_customer'].'/create')->with('error','Item Monthly Fee with the same period already exist!!');
        }
    }
    else
    {



        $request ->validate([
            'id_customer' => 'required',
            'monthly_fee' => 'required',
            'description' => 'required',
            'qty' => 'required',
            'amount' => 'required',
            
        ]);



        \App\Invoice::create([
            'id_customer' => ($request['id_customer']),
            'monthly_fee' => ($request['monthly_fee']),
            'periode' => $periode, 
            'description' => ($request['description']),
            'qty' => ($request['qty']),
            'amount' => ($request['amount']),
        ]);


        return redirect ('/invoice/'.$request['id_customer'].'/create')->with('success','Item created successfully!');
    }


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



           //Sumary Invoice

        $suminvoice = \App\Suminvoice::where('id_customer', $id)
         //   ->where('periode', '=', $mount)
             //->where('monthly_fee', '=', 1)

          // ->where('payment_status', '!=', 1)
        ->get();



        $customer = \App\Customer::where('customers.id', $id)

        ->Join('statuscustomers', 'customers.id_status', '=', 'statuscustomers.id')
        ->Join('plans', 'customers.id_plan', '=', 'plans.id')
        ->select('customers.*','statuscustomers.name as status_name','plans.name as plan_name','plans.price as plan_price')->first();
    //$customer = \App\customer::findOrFail($id);
          // dd ($invoice);
        
        return view ('invoice/show',['suminvoice' =>$suminvoice, 'customer'=>$customer]);
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, $cid)
    {
        $id=\App\Invoice::dencrypt($id);
        \App\Invoice::destroy($id);
        return redirect ('/invoice/'.$cid.'/create')->with('success','Item deleted successfully!');
    }






    public function invoicehandle()
    {
       
DB::transaction(function() {
      //
   
        \Log::channel('invoice')->info('==== START INVOICE CREATE BY SYSTEM. ===');

         $active_customer = \App\Customer::where('customers.id_status', '2')
         ->orWhere('customers.id_status', '4') 
        
         ->Join('plans', 'customers.id_plan', '=', 'plans.id')
        ->select('customers.*','plans.name as plan','plans.price as price')->get();
         $latest = \App\Suminvoice::latest('id')->first();
     // dd ($latest);
             if (!$latest)
              {
                $latest_number=1;
                }
                else
                {
                 $latest_number = $latest->number;
                }
   

     
$month = now()->format('mY');
 foreach($active_customer as $customer) 
   
{
    $latest_number = $latest_number+1;

    $check_invoice = \App\invoice::where('id_customer', ($customer['id']))->Where('periode', $month)->Where('monthly_fee','1')->first();

        if (!$check_invoice)
        {

            // $invoice = $invoice +1;
 $tempcode=(sha1(time())).rand();
 // $latest = \App\Suminvoice::latest('id')->first();
      
 //             if (! $latest->number) {
 //                $latest_number=1;
 //                }
 //                else
 //                {
 //                 $latest_number = $latest->number+1;
 //                }



    \App\invoice::create([
            'id_customer' => ($customer['id']),
            'monthly_fee' => '1',
            'periode' => $month, 
            'description' => 'Montly fee package '. ($customer['plan']),
            'qty' => '1',
            'amount' => ($customer['price']),
            'payment_status' => 3,
            'tax' => '0',
            'tempcode' => $tempcode,
            'created_by' => 'System',

            

                      
        ]);

    if(empty($customer['tax']))
    {
        $tax=0;
    }
        else
        {
            $tax=$customer['tax'];
        }
$total_amount =$customer['price'] + ($customer['price'] * $tax / 100);

     \App\Suminvoice::create([
            'id_customer' => ($customer['id']),
            'number' => $latest_number,
            'date' => date("Y-m-d"), 
            'payment_status' => 0,
            'tax' => $tax,
            'tempcode' => $tempcode,
            'total_amount' => $total_amount,
              
             ]);

            

                \Log::channel('invoice')->info('INVOICE CREATED to '.$customer["name"].' with amount = '.$customer["price"].'' );      
        
}

}
     
        \Log::channel('invoice')->info('==== END INVOICE CREATE BY SYSTEM ===');
       // $this->info('Demo:Cron Cummand Run successfully!');
        //
    


});

ini_set('memory_limit','256M');
$date = date('Y-m-d');
$path = base_path()."/storage/logs/invoice-".$date.".log"; //get the apache.log file in root
$logs = \File::get($path);


 return view ('invoice/report', ['logs' => $logs ]);

}


    
        }
