@extends('layout.main')
@section('title','Customer Device List')
@section('content')
<section class="content-header">

  <div class="card card-primary card-outline">
              <div class="card-header">
                <h3 class="card-title"> <b> {{ $customerdevice->id}} ({{ $customerdevice->name}}) </b>  Device List  </h3>
                 <button type="button" class="float-right btn btn-sm bg-gradient-primary" data-toggle="modal" data-target="#modal-add-device">Add New Client Device</button>
                <a href="/customer/{{$customerdevice->id}}" class=" float-right btn btn-sm  bg-gradient-secondary btn-sm mr-3"> Back</a>
              </div>
              
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">

  <thead >
    <tr>
      <th scope="col">#</th>
      <th scope="col">Name</th>
      <th scope="col">Parrent</th>
      <th scope="col">Ip</th>
      <th scope="col">Type</th>
      <th scope="col">SN</th>
      <th scope="col">owner</th>
      <th scope="col">Position</th>
      <th scope="col">Note</th>

      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
  	@foreach( $device as $device)
    <tr>
      <th scope="row">{{ $loop->iteration }}</th>
      <td>{{ $device->name }}</td>

       @if( $device->parrent == null)


          <td> - </td>


          @elseif($device->parrent_name['name'] == null)
           <td class="text-danger"> Invalid Parrent</td>

          @else

      <td>{{ $device->parrent_name['name']}}</td>
      @endif
      <td>{{ $device->ip }}</td>
      <td>{{ $device->type }}</td>
      <td>{{ $device->sn }}
      <td>{{ $device->owner }}</td>
      <td>{{ $device->position }}</td>

      <td>{{ $device->note }}</td>
   {{--    <td>{{ $plan->price }}</td>
      <td>{{ $plan->description }}</td> --}}
      <td >
        <div class="" >
        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-detail{{ $device->id }}">Edit </button>
       
        <form  action="/device/{{ $device->id_customer }}/{{ $device->id }}" method="POST" class="d-inline distpoint-delete" >
                    @method('delete')
                    @csrf
                    
                      <button type="submit"  class="btn btn-danger btn-sm"> Delete </button>
                  </form>
        
      </div>
      </td>

       <div class="modal fade" id="modal-detail{{ $device->id }}">
        <div class="modal-dialog modal-lg card card-outline ">
          <div class="modal-content">
            <div class="card-header bg-dark ">
             <h5 class="modal-title">Edit Device : {{ $customerdevice->id}} ({{ $customerdevice->name}}) </h5> 
              
              
            </div>
            <div class="modal-body ">

             
              <div class="container  ">

 <form role="form" action="/device/{{ $device->id }}" method="POST">
      @method('patch')
      @csrf

  <div class="card-body row col-md-12">
                  <div class="form-group col-md-6 ">
                    <input type="hidden" name="id_customer" value="{{$device->id_customer }}">
                    <label for="nama">Name</label>
                    <input type="text"  class="form-control  @error('name') is-invalid @enderror" name="name"  id="name" placeholder="Device Name"  value="{{$device->name }}">
                  </div>
                  <div class="form-group col-md-6  ">
                    <label for="parrent">Parent </label>
                   <select name="parrent" id="parrent" class="form-control">
                  <option value="">none</option>
                  @foreach ($devicelist as $id => $name)
                   @if ($id == $device->parrent )
              {

                <option selected value="{{ $id }}">{{ $name }}</option>
              }
              @else
              {
                <option value="{{ $id }}">{{ $name }}</option>
              }
              @endif

                  
                  @endforeach
                </select>
                  </div>
                  <div class="form-group col-md-6 ">
                    <label for="ip">Ip  </label>
                     <input type="text"   class="form-control  @error('ip') is-invalid @enderror" name="ip"  id="ip" placeher="Device ip"   value="{{$device->ip}}">
                  </div>
                  <div class="form-group col-md-6 ">
                    <label for="type">type  </label>
                     <input type="text" class="form-control  @error('type') is-invalid @enderror" name="type"  id="type" placeher="Device type"  value="{{$device->type }}">
                  </div>
                  <div class="form-group col-md-6 ">
                    <label for="sn">SN  </label>
                     <input type="text" class="form-control  @error('sn') is-invalid @enderror" name="sn"  id="sn" placeher="Device sn"  value="{{$device->sn }}">
                  </div>
                   <div class="form-group col-md-6 ">
                    <label for="owner">Owner </label>
                    <select name="owner" id="owner" class="form-control select2 @error('owner') is-invalid @enderror"">
                     @if ($device->owner == 'Ours Device' )
              {

                
                 <option selected value="Ours Device">Ours Device</option>
                  <option  value="Customer Device"> Customer Device </option>
              }
              @else
              {
               
                 <option  value="Ours Device">Ours Device</option>
                 <option selected  value="Customer Device"> Customer Device </option>
                   
              }
              @endif
            </select>
                  </div>
                   <div class="form-group col-md-12 ">
                    <label for="position">Position  </label>
                     <input type="text" class="form-control  @error('position') is-invalid @enderror" name="position"  id="position" placeher="Device position"    value="{{ $device->position  }}">
                  </div>
                   <div class="form-group col-md-12 ">
                    <label for="note">note  </label>
                     <input type="text" class="form-control  @error('note') is-invalid @enderror" name="note"  id="note" placeher="Device note"  value="{{ $device->note  }}">
                  </div>
                  
                </div> 
