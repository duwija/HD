<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;



class JurnalController extends Controller
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
    public function index()
    {
        //
      $from=date('Y-m-1');
      $to=date('y-m-d');
      // $jurnal = \App\jurnal::orderBy('id','ASC')
      // ->Where('type','jumum')
      // ->orWhere('type','general')
      // ->get();
      $akuntransaction = \App\akuntransaction::pluck('name', 'id', 'debet');

        //$accounting = \App\accounting::orderBy('id','ASC')->get();
       //$acccategory = \App\Accountingcategorie::pluck('name', 'id');
      $nsaldo = \App\jurnal::groupBy('id_akun')->select('id_akun', \DB::raw('sum(debet) as debet'), \DB::raw('sum(kredit) as kredit') )
      ->Where('type','jumum')
      ->orWhere('type','closed')
      ->get();

      $nrugilaba = \App\jurnal::join('akuns', 'akuns.id', '=', 'jurnals.id_akun')
      ->where(function($query)
    {
$query->Where('akuns.group','pendapatan');
 $query->orWhere('akuns.group','beban');
     })
      ->where(function($query)
     {
       
       $query->Where('jurnals.type','jumum');
       $query->orWhere('jurnals.type','closed');
     })
        
       //->groupBy('jurnals.id_akun')->select('jurnals.id_akun', 'akuns.name', \DB::raw('sum(jurnals.debet) as debet'), \DB::raw('sum(jurnals.kredit) as kredit') )
       ->get();
        //  dd($nrugilaba);
       $neraca = \App\jurnal::join('akuns', 'akuns.id', '=', 'jurnals.id_akun')
        ->where(function($query)
     {
 $query->Where('akuns.group','aktiva');
       $query->orWhere('akuns.group','utang');
       $query->orWhere('akuns.group','modal');
     })
     ->where(function($query)
     {
 $query->Where('jurnals.type','jumum');
       $query->orWhere('jurnals.type','closed');
     })
       
       
       ->groupBy('jurnals.id_akun')->select('jurnals.id_akun', 'akuns.name', \DB::raw('sum(jurnals.debet) as debet'), \DB::raw('sum(jurnals.kredit) as kredit') )
       ->get();
 
 
       // return view ('jurnal/index',['jurnal' =>$jurnal,'akuntransaction' =>$akuntransaction, 'nsaldo' =>$nsaldo, 'nrugilaba' => $nrugilaba, 'neraca' => $neraca]);
 
         return view ('jurnal/index',['akuntransaction' =>$akuntransaction, 'nsaldo' =>$nsaldo, 'nrugilaba' => $nrugilaba, 'neraca' => $neraca]);
     }
 
     /**
      * Show the form for creating a new resource.
      *
      * @return \Illuminate\Http\Response
      */
      public function jurnal(Request $request)
      {
 
     //dd ($request);
     if (($request->date_from == null) or ($request->date_end == null))
       {
       $from=date('Y-m-1');
       $to=date('y-m-d');
      // dd($from);
     }
     else
     {
       $from=$request->date_from;
       $to=$request->date_end;
     }
     $date_msg = " Show Data From ".$from." to ".$to;
 
 
     $jurnal = \App\jurnal::orderBy('id','ASC')
     ->where(function($query) use($from, $to)
     {
       $query->whereBetween('date', [$from, $to]);
        })
     ->where(function($query)  use($from, $to)
     {
       $query->Where('type','jumum');
       $query->orWhere('type','closed');
     })
     ->get();
 $akun = \App\akun::pluck('name', 'id');
 $akuntransaction = \App\akuntransaction::pluck('name', 'id', 'debet');
 return view ('jurnal/jumum',['jurnal' =>$jurnal,'akuntransaction' =>$akuntransaction,'akun'=>$akun, 'date_msg'=>$date_msg]);
 }
      public function bukubesar(Request $request)
      {
 
     //dd ($request);
     if (($request->date_from == null) or ($request->date_end == null))
       {
       $from=date('Y-m-1');
       $to=date('y-m-d');
      $akun=1;
     }
     else
     {
       $from=$request->date_from;
       $to=$request->date_end;
       $akun=$request->akun;
     }
 
    
    $date_from= date('Y-m-d', strtotime('-1 day', strtotime($from)));
  // dte_to= date("Y-m-t", strtotime('-1 month', strtotime( $to )));
 //dd($date_to);
     $date_msg = " Show Data From ".$from." to ".$to;
 
 $jsaldo = \App\jurnal::groupBy('id_akun')->select('id_akun', \DB::raw('sum(debet) as debet'), \DB::raw('sum(kredit) as kredit') )
       ->where(function($query) use($akun)
     {
       $query->where('id_akun', $akun);
        })
     ->where(function($query) use($from, $to, $date_from)
     {
       $query->where('date','<=', $date_from );
        })
     ->where(function($query)  use($from, $to)
     {
       $query->Where('type','jumum');
       $query->orWhere('type','closed');
     })
     ->first();
  
 //dd($jsaldo);
     $jurnal = \App\jurnal::orderBy('id','ASC')
         ->where(function($query) use($akun)
     {
       $query->where('id_akun', $akun);
        })
     ->where(function($query) use($from, $to)
     {
       $query->whereBetween('date', [$from, $to]);
        })
     ->where(function($query)  use($from, $to)
     {
       $query->Where('type','jumum');
      $query->orWhere('type','closed');
    })
    ->get();
$akun = \App\akun::pluck('name', 'id');

$akuntransaction = \App\akuntransaction::pluck('name', 'id', 'debet');
return view ('jurnal/bukubesar',['jurnal' =>$jurnal,'jsaldo' =>$jsaldo,'akuntransaction' =>$akuntransaction,'akun'=>$akun, 'date_msg'=>$date_msg,'date_from'=> $request->date_from,'date_to'=> $to]);
}



