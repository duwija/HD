<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DeviceController extends Controller
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
    public function index($id)
    {
        //
          $device = \App\device::Where('id_customer',$id)->get();
            $cutomerdevice = \App\customer::Where('id',$id)->first();
             $devicelist = \App\device::Where('id_customer',$id)->pluck('name','id');

        //$customer =DB::table('customers')->get();
        //dump($plan);
        return view ('device/index',['device' =>$device, 'customerdevice' =>$cutomerdevice,'devicelist' =>$devicelist]);
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
           $request ->validate([
            'id_customer' => 'required',
            'name' => 'required',
            // 'parrent' => 'required',
            'owner' => 'required',
            'type' => 'required',
        ]);

//dd ($request);
       \App\device::create($request->all());
        
         $url ='device/'.$request->id_customer;


        return redirect ($url)->with('success','Item created successfully!');
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
    public function update(Request $request, $id)
    {
              $request ->validate([
          
            'name' => 'required',
            // 'parrent' => 'required',
            'owner' => 'required',
            'type' => 'required',
        ]);


          \App\Device::where('id', $id)->update([
                'name' => $request->name,
                'parrent' => $request->parrent,
                'ip' => $request->ip,
                'type' => $request->type,
                'sn' => $request->sn,
                'owner' => $request->owner,
                'position' => $request->position,
                 'note' => $request->note,



            ]);
          $url ='device/'.$request->id_customer;


         return redirect ($url)->with('success','Item updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($cust,$id)
    {
        //
        \App\device::destroy($id);
         return redirect ('/device/'.$cust)->with('success','Item deleted successfully!');
    }

    public function null()
    {
         return abort(404);
    }
}
