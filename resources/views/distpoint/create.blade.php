@extends('layout.main')
@section('title','Add New Distribution Point')
@section('maps')
{!! $map['js'] !!}
@endsection
<script type="text/javascript">

  function updateDatabase(newLat, newLng)
  {
    document.getElementById("coordinate").value = newLat+','+newLng;

  }
</script>
@section('content')
<section class="content-header">

  <div class="card card-primary card-outline">
    <div class="card-header">
      <h3 class="card-title font-weight-bold"> Add New Distribution Point </h3>
    </div>
    <form role="form" method="post" action="/distpoint">
      @csrf
      <div class="card-body row">
        <div class="form-group col-md-3">
          <label for="nama">Name</label>
          <input type="text" class="form-control @error('name') is-invalid @enderror " name="name" id="name"  placeholder="Enter Distribution Point Name" value="{{old('name')}}">
          @error('name')
          <div class="error invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
        <div class="form-group col-md-3">
          <label for="site location">  Location </label>
         <div class="input-group mb-3">
          <select name="id_site" id="id_site" class="form-control">
            {{-- <option value="1">none</option> --}}
            @foreach ($site as $id => $name)
            <option value="{{ $id }}">{{ $name }}</option>
            @endforeach
          </select>
        </div>

      </div>
      <div class="form-group col-md-3">
        <label for="ip">IP Address</label>
        <input type="text" class="form-control" name="ip" id="ip"  placeholder="Enter IP Address" value="{{old('ip')}}">

      </div>
      <div class="form-group col-md-3">
        <label for="security">Security</label>
        <input type="text" class="form-control" name="security" id="security"  placeholder="Enter Security Key" value="{{old('security')}}">
      </div>

      <div class="form-group col-md-3">
       <label for="parrent"> Parrent </label>
       <div class="input-group mb-3">
        <select name="parrent" id="parrent" class="form-control">
          {{-- <option value="1">none</option> --}}
          @foreach ($distpoint  as $id => $name)
          <option value="{{ $id }}">{{ $name }}</option>
          @endforeach
        </select>
      </div>
    </div>
    <div class="form-group col-md-3">
      <label for="coordinate"> Coordinate </label>
      <div class="input-group mb-3">

        <input type="text" class="form-control @error('coordinate') is-invalid @enderror" name="coordinate"  id="coordinate" placeholder="Coordinate" value="{{old('coordinate')}}">
        @error('coordinate')
        <div class="error invalid-feedback">{{ $message }}</div>
        @enderror
        <div class="input-group-append">
         <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-maps">Get From Maps </button>
       </div>
     </div>
   </div>
   <div class="form-group">
    <input type="hidden" name="create_at" value="{{now()}}" >
  </div>

  <div class="form-group col-md-5">
    <label for="description">Description  </label>
    <input type="text" class="form-control @error('description') is-invalid @enderror" name="description" id="description" placeholder="Site Descrition " value="{{old('description')}}">
    @error('description')
    <div class="error invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
   <div class="form-group col-md-1">
       <label for="monitoring"> Monitoring </label>
       <div class="input-group mb-3">
        <select name="monitoring" id="monitoring" class="form-control">
          
          <option value="0">No</option>
          <option value="1">Yes</option>
          
        </select>
      </div>
    </div>

</div>
<!-- /.card-body -->

<div class="card-footer">
  <button type="submit" class="btn btn-primary">Submit</button>
  <a href="{{url('distpoint')}}" class="btn btn-default float-right">Cancel</a>
</div>
</form>
</div>
<!-- /.card -->

<!-- Form Element sizes -->



<div class="modal fade" id="modal-maps">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
            <!-- <div class="modal-header">
             <h5 class="modal-title">drap Marker to Right Posision</h5> 
              
              
           </div>-->
           <div class="modal-body">
            {!! $map['html'] !!}
          </div>
          <div class="modal-footer justify-content-between float-right">
            <button type="button" class="btn btn-primary float-right " data-dismiss="modal">Apply</button>

          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
  </section>

  @endsection