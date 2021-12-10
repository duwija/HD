@extends('layout.main')
@section('title','Plan List')
@section('content')
<section class="content-header">

  <div class="card card-primary card-outline">
              <div class="card-header">
                <h3 class="card-title">Plan List  </h3>
                <a href="{{url ('plan/create')}}" class=" float-right btn  bg-gradient-primary btn-sm">Add New Plan</a>
              </div>
              
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">

  <thead >
    <tr>
      <th scope="col">#</th>
      <th scope="col">Name</th>
      <th scope="col">Speed</th>
      <th scope="col">Price</th>
      <th scope="col">Description</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
  	@foreach( $plan as $plan)
    <tr>
      <th scope="row">{{ $loop->iteration }}</th>
      <td>{{ $plan->name }}</td>
      <td>{{ $plan->speed }}</td>
      <td>{{ $plan->price }}</td>
      <td>{{ $plan->description }}</td>
      <td >
        <div class="" >
        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-detail{{ $plan->id }}">Detail </button>
        <a href="/plan/{{ $plan->id }}/edit" class="btn btn-primary btn-sm "> Edit </a>
        <form  action="/plan/{{ $plan->id }}" method="POST" class="d-inline plan-delete" >
                    @method('delete')
                    @csrf
                    
                      <button type="submit"  class="btn btn-danger btn-sm"> Delete </button>
                  </form>
        
      </div>
      </td>

       <div class="modal fade" id="modal-detail{{ $plan->id }}">
        <div class="modal-dialog modal-lg ">
          <div class="modal-content">
            <div class="modal-header">
             <h5 class="modal-title">Plan Detail</h5> 
              
              
            </div>
            <div class="modal-body card card-primary card-outline m-2">

             
              <div class="container px-5 ">
  <div class="card-body">
                  <div class="form-group">
                    <label for="nama">Name</label>
                    <input type="text" disabled="" class="form-control"  value="{{ $plan->name }}">
                  </div>
                  <div class="form-group">
                    <label for="speed">Speed  </label>
                    <input type="text" disabled="" class="form-control" value="{{ $plan->speed }}">
                  </div>
                  <div class="form-group">
                    <label for="price">Price  </label>" 
                     <input type="text" disabled="" class="form-control"  value="{{ $plan->price }}">
                  </div>
                  <div class="form-group">
                    <label for="description">Description  </label>
                    <input type="text" class="form-control" disabled="" value="{{ $plan->description }}">
                  </div>
                  
                </div>
</div> 

              </div>
  
                  

           
            <div class="modal-footer justify-content-between float-right">
              <button type="button" class="btn btn-primary float-right " data-dismiss="modal">Close</button>
              
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->



    </tr>




    @endforeach
    
  </tbody>
</table>
</div>
</div>



         


</section>

@endsection
