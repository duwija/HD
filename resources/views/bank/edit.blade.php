@extends('layout.main')
@section('title',' Edit bank')
@section('content')
<section class="content-header">

  <div class="card card-primary card-outline">
              <div class="card-header">
                <h3 class="card-title font-weight-bold"> Edit bank </h3>
              </div>
              <form role="form" action="{{url ('bank')}}/{{ $bank->id }}" method="POST">
                @method('patch')
                @csrf
                <div class="card-body">
               
                  <div class="form-group">
                    <label for="number">number  </label>
                    <input type="text" class="form-control @error('number') is-invalid @enderror" name="number" id="number"  placeholder="bank number" value="{{ $bank->number }}">
                  </div>
                  <div class="form-group">
                    <label for="name">name  </label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" placeholder="bank name" value="{{ $bank->name }}">
                  </div>
                  <div class="form-group">
                    <label for="description">Description  </label>
                    <input type="text" class="form-control @error('description') is-invalid @enderror" name="description" id="description" placeholder="bank Descrition" value="{{ $bank->description }}">
                  </div>
                  
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Edit</button>
                </form>
                  <a href="{{url('bank')}}" class="btn btn-secondary  float-right">Cancel</a>
                </div>
              
            </div>
            <!-- /.card -->

            <!-- Form Element sizes -->
   

          </div>
          </section>

@endsection