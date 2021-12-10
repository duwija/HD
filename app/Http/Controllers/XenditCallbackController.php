<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class XenditCallbackController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    public function update(Request $request)
    {
        //
      // $data=response()->json($request);
      $id_xendit= $request->id;
        if ($request->status == 'PAID')
        // {
        //     //return $id_xendit."/".$request->paid_amount."". $request->bank_code."/".$request->payment_method."/".$request->merchant_name;
        // }
        // else
        // {
        //     return "blm terbayar";
        // }
       {

        try{

             \App\Suminvoice::where('payment_id', $id_xendit)
            ->update([
                'recieve_payment' => $request->paid_amount,
                'payment_point' => $request->bank_code,
                'note' => $request->payment_method,
                'updated_by' => $request->merchant_name,
                  'payment_status' =>1,
                   'payment_date' =>now()->toDateTimeString(),


            ]);
        }
        catch (Exception $e)
        {
            return $e;
        }
        
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
        //
    }
}
