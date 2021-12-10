<?php

namespace App\Http\Controllers;
use \App\Distpoint;

use Illuminate\Http\Request;

class DistpointController extends Controller
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
        // $distpoint = \App\Distpoint::all();
         $distpoint = \App\Distpoint::WhereNotIn('id',[0])->get();

        
        return view ('distpoint/index',['distpoint' =>$distpoint]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $site = \App\Site::pluck('name', 'id');
        $distpoint = \App\Distpoint::pluck('name', 'id');
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

        
        return view ('distpoint/create',['map' => $map, 'site' => $site, 'distpoint' => $distpoint ] );


    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //protected $fillable =['name','id_site', 'ip', 'security','parrent','coordinate','created_at','description'];
        $request ->validate([
            'name' => 'required|unique:distpoints',
            'id_site' => 'required',
            'parrent' => 'required',
            'id_site' => 'required',
            'coordinate' => 'required',
            // 'create_at' => 'required',
            // 'description' => 'required'
        ]);


        \App\Distpoint::create($request->all());

        return redirect ('/distpoint')->with('success','Item created successfully!');
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
         
        $site = \App\Site::findOrFail(\App\Distpoint::findOrFail($id) ->id_site);
        $distpoint_name = \App\Distpoint::findOrFail(\App\Distpoint::findOrFail($id) ->parrent);
           $distpoint_chart =\App\Distpoint::where('parrent', $id)->get();
       // $distpoint_name = \App\Distpoint::pluck('name', 'id');
        //
        if  (\App\Distpoint::findOrFail($id) ->coordinate == null)
        {
            $coordinate =env('COORDINATE_CENTER');
        }
        else
        {
            $coordinate =\App\Distpoint::findOrFail($id) ->coordinate;
        }


        $config['center'] = $coordinate;
        $config['zoom'] = '13';
//$this->googlemaps->initialize($config);

        $marker = array();
        $marker['position'] = $coordinate;
        //$marker['draggable'] = true;
        //$marker['ondragend'] = 'updateDatabase(event.latLng.lat(), event.latLng.lng());';

        app('map')->initialize($config);
        
        app('map')->add_marker($marker);
        $map = app('map')->create_map();
       //dd( $distpoint_chart);

        return view ('distpoint.show',['distpoint' => \App\Distpoint::findOrFail($id),'site' => $site,'map' => $map, 'distpoint_name' => $distpoint_name , 'distpoint_chart' => $distpoint_chart]);
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       

        $site = \App\Site::pluck('name', 'id');
        $distpoint_name = \App\Distpoint::pluck('name', 'id');
        $distpoint = \App\Distpoint::findOrFail($id);

         
         if ($distpoint->coordinate == null)
         {
            $coordinate = env('COORDINATE_CENTER');
        }
        else
        {
            $coordinate = $distpoint->coordinate;
        }
        //

$config['center'] = $coordinate;
$config['zoom'] = '13';
//$this->googlemaps->initialize($config);

$marker = array();
$marker['position'] = $coordinate;
$marker['draggable'] = true;
$marker['ondragend'] = 'updateDatabase(event.latLng.lat(), event.latLng.lng());';

    app('map')->initialize($config);
        
        app('map')->add_marker($marker);
        $map = app('map')->create_map();

    return view ('distpoint.edit',['distpoint' => $distpoint,'site' => $site,'map' => $map, 'distpoint_name' => $distpoint_name] );
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
            'id_site' => 'required',
            'parrent' => 'required',
            'coordinate' => 'required',
            // 'description' => 'required'
        ]);


          \App\Distpoint::where('id', $id)->update([
                'name' => $request->name,
                'id_site' => $request->id_site,
                'parrent' => $request->parrent,
                'ip' => $request->ip,
                'security' => $request->security,
                'coordinate' => $request->coordinate,
                'description' => $request->description



            ]);
        return redirect ('/distpoint')->with('success','Item updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //      <div class="form-group">
      \App\Distpoint::destroy($id);
        return redirect ('distpoint')->with('success','Item deleted successfully!');
    }  

    
}
