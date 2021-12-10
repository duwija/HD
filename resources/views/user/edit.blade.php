@extends('layout.main')
@section('title',' Employe')
@section('content')
<section class="content-header">

  <div class="card card-primary card-outline">
              <div class="card-header">
                <h3 class="card-title font-weight-bold"> Edit Employe Data </h3>
              </div>
              <form role="form" action="{{url ('user')}}/{{ $user->id }}" method="POST" enctype="multipart/form-data">
                @method('patch')
                @csrf
          <div class="card-body">
        <div class="row">
          <div class="form-group col-sm-3" >
            <label for="nama">Name</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror " name="name" id="name"  placeholder="Employe Name" value="{{$user->name}}">
            @error('name')
            <div class="error invalid-feedback">{{ $message }}</div>
            @enderror
          </div>



  <div class="form-group col-sm-3" >
            <label for="nama">full Name</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror " name="full_name" id="full_name"  placeholder="Employe Full Name" value="{{$user->full_name}}">
            @error('name')
            <div class="error invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="form-group col-sm-3">
            <label for="date_of_birth">Date of Birth</label>
            <input type="date" class="form-control @error('date_of_birth') is-invalid @enderror " name="date_of_birth" id="date_of_birth" value="{{$user->date_of_birth}}">
            @error('date_of_birth')
            <div class="error invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>
        <div class="row">
     
     <div class="form-group col-sm-3">
       <label for="email"> Email  </label>
       <input type="text" disabled="" class="form-control @error('email') is-invalid @enderror" name="email"  id="email" placeholder="email" value="{{$user->email}}">
       @error('email')
       <div class="error invalid-feedback">{{ $message }}</div>
       @enderror
     </div>
     <div class="form-group col-sm-3">
     <label for="password"> Password </label>
     <input type="password" class="form-control @error('password') is-invalid @enderror" name="password"  id="password" placeholder="password" value="{{$user->password}}">
     @error('password')
     <div class="error invalid-feedback">{{ $message }}</div>
     @enderror
   </div>
         <div class="form-group col-sm-3">
           <label for="job_title"> Job Title </label>
            <select name="job_title" id="job_title" class="form-control">
@php
              $job_title = array("Network Engineer", "NOC", "Inventory", "Accounting", "Marketing", "HRD", "GA", "Management");

@endphp

@foreach ($job_title as $value) {
@if ($value == $user->job_title )
{
 <option value="{{$value}}" selected="">{{$value}}</option>
}
@else
{

 <option value="{{$value}}">{{$value}}</option>
}
@endif
}
@endforeach
            
             {{-- <option value="NOC">NOC</option>
              <option value="Inventoryr">Inventory</option>
             <option value="Accounting">Accounting</option>
              <option value="Marketing">Marketing</option>
               <option value="HRD">HRD</option>
                <option value="GA">GA</option>
                <option value="Management">Management</option> --}}
           
          </select>
         </div>

   </div>
        <div class="row">

      
      </div>
      <div class="row">
        <div class="form-group col-sm-3">
         <label for="join_date"> Join Date </label>
         <input type="date" class="form-control @error('join_date') is-invalid @enderror" name="join_date"  id="join_date" value="{{$user->join_date}}">
         @error('join_date')
         <div class="error invalid-feedback">{{ $message }}</div>
         @enderror
       </div>
       <div class="form-group col-sm-3">
         <label for="address"> Address </label>
         <input type="text" class="form-control @error('address') is-invalid @enderror" name="address"  id="address" placeholder="address" value="{{$user->address}}">
         @error('address')
         <div class="error invalid-feedback">{{ $message }}</div>
         @enderror
       </div>


       <div class="form-group col-sm-3">
          <label for="employe_type"> Employee Type </label>
          @php

           $employee_type=array ("Full Time", "Part Time", " Fixed-Term Contract","Probation");
           @endphp
            <select name="employee_type" id="employee_type" class="form-control">
        @foreach ($employee_type as $value) {
@if ($value == $user->employee_type )
{
 <option value="{{$value}}" selected="">{{$value}}</option>
}
@else
{

 <option value="{{$value}}">{{$value}}</option>
}
@endif
}
@endforeach
</select>
        </div>
     </div>
    
   <div class="row">

     <div class="form-group col-sm-3">
       <label for="phone"> Phone </label>
       <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone"  id="phone" placeholder="phone" value="{{$user->phone}}">
       @error('phone')
       <div class="error invalid-feedback">{{ $message }}</div>
       @enderror
     </div>
   <div class="form-group col-sm-6">
    <label for="description">Note  </label>
    <input type="text" class="form-control @error('description') is-invalid @enderror" name="description" id="description" placeholder="Note " value="{{$user->description}}">
    @error('description')
    <div class="error invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
</div>
<div class="form-group">
  <label>Photo</label></br>
  <img class="m-3" style="width: 128px; height: 128px" 
                       src="../../storage/users/{{$user->photo}}"
                       alt="User profile picture" onerror="this.onerror=null;this.src='../../storage/users/default_profile.png';" />
  <input type="file" class="form-control-file" name="photo" id="photo">
</div>










<div class="form-group">
  <input type="hidden" name="updated_at" value="{{now()}}" >
</div>



</div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Update</button>
                </form>
                  <a href="{{url('user')}}" class="btn btn-secondary  float-right">Cancel</a>
                </div>
              
            </div>
            <!-- /.card -->

            <!-- Form Element sizes -->
   

          </div>
          
          </section>

@endsection