@extends('layout.main')
@section('title',' Site')
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
                <h3 class="card-title font-weight-bold"> Edit Site </h3>
              </div>
              <form role="form" action="{{url ('site')}}/{{ $site->id }}" method="POST">
                @method('patch')
                @csrf
                <div class="card-body">
                  <div class="form-group">
                    <label for="nama">Name</label>
                    <input type="text" disabled="" class="form-control @error('name') is-invalid @enderror " name="name" id="name"  placeholder="Enter site Name" value="{{ $site->name }}">
                     @error('name')
                      <div class="error invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="location">Location  </label>
                    <input type="text" class="form-control @error('location') is-invalid @enderror" name="location" id="location"  placeholder="Site Location" value="{{ $site->location }}">
                     @error('location')
                      <div class="error invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>

                  <div class="form-group">
                    <label for="coordinate"> Coordinate </label>
                  <div class="input-group mb-3">
                    
                    <input type="text" class="form-control @error('coordinate') is-invalid @enderror" name="coordinate"  id="coordinate" placeholder="Coordinate" value="{{ $site->coordinate }}">
                    @error('coordinate')
                      <div class="error invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="input-group-append">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-maps-edit">Get From Maps </button>
                   </div>
                   </div>
                </div>
                  
                  <div class="form-group">
                    <label for="description">Description  </label>
                    <input type="text" class="form-control @error('description') is-invalid @enderror" name="description" id="description" placeholder="site Descrition" value="{{ $site->description }}">
                     @error('description')
                      <div class="error invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                  
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Update</button>
                </form>
                  <a href="{{url('site')}}" class="btn btn-secondary  float-right">Cancel</a>
                </div>
              
            </div>
            <!-- /.card -->

            <!-- Form Element sizes -->
   

          </div>
          <div class="modal fade" id="modal-maps-edit">
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
          </section>

@endsection