@extends('layout.main')
@section('title','Add New Bank')
@section('content')
<section class="content-header">

  <div class="card card-primary card-outline">
              <div class="card-header">
                <h3 class="card-title font-weight-bold"> Add New Bank </h3>
              </div>
              <form role="form" method="post" action="/bank">
                @csrf
                <div class="card-body">
                  <div class="form-group">
                    <label for="nama">Number</label>
                    <input type="text" class="form-control @error('number') is-invalid @enderror " name="number" id="number"  placeholder="Enter Bank account number" value="{{old('number')}}">
                    @error('number')
                      <div class="error invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="name">Account Name  </label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"  id="name" placeholder="Enter Account Name name" value="{{old('name')}}">
                    @error('name')
                      <div class="error invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                  
                  <div class="form-group">
                    <label for="description">Description  </label>
                    <input type="text" class="form-control @error('description') is-invalid @enderror" name="description" id="description" placeholder="Bank Descrition" value="{{old('description')}}">
                    @error('description')
                      <div class="error invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                  
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                  <a href="{{url('bank')}}" class="btn btn-default float-right">Cancel</a>
                </div>
              </form>
            </div>
            <!-- /.card -->

            <!-- Form Element sizes -->
   

          </div>
          </section>

@endsection