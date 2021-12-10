@extends('layout.main')
@section('title','Add New Site')
@section('maps')

@endsection

@section('content')
<section class="content-header">

  <div class="card card-primary card-outline">
              <div class="card-header">
                <h3 class="card-title font-weight-bold"> Add New Site </h3>
              </div>
              <form role="form" method="post" action="/site">
                @csrf
                <div class="card-body">
                  <div class="form-group">
                    <label for="nama">Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror " name="name" id="name"  placeholder="Enter Site Name" value="{{old('name')}}">
                    @error('name')
                      <div class="error invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                           <div class="form-group">
           <label for="location"> Location </label>
                    <input type="text" class="form-control @error('location') is-invalid @enderror" name="location"  id="location" placeholder="Location" value="{{old('location')}}">
                    @error('location')
                      <div class="error invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="form-group">
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
                
                  <div class="form-group">
                    <label for="description">Description  </label>
                    <input type="text" class="form-control @error('description') is-invalid @enderror" name="description" id="description" placeholder="Site Descrition " value="{{old('description')}}">
                    @error('description')
                      <div class="error invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                  
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                  <a href="{{url('site')}}" class="btn btn-default float-right">Cancel</a>
                </div>
              </form>
            </div>
            <!-- /.card -->

            <!-- Form Element sizes -->
   

          </div>
          <div class="modal fade" id="modal-maps">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <!-- <div class="modal-header">
             <h5 class="modal-title">drap Marker to Right Posision</h5> 
              
              
            </div>-->
            <div class="modal-body">
             
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