public function jpenutup()
{

      $pendapatan = \App\jurnal::join('akuns', 'akuns.id', '=', 'jurnals.id_akun')
       ->where(function($query)
    {
$query->Where('akuns.group','pendapatan');
      // $query->orWhere('akuns.group','utang');
      // $query->orWhere('akuns.group','modal');
    })
    ->where(function($query)
    {
$query->Where('jurnals.type','jumum');
       $query->orWhere('jurnals.type','closed');
    })
      
      
      ->groupBy('jurnals.id_akun')->select('jurnals.id_akun', 'akuns.name', \DB::raw('sum(jurnals.debet) as debet'), \DB::raw('sum(jurnals.kredit) as kredit') )
      ->get();



       $beban = \App\jurnal::join('akuns', 'akuns.id', '=', 'jurnals.id_akun')
       ->where(function($query)
    {
$query->Where('akuns.group','beban');
      // $query->orWhere('akuns.group','utang');
      // $query->orWhere('akuns.group','modal');
    })
    ->where(function($query)
    {
$query->Where('jurnals.type','jumum');
       $query->orWhere('jurnals.type','closed');
    })
      
      
      ->groupBy('jurnals.id_akun')->select('jurnals.id_akun', 'akuns.name', \DB::raw('sum(jurnals.debet) as debet'), \DB::raw('sum(jurnals.kredit) as kredit') )
      ->get();




  $nrugilaba = \App\jurnal::join('akuns', 'akuns.id', '=', 'jurnals.id_akun')
      ->where(function($query)
    {
$query->Where('akuns.group','pendapatan');
 $query->orWhere('akuns.group','beban');
    })
->where(function($query)
    {
      
      $query->Where('jurnals.type','jumum');
      $query->orWhere('jurnals.type','closed');
    })
       
           ->groupBy('jurnals.debet')->select('jurnals.id_akun', 'akuns.name', \DB::raw('sum(jurnals.debet) as debet'), \DB::raw('sum(jurnals.kredit) as kredit') )
      ->get();

//dd($nrugilaba);

 $deviden = \App\jurnal::join('akuns', 'akuns.id', '=', 'jurnals.id_akun')
      ->where(function($query)
    {
$query->Where('akuns.name','deviden');
// $query->orWhere('akuns.group','beban');
    })
->where(function($query)
    {
      
      $query->Where('jurnals.type','jumum');
      $query->orWhere('jurnals.type','closed');
    })
       
           ->groupBy('jurnals.debet')->select('jurnals.id_akun', 'akuns.name', \DB::raw('sum(jurnals.debet) as debet'), \DB::raw('sum(jurnals.kredit) as kredit') )
      ->get();



$akun = \App\akun::pluck('name', 'id');
$akuntransaction = \App\akuntransaction::pluck('name', 'id', 'debet');
return view ('jurnal/jpenutup',['pendapatan' =>$pendapatan,'beban' =>$beban, 'akuntransaction' =>$akuntransaction,'akun'=>$akun, 'nrugilaba'=>$nrugilaba, 'deviden'=>$deviden ]);



}
public function penutup(Request $request)
{
 


       DB::beginTransaction();
   try {

  $id=0;
 foreach ($request->akun_id as $akun) {



 \App\jurnal::create([
    'date' => (date('Y-m-d h:i:sa')),
    'id_akun' => ($akun),
    'debet' => ($request->akun_debet[$id]), 
    'kredit' =>  ($request->akun_kredit[$id]),
    'reff' => uniqid(),
    'type' => ('closed'),
    'description' => ('Jurnal Penutup'),
  ]);


$id=$id+1;

}
 DB::commit();
      return redirect ('/jurnal/jpenutup')->with('success','Item created successfully!');

    } catch (Exception $e) {
       // Rollback Transaction
       DB::rollback();
       return redirect ('/jurnal/jpenutup')->with('error','Process Failed!');

       // ada yang error
     }



}

    public function create(Request $request)
    {
        //
      $utang ="";
      $akuntransaction = \App\akuntransaction::pluck('name', 'id');
      $transactionname = \App\akuntransaction::Where('id',$request->akuntransaction)->first();

      if ($transactionname->name == "pemasukkan"){


        $akunkredit = \App\akun::Where('type','pendapatan')->get();
        $akundebet = \App\akun::Where('type','aktiva lancar')
        ->orWhere('type','aktiva tetap')
           // ->orWhere('type','aktiva lancar')
        ->get();
        
   return view ('jurnal/create',['utang' => $utang, 'akundebet' => $akundebet,'akunkredit' => $akunkredit, 'akuntransaction' =>$akuntransaction,'transactionname' =>$transactionname]);
      }
      elseif ($transactionname->name == "pengeluaran"){

       $akundebet = \App\akun::Where('type','biaya admin dan umum')
       ->orWhere('type','aktiva lancar')
       ->orWhere('type','aktiva tetap')
       ->orWhere('type', 'utang jangka panjang')
       ->orWhere('type', 'utang jangka pendek')
       ->get();
       $akunkredit = \App\akun::Where('type','aktiva lancar')->get();

   return view ('jurnal/create',['utang' => $utang, 'akundebet' => $akundebet,'akunkredit' => $akunkredit, 'akuntransaction' =>$akuntransaction,'transactionname' =>$transactionname]);

     }
     elseif ($transactionname->name == "utang"){

       $akundebet = \App\akun::Where('type','biaya admin dan umum')
       ->orWhere('type','aktiva lancar')
       ->orWhere('type','aktiva tetap')
       ->get();
       $akunkredit = \App\akun::Where('type','utang jangka pendek')
       ->orWhere('type','utang jangka panjang')
       ->get();

   return view ('jurnal/create',['utang' => $utang, 'akundebet' => $akundebet,'akunkredit' => $akunkredit, 'akuntransaction' =>$akuntransaction,'transactionname' =>$transactionname]);

     }

     elseif ($transactionname->name == "piutang"){

       $akundebet = \App\akun::Where('type','aktiva lancar')
           // ->orWhere('type','aktiva lancar')
           // ->orWhere('type','aktiva tetap')
       ->get();
       $akunkredit = \App\akun::Where('type','pendapatan')
       ->orWhere('type','modal')
       ->orWhere('type','aktiva lancar')
       ->get();

   return view ('jurnal/create',['utang' => $utang, 'akundebet' => $akundebet,'akunkredit' => $akunkredit, 'akuntransaction' =>$akuntransaction,'transactionname' =>$transactionname]);

     }
     elseif ($transactionname->name == "bayar utang"){

      $akunutang = \App\akun::Where('group','utang')->first();
             // $utang = \App\jurnal::join('akuns', 'akuns.id', '=', 'jurnals.id_akun')
             // ->Where('akuns.group','utang')
             // ->select('jurnals.*')

      $utang = \App\jurnal::join('akuns', 'akuns.id', '=', 'jurnals.id_akun')
      ->Where('akuns.group','utang')
      ->select('jurnals.id_akun', 'jurnals.reff', 'jurnals.description', \DB::raw('sum(jurnals.debet) as debet'), \DB::raw('sum(jurnals.kredit) as kredit'))
      ->groupBy('jurnals.reff')


           //  SELECT  id_akun,description, sum(debet) as debet, sum(kredit) as kredit FROM `jurnals` where id_akun=18 group by reff

              // ->orWhere('type','utang jangka panjang')
      ->get();
             //dd($utang);
      $akundebet = \App\akun::Where('type','utang jangka pendek')
      ->orWhere('type','utang jangka panjang')
      ->get();
      $akunkredit = \App\akun::Where('type','biaya admin dan umum')
      ->orWhere('type','aktiva lancar')
      ->orWhere('type','aktiva tetap')
      ->get();

   return view ('jurnal/create',['utang' => $utang, 'akundebet' => $akundebet,'akunkredit' => $akunkredit, 'akuntransaction' =>$akuntransaction,'transactionname' =>$transactionname]);
    }
    elseif ($transactionname->name == "dibayar piutang"){

      $akunutang = \App\akun::Where('name','piutang usaha')->first();
             // $utang = \App\jurnal::join('akuns', 'akuns.id', '=', 'jurnals.id_akun')
             // ->Where('akuns.group','utang')
             // ->select('jurnals.*')

      $utang = \App\jurnal::join('akuns', 'akuns.id', '=', 'jurnals.id_akun')
      ->Where('akuns.name','piutang usaha')
      ->select('jurnals.id_akun', 'jurnals.reff', 'jurnals.description', \DB::raw('sum(jurnals.debet) as debet'), \DB::raw('sum(jurnals.kredit) as kredit'))
      ->groupBy('jurnals.reff')


           //  SELECT  id_akun,description, sum(debet) as debet, sum(kredit) as kredit FROM `jurnals` where id_akun=18 group by reff

              // ->orWhere('type','utang jangka panjang')
      ->get();
             //dd($utang);
      $akunkredit = \App\akun::Where('name','piutang usaha')
              // ->orWhere('type','utang jangka panjang')
      ->get();
      $akundebet = \App\akun::Where('type','biaya admin dan umum')
      ->orWhere('type','aktiva lancar')
      ->orWhere('type','aktiva tetap')
      ->orWhere('type','pendapatan')
      ->get();

   return view ('jurnal/create',['utang' => $utang, 'akundebet' => $akundebet,'akunkredit' => $akunkredit, 'akuntransaction' =>$akuntransaction,'transactionname' =>$transactionname]);
    }
    elseif ($transactionname->name == "tambah modal"){

     $akundebet = \App\akun::Where('type','aktiva lancar')
           // ->orWhere('type','aktiva lancar')
     ->orWhere('type','aktiva tetap')
     ->get();
     $akunkredit = \App\akun::Where('type','modal')->get();

   return view ('jurnal/create',['utang' => $utang, 'akundebet' => $akundebet,'akunkredit' => $akunkredit, 'akuntransaction' =>$akuntransaction,'transactionname' =>$transactionname]);

   }
   elseif ($transactionname->name == "tarik modal"){

     $akunkredit = \App\akun::Where('type','aktiva lancar')
           // ->orWhere('type','aktiva lancar')
     ->orWhere('type','aktiva tetap')
     ->get();
     $akundebet = \App\akun::Where('type','modal')->get();

   return view ('jurnal/create',['utang' => $utang, 'akundebet' => $akundebet,'akunkredit' => $akunkredit, 'akuntransaction' =>$akuntransaction,'transactionname' =>$transactionname]);
   }
   else {

          //$transactionname = \App\akuntransaction::Where('id',$request->akuntransaction)->first();
     $jurnal =\App\jurnal::Where('type','general')->get();
         //dd($cjurnal);
     $akun = \App\akun::all();
     return view ('jurnal/general',['jurnal' => $jurnal,'akun' => $akun, 'akuntransaction' =>$akuntransaction]);

   }
 }
 

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
  public function trxcreate()
    {
$akuntransaction = \App\akuntransaction::pluck('name', 'id');
    $jurnal =\App\jurnal::Where('type','general')->get();
         //dd($cjurnal);
     $akun = \App\akun::all();
     return view ('jurnal/general',['jurnal' => $jurnal,'akun' => $akun, 'akuntransaction' =>$akuntransaction]);
   
   }
    public function closed()
    {
    $akuntransaction = \App\akuntransaction::pluck('name', 'id');
    $jurnal =\App\jurnal::Where('type','preclosed')->get();
         
     $akun = \App\akun::all();
     return view ('jurnal/closed',['jurnal' => $jurnal,'akun' => $akun, 'akuntransaction' =>$akuntransaction]);


   
   }


   public function closestore(Request $request)
   {
       // dd ($request);
      //   dd ($request);
 // $type="jcustom";
  $request ->validate([

    'date' => 'required',
    'akun' => 'required|numeric',
    'debetkredit' => 'required',
    'amount' => 'required|numeric',
    'description' => 'required',

  ]);
  if(!empty($request['reff']))
  {
    $reff = $request['reff'];
  }
  else
  {
   $reff = uniqid();
 }

 if($request['debetkredit']=='d')
 {

  \App\jurnal::create([
    'date' => ($request['date']),
    'id_akun' => ($request['akun']),
    'debet' => ($request['amount']), 
    'reff' => $reff,
    'type' => ($request['type']),
    'description' => ($request['description']),
  ]);
}
else
{
 \App\jurnal::create([
  'date' => ($request['date']),
  'id_akun' => ($request['akun']),
  'kredit' => ($request['amount']), 
  'reff' => $reff,
  'type' => ($request['type']),
  'description' => ($request['description']),
]);

}


return redirect ('/jurnal/closed')->with('success','Item created successfully!');


        //
 }




