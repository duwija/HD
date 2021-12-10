<?php

namespace App\Http\Controllers;
//use GeneaLabs\LaravelMaps\Map;

use Illuminate\Http\Request;

class SiteController extends Controller
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
        //

        // $site = \App\Site::all();
         $site = \App\Site::WhereNotIn('id',[0])->get();
        
        return view ('site/index',['site' =>$site]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    { 
        //return view ('site/create');
        //
$config['center'] = env('COORDINATE_CENTER');
$config['zoom'] = '13';
//$this->googlemaps->initialize($config);

$marker = array();
$marker['position'] = env('COORDINATE_CENTER');
$marker['draggable'] = true;
$marker['ondragend'] = 'updateDatabase(event.latLng.lat(), event.latLng.lng());';

    app('map')->initialize($config);
        
        app('map')->add_marker($marker);
        $map = app('map')->create_map();

        // echo "<html><head><script type=text/javascript>var centreGot = false;</script>".$map['js']."</head><body>".$map['html']."</body></html>";

        return view ('site/create',['map' => $map] );

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
            'name' => 'required|unique:sites',
            'location' => 'required',
            'coordinate' => 'required',
            'create_at' => 'required',
            // 'description' => 'required'
        ]);


        \App\Site::create($request->all());

        return redirect ('/site')->with('success','Item created successfully!');
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
$config['center'] = env('COORDINATE_CENTER');
$config['zoom'] = '13';
//$this->googlemaps->initialize($config);

$marker = array();
$marker['position'] = env('COORDINATE_CENTER');
$marker['draggable'] = true;
$marker['ondragend'] = 'updateDatabase(event.latLng.lat(), event.latLng.lng());';

    app('map')->initialize($config);
        
        app('map')->add_marker($marker);
        $map = app('map')->create_map();

    return view ('site.edit',['site' => \App\Site::findOrFail($id)],['map' => $map] );
    
    
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
        //dd($request);

        $request ->validate([
            // 'name' => 'required|unique:sites',
            'location' => 'required',
            'coordinate' => 'required',
            // 'description' => 'required'
        ]);

        \App\Site::where('id', $id)
            ->update([
                // 'name' => $request->name,
                'location' => $request->location,
                'coordinate' => $request->coordinate,
                'description' => $request->description


            ]);
        return redirect ('/site')->with('success','Item updated successfully!');
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

        \App\Site::destroy($id);
         return redirect ('/site')->with('success','Item deleted successfully!');
    }
    public function maps()
    {
        


$config['center'] = env('COORDINATE_CENTER');
$config['zoom'] = '13';
//$this->googlemaps->initialize($config);

$marker = array();
$marker['position'] = env('COORDINATE_CENTER');
$marker['draggable'] = true;
$marker['ondragend'] = 'alert(\'You just dropped me at: \' + event.latLng.lat() + \', \' + event.latLng.lng());';

    app('map')->initialize($config);
        
        app('map')->add_marker($marker);
        $map = app('map')->create_map();

        // echo "<html><head><script type=text/javascript>var centreGot = false;</script>".$map['js']."</head><body>".$map['html']."</body></html>";

        return view ('site/view_file',['map' => $map] );
    }
}
