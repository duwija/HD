@extends('layout.main')
@section('title',' Distribution Point')
@section('maps')
{!! $map['js'] !!}
@endsection
<script type="text/javascript">

 
</script>
@section('content')
<section class="content-header">

  <div class="card card-primary card-outline">
    <div class="card-header">
      <h3 class="card-title font-weight-bold"> Show Detail Distribution Point </h3>
    </div>
    
      <div class="card-body">
         <div class="row">
        <div class="form-group col-md-6">
          <label for="nama">Name</label>
           <br><a class="p-md-2">{{$distpoint->name}}</a>
          </div>
        <div class="form-group col-md-6">
          <label for="location">Location  </label>
          <br><a class="p-md-2">{{$site->name}}</a>
        </div>
    </div>

     <div class="row">
      <div class="form-group col-md-6">
        <label for="ip">IP Address</label>
        <br><a class="p-md-2">{{$distpoint->ip}}</a>
        
</div>
      <div class="form-group col-md-6">
        <label for="security">Security</label>
        <br><a class="p-md-2">{{$distpoint->security}}</a>
       
      </div>
    </div>
 <div class="row">
      <div class="form-group col-md-6">
       <label for="parrent"> Parrent </label>
       <br><a class="p-md-2">{{$distpoint_name->name}}</a>
       
    </div>
    <div class="form-group col-md-6">
      <label for="coordinate"> Update At</label>
      <br><a class="p-md-2">{{$distpoint->updated_at}}</a>
    </div>
  </div>

    <div class="form-group">
      <label for="description">Description  </label>
      <br><a class="p-md-2">{{$distpoint->description}}</a>
      
      
    </div>
    <div class="form-group">
      <label for="maps">Maps   </label>
      
      @if ($distpoint->coordinate == null)
      
        <br><a class="p-md-2">No Map set !!</a> 
      
      @else
      <div>
            {!! $map['html'] !!}
          </div>
          <div class="float-right " >
              <a href="https://www.google.com/maps/place/{{ $distpoint->coordinate }}" target="_blank" class="btn btn-info btn-sm "><i  class="fa fa-map"> </i> Show in Google Maps </a>
            </div>
      @endif
     
    </div>

  </div>
  <!-- /.card-body -->

  
</div>
<!-- /.card -->

<!-- Form Element sizes -->


</div>

  </section>

  @endsection