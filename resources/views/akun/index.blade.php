@extends('layout.main')
@section('title','site List')
@section('content')
<section class="content-header">

  <div class="card card-primary card-outline">
              <div class="card-header">
                <h3 class="card-title">Site List  </h3>
             <button type="button" class="float-right btn bg-primary btn-sm" data-toggle="modal" data-target="#modal-akun"> Add New Akun </button>
              </div>
              
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">

  <thead >
    <tr>
      <th scope="col">#</th>
      <th scope="col">Name</th>
      <th scope="col">group</th>
      
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
  	@foreach( $akun as $akun)
    <tr>
      <th scope="row">{{ $loop->iteration }}</th>
      <td>{{ $akun->name }}</td>
      <td>{{ $akun->group }}</td>
      
      <td >
        <div class="float-right " >
        
        <a href="/akun/{{ $akun->id }}/edit" class="btn btn-primary btn-sm "> <i class="fa fa-edit"> </i> </a>

        
        <form  action="/akun/{{ $akun->id }}" method="POST" class="d-inline site-delete" >
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


  <div class="modal fade" id="modal-akun">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <!-- <div class="modal-header">
             <h5 class="modal-title">drap Marker to Right Posision</h5> 
              
              
            </div>-->
            <div class="modal-body">

               <form role="form" method="post" action="/akun">
                @csrf
                <div class="card-body">
                  <div class="form-group">
                    <label for="nama">Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror " name="name" id="name"  placeholder="Akun Name" value="{{old('name')}}">
                    @error('name')
                      <div class="error invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                           <div class="form-group">
           <label for="location"> Type </label>

        {{--    @php
           $group = array(['Aktiva Lancar','Aktiva tetap']);
           echo $group;
           @endphp --}}
                   <select name="group" id="group" class="form-control">
         
           {{--  @foreach ($group as $group)
            <option value="{{ $groups }}"></option>
            @endforeach --}}
          </select>
                  <div class="form-group">
                    <label for="coordinate"> Coordinate </label>
             
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

              
              </form>
             
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
