<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TicketdetailController extends Controller
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

         
        //

         $request ->validate([
            'id_ticket' =>'required',
            'description' => 'required',
            'updated_by' => 'required'
        ]);

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

        \App\Ticketdetail::create([
             'id_ticket' => ($request['id_ticket']),
            'description' => $description,
            'updated_by' => ($request['updated_by']),
             ]);


        // \App\Ticketdetail::create($request->all());
        $url ='ticket/'.$request->id_ticket;

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
