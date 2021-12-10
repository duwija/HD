<?php

namespace App\Http\Controllers;
use \Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
class UserController extends Controller
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

        $user = \App\user::all();

        return view ('user/index',['user' =>$user]);
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
    public function create()
    {
        //
         if ((Auth::user()->privilege)=="admin")
       {     

        return view ('user/create');
         }
    else
    {
      return redirect()->back()->with('error','Sorry, You Are Not Allowed to Access Destination page !!');
  }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


       $request ->validate([
        'name' => 'required',
        'date_of_birth' => 'required',
        'full_name' => 'required',
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'password' => 'required',
        'job_title' => 'required',
        'employee_type' => 'required',
        'join_date' => 'required',
        'address' => 'required',
        'phone' => 'required',
          //  'photo' => ['mimes:jpg, png, jpeg, gif'],
    ]);


       if (($request['photo'])==null) 
       {

           \App\User::create([
            'name' => ($request['name']),
            'full_name' => ($request['full_name']),
            'date_of_birth' => ($request['date_of_birth']),
            'email' => ($request['email']), 
            'password' => Hash::make($request['password']),
            'job_title' => ($request['job_title']),
            'employee_type' => ($request['employee_type']),
            'join_date' => ($request['join_date']),
            'address' => ($request['address']),
            'phone' => ($request['phone']),
//             'photo' => $imageName,
        ]);
       }
       else
       {

           $imageName = time().'.'.$request->photo->getClientOriginalExtension();

           $request->photo->move(public_path('storage/users'), $imageName);



           \App\User::create([
            'name' => ($request['name']),
            'full_name' => ($request['full_name']),
            'date_of_birth' => ($request['date_of_birth']),
            'email' => ($request['email']), 
            'password' => Hash::make($request['password']),
            'job_title' => ($request['job_title']),
            'employee_type' => ($request['employee_type']),
            'join_date' => ($request['join_date']),
            'address' => ($request['address']),
            'phone' => ($request['phone']),
            'photo' => $imageName,


        ]);

       }





        // $photoName = $request->photo->extension();  





       return redirect ('/user')->with('success','Item created successfully!');
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
         if ((Auth::user()->privilege)=="admin")
       {     
        return view ('user.edit',['user' => \App\User::findOrFail($id)]);
        }
    else
    {
      return redirect()->back()->with('error','Sorry, You Are Not Allowed to Access Destination page !!');
  }
    }
    public function myprofile($id)
    {
     
     if ($id == Auth::user()->id)
     {
        return view ('user/myprofile',['user' => \App\User::findOrFail($id)]);
    }
    else
    {
        abort(404, 'You dont have permision to view this page');
    }
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
        'full_name' => 'required',
        'date_of_birth' => 'required',
            // 'email' => ['required', 'email', 'max:255'],
        'password' => 'required',
        'job_title' => 'required',
        'employee_type' => 'required',
        'join_date' => 'required',
        'address' => 'required',
        'phone' => 'required',

          //  'photo' => ['mimes:jpg, png, jpeg, gif'],
    ]);


       if (strlen($request['password']) >= 50){
        $password = $request['password'];
    }
    else
    {
        $password = Hash::make($request['password']);
    }

    if (($request['photo'])==null) 
    {


      \App\User::where('id', $id)
      ->update([
        'name' => ($request['name']),
        'full_name' => ($request['full_name']),
        'date_of_birth' => ($request['date_of_birth']),
            // 'email' => ($request['email']), 
        'password' => $password,
        'job_title' => ($request['job_title']),
        'employee_type' => ($request['employee_type']),
        'join_date' => ($request['join_date']),
        'address' => ($request['address']),
        'phone' => ($request['phone']),
            //'photo' => $imageName,


    ]);
  }
  else
  {

   $imageName = time().'.'.$request->photo->getClientOriginalExtension();
   
   $request->photo->move(public_path('storage/users'), $imageName);





   \App\User::where('id', $id)
   ->update([
    'name' => ($request['name']),
    'full_name' => ($request['full_name']),
    'date_of_birth' => ($request['date_of_birth']),
            // 'email' => ($request['email']), 
    'password' => $password,
    'job_title' => ($request['job_title']),
    'employee_type' => ($request['employee_type']),
    'join_date' => ($request['join_date']),
    'address' => ($request['address']),
    'phone' => ($request['phone']),
    'photo' => $imageName,


]);

}


return redirect ('/user')->with('success','Item created successfully!');
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
