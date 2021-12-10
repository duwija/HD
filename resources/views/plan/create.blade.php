@extends('layout.main')
@section('title','Add New Plan')
@section('content')
<section class="content-header">

  <div class="card card-primary card-outline">
              <div class="card-header">
                <h3 class="card-title font-weight-bold"> Add New Plan </h3>
              </div>
              <form role="form" method="post" action="/plan">
                @csrf
                <div class="card-body">
                  <div class="form-group">
                    <label for="nama">Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror " name="name" id="name"  placeholder="Enter Plan Name" value="{{old('name')}}">
                    @error('name')
                      <div class="error invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="speed">Speed  </label>
                    <input type="text" class="form-control @error('speed') is-invalid @enderror" name="speed"  id="speed" placeholder="Plan Speed" value="{{old('speed')}}">
                    @error('speed')
                      <div class="error invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="price">Price  </label>
                    <input type="text" class="form-control @error('price') is-invalid @enderror" name="price"  id="price" placeholder="Plan Price" value="{{old('price')}}">
                    @error('price')
                      <div class="error invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="description">Description  </label>
                    <input type="text" class="form-control @error('description') is-invalid @enderror" name="description" id="description" placeholder="Plan Descrition ex: 100000" value="{{old('description')}}">
                    @error('description')
                      <div class="error invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                  
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                  <a href="{{url('plan')}}" class="btn btn-default float-right">Cancel</a>
                </div>
              </form>
            </div>
            <!-- /.card -->

            <!-- Form Element sizes -->
   

          </div>
          </section>

@endsection