public function closeupdate(Request $request)
    {
      $id = $request->jurnalid;
      $reff = uniqid();


       DB::beginTransaction();
   try {

      foreach ($id as $id) 
      {

        \App\jurnal::where('id', $id)->update([
          'type' => 'closed',

          'reff' => $reff,
        ]);

      }
      DB::commit();
      return redirect ('/jurnal')->with('success','Item created successfully!');

    } catch (Exception $e) {
       // Rollback Transaction
       DB::rollback();
       return redirect ('/jurnal')->with('error','Process Failed!');

       // ada yang error
     }



      
    }


    public function ccreate()
    {

     $akuntransaction = \App\akuntransaction::pluck('name', 'id');
         //$transactionname = \App\akuntransaction::Where('id',$request->akuntransaction)->first();
     $cjurnal =\App\jurnal::Where('type','jcustom')->get();
         //dd($cjurnal);
     $akun = \App\akun::all();
     return view ('jurnal/custom',['cjurnal' => $cjurnal,'akun' => $akun, 'akuntransaction' =>$akuntransaction]);
   
   }





   public function store(Request $request)
   {
       // dd ($request);
    $type="jumum";
    $request ->validate([

      'date' => 'required',
      'debet' => 'required|numeric',
      'kredit' => 'required|numeric',
      'amount' => 'required|numeric',
      'description' => 'required',

    ]);
    if(!empty($request['reff']))
    {
      $reff = $request['reff'];
    }
    else
    {
     $reff = uniqid();
   }

   \App\jurnal::create([
    'date' => ($request['date']),
    'id_akun' => ($request['debet']),
    'debet' => ($request['amount']), 
    'reff' => $reff,
    'type' => $type,
    'description' => ($request['description']),
  ]);
   \App\jurnal::create([
    'date' => ($request['date']),
    'id_akun' => ($request['kredit']),
    'kredit' => ($request['amount']), 
    'reff' => $reff,
    'type' => $type,
    'description' => ($request['description']),
  ]);

   $jurnal = \App\jurnal::orderBy('date','ASC')->get();
   $akuntransaction = \App\akuntransaction::pluck('name', 'id', 'debet');

   return redirect ('/jurnal')->with('success','Item created successfully!');


        //
 }

 public function trxstore(Request $request)
 {
    //   dd ($request);
 // $type="jcustom";
  $request ->validate([

    'date' => 'required',
    'akun' => 'required|numeric',
    'debetkredit' => 'required',
    'amount' => 'required|numeric',
    'description' => 'required',

  ]);
  if(!empty($request['reff']))
  {
    $reff = $request['reff'];
  }
  else
  {
   $reff = uniqid();
 }

 if($request['debetkredit']=='d')
 {

  \App\jurnal::create([
    'date' => ($request['date']),
    'id_akun' => ($request['akun']),
    'debet' => ($request['amount']), 
    'reff' => $reff,
    'type' => ($request['type']),
    'description' => ($request['description']),
  ]);
}
else
{
 \App\jurnal::create([
  'date' => ($request['date']),
  'id_akun' => ($request['akun']),
  'kredit' => ($request['amount']), 
  'reff' => $reff,
  'type' => ($request['type']),
  'description' => ($request['description']),
]);

}


return redirect ('/jurnal/trxcreate')->with('success','Item created successfully!');


        //
}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
public function trxupdate(Request $request)
    {
      $id = $request->jurnalid;
      $reff = uniqid();


       DB::beginTransaction();
   try {

      foreach ($id as $id) 
      {

        \App\jurnal::where('id', $id)->update([
          'type' => 'jumum',

          'reff' => $reff,
        ]);

      }
      DB::commit();
      return redirect ('/jurnal')->with('success','Item created successfully!');

    } catch (Exception $e) {
       // Rollback Transaction
       DB::rollback();
       return redirect ('/jurnal')->with('error','Process Failed!');

       // ada yang error
     }



      
    }
    public function generaldel($id)
    {
      try{
        \App\jurnal::destroy($id);
        return redirect ('/jurnal/trxcreate')->with('success','Item deleted successfully!');
      }catch (Exception $e) {
      
         return redirect ('/jurnal/trxcreate')->with('error','Process Failed!');
      }
    }
    public function cupdate(Request $request)
    {
      $id = $request->jcustomid;
      $reff = uniqid();

      foreach ($id as $id) 
      {

        \App\jurnal::where('id', $id)->update([
          'type' => 'jumum',

          'reff' => $reff,
        ]);

      }

    }
    public function show($id)
    {
        //
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
    public function destroy($id)
    {
        //
    try{
        \App\jurnal::destroy($id);
        return redirect ('/jurnal')->with('success','Item deleted successfully!');
      }catch (Exception $e) {
      
         return redirect ('/jurnal')->with('error','Process Failed!');
      }
    }

    public function post(Request $request){
      $response = array(
        'status' => 'success',
        'msg' => $request->message,
      );

      return response()->json($response); 
    }
  }
