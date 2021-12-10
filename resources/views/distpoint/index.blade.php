@extends('layout.main')
@section('title','Distribution Point List')
@section('content')
<section class="content-header">

  <div class="card card-primary card-outline">
    <div class="card-header">
      <h3 class="card-title">Distibution Point List  </h3>
      <a href="{{url ('distpoint/create')}}" class=" float-right btn  bg-gradient-primary btn-sm">Add New Distribution Point</a>
    </div>

    <!-- /.card-header -->
    <div class="card-body">
      <table id="example1" class="table table-bordered table-striped">

        <thead >
          <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Site</th>
            <th scope="col">IP</th>
            <th scope="col">Parrent</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>
         @foreach( $distpoint as $distpoint)
         <tr>
          <th scope="row">{{ $loop->iteration }}</th>
          <td>{{ $distpoint->name }}</td>
          @if( $distpoint->id_site == null)


          <td> none</td>


          @else
          <td>{{ $distpoint->site_name->name }}</td>

          @endif
          <td>{{ $distpoint->ip }}</td>
          @if( $distpoint->parrent == null)


          <td> none</td>


          @else

          <td>{{ $distpoint->distpoint_name->name }}</td>

          @endif
          <td >
            <div class="float-right " >
              <a href="https://www.google.com/maps/place/{{ $distpoint->coordinate }}" target="_blank" class="btn btn-info btn-sm "><i title="show map" class="fa fa-map"> </i> </a>

              <a href="/distpoint/{{ $distpoint->id }}" title="detail" class="btn btn-primary btn-sm "> <i class="fa fa-list-ul"> </i> </a>
              <a href="/distpoint/{{ $distpoint->id }}/edit" title="edit" class="btn btn-primary btn-sm "> <i class="fa fa-edit"> </i> </a>


              <form  action="/distpoint/{{ $distpoint->id }}" method="POST" class="d-inline distpoint-delete" >
                @method('delete')
                @csrf

                <button title="Delete" type="submit"  class="btn btn-danger btn-sm"> <i class="fa fa-times"> </i> </button>
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
