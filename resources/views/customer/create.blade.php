@extends('layout.main')
@section('title','Add New Customer')
@section('maps')
{!! $map['js'] !!}
@endsection
<script type="text/javascript">
  $(document).ready(function() {
    $('.js-example-basic-single').select2();
});
  function copy_name()
  {

    document.getElementById("contact_name").value= document.getElementById("name").value;
  }

  function updateDatabase(newLat, newLng)
  {
    document.getElementById("coordinate").value = newLat+','+newLng;

  }
  function toggle_custid(){
if(document.getElementById("customer_id").disabled==true)
    {
    document.getElementById("customer_id").disabled=false;
    }
else
    document.getElementById("customer_id").disabled=true;}
</script>
@section('content')
<section class="content-header">

  <div class="card card-primary card-outline">
    <div class="card-header">
      <h3 class="card-title font-weight-bold"> Add New Customer </h3>
    </div>
    <form role="form" method="post" action="/customer">
      @csrf
      <div class="card-body row">
        <div class="form-group col-md-4">
          <label for="nama">Customer Name</label>
          <input type="text" class="form-control @error('name') is-invalid @enderror " name="name" id="name"  placeholder="Customer Name" value="{{old('name')}}">
          @error('name')
          <div class="error invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
        <div class="form-group col-md-2">
          <label for="site location">  Status </label>
         <div class="input-group mb-3">
          <select name="id_status" id="id_status" class="form-control">
          {{--   <option value="1">none</option> --}}
            @foreach ($status as $id => $name)
            <option value="{{ $id }}">{{ $name }}</option>
            @endforeach
          </select>
        </div>
      </div>

            <div class="form-group col-md-3">
      <label for="customer_id"> Customer Id (CID) </label>
       @php
       $year =date('Y', time())-2000;
       $md =date('md', time());
       $ran =substr(str_shuffle("0123456789"), 0, 3);

       @endphp
      <div class="input-group mb-3">

        <input type="text"  class="form-control @error('customer_id') is-invalid @enderror" name="customer_id"  id="customer_id" placeholder="Customer ID" value="{{$year.$md.$ran}}">
        @error('customer_id')
        <div class="error invalid-feedback">{{ $message }}</div>
        @enderror
        <div class="input-group-append">
         <button type="button" class="btn btn-primary"  onclick="toggle_custid()" ><i class="fa fa-unlock" aria-hidden="true"></i></button>
       </div>
     </div>
   </div>

<div class="form-group col-md-3">
          <label for="nama">CID Password</label>
          <input type="text" class="form-control @error('password') is-invalid @enderror " name="password" id="password"  placeholder="CID Password" value="{{old('password')}}">
          @error('password')
          <div class="error invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
        
         <div class="form-group col-md-4">
          <label for="nama">Contact Name</label>
          <div class="input-group mb-3">
          <input type="text" class="form-control @error('contact_name') is-invalid @enderror " name="contact_name" id="contact_name"  placeholder="Customer contact_name" value="{{old('contact_name')}}">
          @error('contact_name')
          <div class="error invalid-feedback">{{ $message }}</div>
          @enderror
          <div class="input-group-append">
         <button type="button" class="btn btn-primary"  onclick="copy_name()" ><i class="fa fa-clone" aria-hidden="true"></i></button>
       </div>
        </div>
      </div>

         <div class="form-group col-md-2">
          <label for="nama">NPWP</label>
          <div class="input-group mb-3">
          <input type="text" class="form-control @error('npwp') is-invalid @enderror " name="npwp" id="npwp"  placeholder="Npwp" value="{{old('npwp')}}">
          @error('npwp')
          <div class="error invalid-feedback">{{ $message }}</div>
          @enderror
          <div class="input-group-append">
        
       </div>
        </div>
      </div>

      
      <div class="form-group col-md-2">
           <label for="site location"> Plan </label>
         <div class="input-group mb-3">
          <select name="id_plan" id="id_plan" class="form-control select2">
          {{--   <option value="1">none</option> --}}
            @foreach ($plan as $id => $name)
            <option value="{{ $id }}">{{ $name }}</option>
            @endforeach
          </select>
        </div>

      </div>
  <div class="form-group col-md-1">
          <label for="site location"> Ppn (%)</label>
         
         <div class="input-group mb-3">
          <input type="text" class="form-control @error('tax') is-invalid @enderror " name="tax" id="tax"  placeholder="Customer tax" value="10">
          @error('tax')
          <div class="error invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

      </div>

        <div class="form-group col-md-3">
          <label for="site location">  Distribution Point </label>
         <div class="input-group mb-3">
          <select name="id_distpoint" id="id_distpoint" class="form-control select2">
           {{--  <option value="1">none</option> --}}
            @foreach ($distpoint as $id => $name)
            <option value="{{ $id }}">{{ $name }}</option>
            @endforeach
          </select>
        </div>

      </div>




          <div class="form-group col-md-4">
          <label for="site location">  Distribution Router </label>
         <div class="input-group mb-3">
          <select name="id_distrouter" id="id_distrouter" class="form-control select2">
           {{--  <option value="1">none</option> --}}
            @foreach ($distrouter as $id => $name)
            <option value="{{ $id }}">{{ $name }}</option>
            @endforeach
          </select>
        </div>

      </div>


      <div class="form-group col-md-5">
        <label for="ip"> Customer Address</label>
        <input type="text" class="form-control" name="address" id="address"  placeholder="Enter Address" value="{{old('address')}}">

      </div>
         <div class="form-group col-md-3">
          <label for="nama">Phone No</label>
          <input type="text" class="form-control @error('phone') is-invalid @enderror " name="phone" id="phone"  placeholder="Customer phone" value="{{old('phone')}}">
          @error('phone')
          <div class="error invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
        <div class="form-group col-sm-4">
       <label for="email"> Email  </label>
       <input type="text" class="form-control @error('email') is-invalid @enderror" name="email"  id="email" placeholder="email" value="{{old('email')}}">
       @error('email')
       <div class="error invalid-feedback">{{ $message }}</div>
       @enderror

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
    <input type="hidden" name="created_by" value="{{ Auth::user()->name }}
" >
  </div>

 {{--   <div class="form-group col-md-3">
     
   </div> --}}


  <div class="form-group col-md-8">
    <label for="note">Note  </label>
    <textarea style="height: 110px;" class="form-control @error('note') is-invalid @enderror" name="note" id="note" placeholder="Site Descrition " value="{{old('note')}}"> </textarea>
    @error('note')
    <div class="error invalid-feedback">{{ $message }}</div>
    @enderror
  </div>

      
</div>
<!-- /.card-body -->

<div class="card-footer">
  <button type="submit" class="btn btn-primary">Submit</button>
  <a href="{{url('customer')}}" class="btn btn-default float-right">Cancel</a>
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