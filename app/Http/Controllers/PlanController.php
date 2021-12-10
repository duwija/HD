<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PlanController extends Controller
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

    public function null()
    {
        return abort(404);
    }
    public function index()
    {
        $plan = \App\Plan::all();
        //$customer =DB::table('customers')->get();
        //dump($plan);
        return view ('plan/index',['plan' =>$plan]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         return view ('plan/create');
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
       // \App\Plan::create([
         //   'name' => $request->name,
           // 'speed' => $request->speed,
            //'price' => $request->price,
            //'description' => $request->description,
        //]);

        $request ->validate([
            'name' => 'required',
            'speed' => 'required',
            'price' => 'required|integer',
            'description' => 'required'
        ]);


        \App\Plan::create($request->all());

        return redirect ('/plan')->with('success','Item created successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show ($id)
    {
        //

          return view ('plan.edit',['plan' => \App\Plan::findOrFail($id)]);
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
        return view ('plan.edit',['plan' => \App\Plan::findOrFail($id)]);
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

        $request ->validate([
            'name' => 'required',
            'speed' => 'required',
            'price' => 'required|integer',
            'description' => 'required'
        ]);

        \App\Plan::where('id', $id)
            ->update([
                'name' => $request->name,
                'speed' => $request->speed,
                'price' => $request->price,
                'description' => $request->description


            ]);
        return redirect ('/plan')->with('success','Item updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        \App\Plan::destroy($id);
         return redirect ('/plan')->with('success','Item deleted successfully!');
    }
}
