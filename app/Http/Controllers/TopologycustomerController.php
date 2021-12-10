<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Topologycustomer;

class topologycustomerController extends Controller
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
//dd($request);
        $request ->validate([
            'id_customer' => 'required',
            'name' => 'required',
            'parrent' => 'required',
            'owner' => 'required',
            'type' => 'required',
        ]);


       \App\Topologycustomer::create($request->all());
        
         $url ='device/'.$request->id_customer;


        return redirect ($url)->with('success','Item created successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Topologycustomers  $topologycustomers
     * @return \Illuminate\Http\Response
     */
    public function show(Topologycustomers $topologycustomers)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Topologycustomers  $topologycustomers
     * @return \Illuminate\Http\Response
     */
    public function edit(Topologycustomers $topologycustomers)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Topologycustomers  $topologycustomers
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Topologycustomers $topologycustomers)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Topologycustomers  $topologycustomers
     * @return \Illuminate\Http\Response
     */
    public function destroy(Topologycustomers $topologycustomers)
    {
        //
    }
}
