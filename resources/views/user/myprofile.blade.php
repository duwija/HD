@extends('layout.main')
@section('title',' My Profile')
@section('content')
<section class="content-header">

  <div class="card card-primary card-outline">
              <div class="card-header">
                <h3 class="card-title font-weight-bold"> My Profile </h3>
              </div>

              <div class="card-body box-profile bg-light">
                <div class="text-center">
                  <img style="width: 128px; height: 128px" class="profile-user-img img-fluid img-circle"
                       src="/storage/users/{{$user->photo}}"
                       alt="User profile picture" onerror="this.onerror=null;this.src='storage/users/default_profile.png';" />
                </div>

                <h3 class="profile-username text-center">{{$user->name}}</h3>
                <p class="text-muted text-center">~ {{$user->privilege}} ~</p>

                <p class="text-muted text-center">{{$user->job_title}}</p>
<div class="row">
                <ul class="list-group list-group-unbordered col-md-6 p-md-2">
                   <li class="list-group-item p-2">
                    <b>Full Name</b> <a class="float-right">{{$user->full_name}}</a>
                  </li>
                  <li class="list-group-item p-2">
                    <b>E mail</b> <a class="float-right">{{$user->email}}</a>
                  </li>
                  <li class="list-group-item p-2 ">
                    <b>Employee Type</b> <a class="float-right">{{$user->employee_type}}</a>
                  </li>
                  <li class="list-group-item p-2 ">
                    <b>Join Date</b> <a class="float-right">{{$user->join_date}}7</a>
                  </li>
                </ul>
                <ul class="list-group list-group-unbordered col-md-6 p-md-2">
                   <li class="list-group-item p-2">
                    <b>Date of birth</b> <a class="float-right">{{$user->date_of_birth}}</a>
                  </li>
                  <li class="list-group-item p-2 ">
                    <b>Address</b> <a class="float-right">{{$user->address}}</a>
                  </li>
                  <li class="list-group-item p-2 ">
                    <b>Phone</b> <a class="float-right">{{$user->phone}}</a>
                  </li>
                  <li class="list-group-item p-2 ">
                    <b>note</b> <a class="float-right">{{$user->description}}</a>
                  </li>
                </ul>

</div>

                 <div class="card-footer">
               {{--    <a href="/user/{{$user->id}}/edit">  <button type="button" class="btn btn-primary float-left "> Edit </button></a> --}}
              {{-- <button type="button" class="btn btn-primary float-right " data-dismiss="modal">Close</button> --}}
              
           {{--  </div> --}}
          </div>
         
           
        
          <!-- /.modal-content -->
        
        <!-- /.modal-dialog -->
      
    </div>
                </div>
              
            </div>
            <!-- /.card -->

            <!-- Form Element sizes -->
   

          </div>
          
          </section>

@endsection