</div> 

              </div>
  
                  

           
            <div class="modal-footer justify-content-between float-right">
             <button type="submit" class="btn btn-primary">Submit</button>
              <button type="button" class="btn btn-primary float-right " data-dismiss="modal">Close</button>

              </form>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->



    </tr>




    @endforeach



       <div class="modal fade" id="modal-add-device">
        <div class="modal-dialog modal-lg card card-outline ">
          <div class="modal-content">
            <div class="card-header bg-dark ">
             <h5 class="modal-title">Add New Device : {{ $customerdevice->id}} ({{ $customerdevice->name}}) </h5> 
              
              
            </div>
            <div class="modal-body ">

             
              <div class="container  ">

                <form role="form" method="post" action="/device">
      @csrf
  <div class="card-body row col-md-12">
                  <div class="form-group col-md-6 ">
                    <label for="nama">Name</label>
                    <input type="text"  class="form-control  @error('name') is-invalid @enderror" name="name"  id="name" placeholder="Device Name"  value="{{old ('name') }}">
                  </div>
                  <div class="form-group col-md-6  ">
                    <label for="parrent">Parent </label>
                    <select name="parrent" id="parrent" class="form-control">
                  <option value="">none</option>
                  @foreach ($devicelist as $id => $name)
                  <option value="{{ $id }}">{{ $name }}</option>
                  @endforeach
                </select>
                    {{-- <input type="text"   class="form-control  @error('parrent') is-invalid @enderror" name="parrent"  id="parrent" placeholder="Device parent"  value="{{old('parrent')  }}"> --}}
                  </div>
                  <div class="form-group col-md-6 ">
                    <label for="ip">Ip  </label>
                     <input type="text"   class="form-control  @error('ip') is-invalid @enderror" name="ip"  id="ip" placeholder="Device ip"   value="{{old('ip')}}">
                  </div>
                  <div class="form-group col-md-6 ">
                    <label for="type">type  </label>
                     <input type="text" class="form-control  @error('type') is-invalid @enderror" name="type"  id="type" placeholder="Device type"  value="{{old('type')  }}">
                  </div>
                  <div class="form-group col-md-6 ">
                    <label for="sn">SN  </label>
                     <input type="text" class="form-control  @error('sn') is-invalid @enderror" name="sn"  id="sn" placeholder="Device sn"  value="{{ old('sn') }}">
                  </div>
                   <div class="form-group col-md-6 mb-3">
                    <label for="owner">Owner </label>
                <br>
                    <select name="owner" id="owner" class="form-control select2 @error('owner') is-invalid @enderror"">
                    <option value="Ours Device">Ours Device</option>
                    <option  value="Customer Device"> Customer Device </option>
                      
                  
                  </select>
                   {{--   <input type="text" class="form-control  r" name="owner"  id="owner" placeholder="Device owner" value="{{ old('owner')  }}"> --}}
                  </div>
                   <div class="form-group col-md-12 ">
                    <label for="posiiion">Position  </label>
                     <input type="text" class="form-control  @error('position') is-invalid @enderror" name="position"  id="position" placeholder="Device position"    value="{{ old('position')  }}">
                  </div>
                   <div class="form-group col-md-12 ">
                    <label for="note">note  </label>
                     <input type="text" class="form-control  @error('note') is-invalid @enderror" name="note"  id="note" placeholder="Device note"  value="{{ old('note')  }}">
                  </div>
              

                  <input type="hidden" name="id_customer" id="id_customer" value="{{$customerdevice->id}}">
                  
                  
                </div> 
</div> 
<div class="modal-footer justify-content-between ">
  <button type="submit" class="btn btn-primary">Submit</button>
   <button type="button" class="btn btn-primary float-right " data-dismiss="modal">Close</button>

</div>

</form>
              </div>
  
                  

           
           
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->






    
  </tbody>
</table>
</div>
</div>



         


</section>

@endsection
