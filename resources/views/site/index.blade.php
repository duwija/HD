@extends('layout.main')
@section('title','site List')
@section('content')
<section class="content-header">

  <div class="card card-primary card-outline">
              <div class="card-header">
                <h3 class="card-title">Site List  </h3>
                <a href="{{url ('site/create')}}" class=" float-right btn  bg-gradient-primary btn-sm">Add New Site</a>
              </div>
              
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">

  <thead >
    <tr>
      <th scope="col">#</th>
      <th scope="col">Name</th>
      <th scope="col">Location</th>
      <th scope="col">Description</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
  	@foreach( $site as $site)
    <tr>
      <th scope="row">{{ $loop->iteration }}</th>
      <td>{{ $site->name }}</td>
      <td>{{ $site->location }}</td>
      <td>{{ $site->description }}</td>
      <td >
        <div class="float-right " >
          <a href="https://www.google.com/maps/place/{{ $site->coordinate }}" target="_blank" class="btn btn-primary btn-sm "> <i title="show map" class="fa fa-map"> </i> </a>
        <a href="/site/{{ $site->id }}/edit" class="btn btn-primary btn-sm "> <i class="fa fa-edit"> </i> </a>

        
        <form  action="/site/{{ $site->id }}" method="POST" class="d-inline site-delete" >
                    @method('delete')
                    @csrf
                    
                      <button type="submit"  class="btn btn-danger btn-sm"> <i class="fa fa-times"> </i> </button>
                  </form>
        
      </div>
      </td>

    </tr>
    @endforeach
    
  </tbody>
</table>
</div>
</div>

</section>

@endsection
