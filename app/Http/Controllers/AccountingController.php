<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AccountingController extends Controller
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

         $accounting = \App\accounting::orderBy('id','ASC')->get();
         $acccategory = \App\Accountingcategorie::pluck('name', 'id');
         $sum = \App\accounting::groupBy('id_category')->select('id_category', \DB::raw('sum(income) as income'), \DB::raw('sum(expense) as expense') )->get();
        // dd ($sum);
    
        return view ('accounting/index',['accounting' =>$accounting, 'acccategory' => $acccategory,'ladger' =>$sum]);
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
       // dd($request);
          $request ->validate([
            'date' => 'required|date',
            'type' => 'required',
            'category' => 'required',
            'amount' => 'required|numeric'
        ]);
          //$type =array['income','expanse']
          if($request->type == 'income')
          {
            $result = \App\accounting::create([
            'date' => $request->date,
            'id_category' =>$request->category,
            'income' => $request->amount, 
           
            'note' => $request->name,
            'created_by' => \Auth::user()->name,
            
             ]);

          }
          elseif($request->type == 'expense')
          {
            $result = \App\accounting::create([
            'date' => $request->date,
            'id_category' =>$request->category,
             
            'expense' => $request->amount, 
            'note' => $request->name,
            'created_by' => \Auth::user()->name,
            
             ]);

          }
           elseif($request->type == 'account_payable')
          {
            $result = \App\accounting::create([
            'date' => $request->date,
            'id_category' =>$request->category,
             
            'account_payable' => $request->amount, 
            'note' => $request->name,
            'created_by' => \Auth::user()->name,
            
             ]);

          }
           elseif($request->type == 'account_recievable')
          {
            $result = \App\accounting::create([
            'date' => $request->date,
            'id_category' =>$request->category,
             
            'account_recievable' => $request->amount, 
            'note' => $request->name,
            'created_by' => \Auth::user()->name,
            
             ]);

          }



        

          if ($result)
          {
             return redirect ('/accounting')->with('success','Item created successfully!');
          }
          else
          {
            return redirect ('/accounting')->with('warning','Item created field!');
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
    }
}
