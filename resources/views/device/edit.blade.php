@extends('layout.main')
@section('title',' Edit Plan')
@section('content')
<section class="content-header">

  <div class="card card-primary card-outline">
              <div class="card-header">
                <h3 class="card-title font-weight-bold"> Edit Plan </h3>
              </div>
              <form role="form" action="{{url ('plan')}}/{{ $plan->id }}" method="POST">
                @method('patch')
                @csrf
                <div class="card-body">
                  <div class="form-group">
                    <label for="nama">Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror " name="name" id="nama"  placeholder="Enter Plan Name" value="{{ $plan->name }}">
                  </div>
                  <div class="form-group">
                    <label for="speed">Speed  </label>
                    <input type="text" class="form-control @error('speed') is-invalid @enderror" name="speed" id="speed"  placeholder="Plan Speed" value="{{ $plan->speed }}">
                  </div>
                  <div class="form-group">
                    <label for="price">Price  </label>
                    <input type="text" class="form-control @error('price') is-invalid @enderror" name="price" id="price" placeholder="Plan Price" value="{{ $plan->price }}">
                  </div>
                  <div class="form-group">
                    <label for="description">Description  </label>
                    <input type="text" class="form-control @error('description') is-invalid @enderror" name="description" id="description" placeholder="Plan Descrition" value="{{ $plan->description }}">
                  </div>
                  
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Edit</button>
                </form>
                  <a href="{{url('plan')}}" class="btn btn-secondary  float-right">Cancel</a>
                </div>
              
            </div>
            <!-- /.card -->

            <!-- Form Element sizes -->
   

          </div>
          </section>

@endsection