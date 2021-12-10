@extends('layout.main')
@section('title','Employee List')
@section('content')
<section class="content-header">

  <div class="card card-primary card-outline">
              <div class="card-header">
                <h3 class="card-title">Employe LIst  </h3>
                <a href="{{url ('user/create')}}" class=" float-right btn  bg-gradient-primary btn-sm">Add New Employee</a>
              </div>
              
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">

  <thead >
    <tr>
      <th scope="col">#</th>
      <th scope="col">Name</th>
      <th scope="col">Email</th>
      <th scope="col">Job Title</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
  	@foreach( $user as $user)
    <tr>
      <th scope="row">{{ $loop->iteration }}</th>
      <td>{{ $user->name }}</td>
      <td>{{ $user->email }}</td>
      <td>{{ $user->job_title }}</td>
      <td >
        <div class="float-right " >
           <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-user-detail{{ $user->id }}">Detail </button>
          
        <a href="/user/{{ $user->id }}/edit" class="btn btn-primary btn-sm "> <i class="fa fa-edit"> </i> </a>

        
        <form  action="/user/{{ $user->id }}" method="POST" class="d-inline user-delete" >
                    @method('delete')
                    @csrf
                    
                      <button type="submit"  class="btn btn-danger btn-sm"> <i class="fa fa-times"> </i> </button>
                  </form>
        
      </div>
      </td>

    </tr>


<div class="modal fade" id="modal-user-detail{{ $user->id }}">
        <div class="modal-dialog modal-lg ">
          <div class="modal-content">
            <div class="card card-primary card-outline">
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
                    <b>Join Date</b> <a class="float-right">{{$user->join_date}}</a>
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
                    <b>note</b> <a class="float-right">{{$user->date_of_birth}}</a>
                  </li>
                </ul>

                <ul class="list-group list-group-unbordered col-md-12 pr-md-2 pl-md-2">
                  <li class="list-group-item p-2 ">
                    <b>note</b> <a class="float-right">{{$user->description}}</a>
                  </li>
                </ul>
</div>

                 <div class="modal-footer justify-content-between float-right">
              <button type="button" class="btn btn-primary float-right " data-dismiss="modal">Close</button>
              
           {{--  </div> --}}
          </div>
              </div>
              <!-- /.card-body -->
            </div>
              <!-- /.card-body -->
            </div>
           
           
        
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      
    </div>

    @endforeach
    
  </tbody>
</table>
</div>
</div>

</section>

@endsection
