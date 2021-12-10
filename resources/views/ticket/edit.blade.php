@extends('layout.main')
@section('title','Edit  Ticket')

{{-- 
<script type="text/javascript">
  function copy_name()
  {

    document.getElementById("called_by").value= {!! json_encode($customer->contact_name) !!};
  }
  function copy_called_phone()
  {

    document.getElementById("phone").value= {!! json_encode($customer->phone) !!};
  }
  </script> --}}

@section('content')
<section class="content-header">

  <div class="card card-primary card-outline">
    <div class="card-header">
      <h3 class="card-title font-weight-bold"> Edit Ticket </h3>
    </div>
    <form role="form" method="post" action="/ticket">
      @csrf
      <div class="card-body row">

    <div class="form-group">
     
    <input type="hidden" name="id_customer" value="{{$customer->id}}" >
  </div>

       
<table class="table table-borderless col-md-6 table-sm">
  
  <tbody>
    
      <tr class="col-md-6">
    <tr>
      <th style="width: 25%" class="text-right">Customer ID (CID) :</th>
      <td>{{$customer->customer_id}}</td>
      
    </tr>
    <tr>
     <th style="width: 25%" class="text-right">Customer Name :</th>
      <td>{{$customer->name}}</td>
      
    </tr>
    <tr>
      <th style="width: 25%" class="text-right">Contact Name : </th>
      <td colspan="2">{{$customer->contact_name}}</td>
      
    </tr>
    <tr>
      <th style="width: 25%" class="text-right">Phone : </th>
      <td colspan="2">{{$customer->phone}}</td>
      
    </tr>
    <tr>
      <th style="width: 25%" class="text-right">Address : </th>
      <td colspan="2">{{$customer->address}}</td>
      
    </tr>
  </tr>


  </tbody>
</table>

  <table class="table table-borderless col-md-6 table-sm">
  
  <tbody>
    
      <tr class="col-md-6">
    <tr>
      <th style="width: 25%; " class="text-right">Status :</th>
      <th style="color: " >{{$customer->status_name}}</th>
      
    </tr>
    <tr>
     <th style="width: 25%" class="text-right">Plan :</th>
      <td>{{$customer->plan_name}}</td>
      
    </tr>
    <tr>
      <th style="width: 25%" class="text-right">Distribution Point :</th>
      <td colspan="2">

        @if ( empty($customer->distpoint_name))

        {{'-'}}
        @else
        {{ $customer->distpoint_name }}
        @endif

      </td>
      
    </tr>
     <tr>
      <th style="width: 25%" class="text-right">Note :</th>
      <td colspan="2">{{$customer->note}}</td>
      
    </tr>
  </tr>


  </tbody>
</table>
<div class="col-md-12">
  <hr>
  </div>
<div class="form-group col-md-12">
</div>
      <div class="form-group col-md-3">
      <label for="called_by">Called By </label>
      <div class="input-group mb-3">

        <input type="text"  class="form-control @error('called_by') is-invalid @enderror" name="called_by"  id="called_by" placeholder="Called by" value="{{old('called_by')}}">
        @error('called_by')
        <div class="error invalid-feedback">{{ $message }}</div>
        @enderror
        <div class="input-group-append">
         <button type="button" class="btn btn-primary"  onclick="copy_name()" ><i class="fa fa-clone" aria-hidden="true"></i></button>
       </div>
     </div>
   </div>
          <div class="form-group col-md-3">
          <label for=phone>Called Phone No</label>
           <div class="input-group mb-3">
          <input type="text" class="form-control @error('phone') is-invalid @enderror " name="phone" id="phone"  placeholder="Called phone" value="{{old('phone')}}">
          @error('phone')
          <div class="error invalid-feedback">{{ $message }}</div>
          @enderror
          <div class="input-group-append">
         <button type="button" class="btn btn-primary"  onclick="copy_called_phone()" ><i class="fa fa-clone" aria-hidden="true"></i></button>
       </div>
        </div>
      </div>


 <div class="form-group col-md-3">
          <label for="status">  Status </label>
         <div class="input-group mb-3">
          @php
           $status=['Open', 'Inprogress','Pending','Close'];
          @endphp
          <select name="status" id="status" class="form-control">
            @foreach ($status as $status)
            @if ($ticket->status == $status){
            <option value="{{ $status }}" selected="">{{ $status }}</option>

          }
          @else
          {
        <option value="{{ $status }}">{{ $status }}</option>
          }
          @endif
            
            @endforeach

                  
          </select>
        </div>

      </div>
       <div class="form-group col-md-3">
          <label for="category">  Category</label>
         <div class="input-group mb-3">
          <select name="id_categori" id="id_categori" class="form-control">
            @foreach ($category as $id => $name)
            <option value="{{ $id }}">{{ $name }}</option>
            @endforeach
          </select>
        </div>

      </div>

<div class="form-group col-md-6">
          <label for="tittle">Tittle</label>
          <input type="text" class="form-control @error('tittle') is-invalid @enderror " name="tittle" id="tittle"  placeholder="Ticket tittle" value="{{old('tittle')}}">
          @error('tittle')
          <div class="error invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

              <div class="form-group col-md-3">
          <label for="assign_to"> Assign to  </label>
         <div class="input-group mb-3">
          <select name="assign_to" id="assign_to" class="form-control">
           
            @foreach ($user as $id => $name)
            <option value="{{ $id }}">{{ $name }}</option>
            @endforeach
          </select>
        </div>

      </div>

        <div class="form-group col-md-3">
          <label for="member">  Member </label>
          <div class="form-group">
                  
                  <select name="member[]" class="select2" multiple="multiple" data-placeholder="Select a member" style="width: 100%;">
            <option value="1">none</option>
            @foreach ($user as $id => $name)
            <option value="{{ $name }}">{{ $name }}</option>
            @endforeach
                  </select>
                </div>
         
     </div>
        
        <div class="form-group col-md-12">
             <label for="nama">Description</label>
            
              <!-- tools box -->
              
              <!-- /. tools -->
            
            <!-- /.card-header -->
            
              
                <textarea name="description" class="textarea" ></textarea>
            
             
           
          </div>
        
        
  
   <div class="form-group">
    <input type="hidden" name="create_at" value="{{now()}}" >
     <input type="hidden" name="create_by" value="{{ Auth::user()->name }} " >
  </div>

 
<div class="form-group col-md-3">
                  <label>Date:</label>
                    <div class="input-group date" id="reservationdate" data-target-input="nearest">
                        <input type="text" name="date" id="date" class="form-control datetimepicker-input" data-target="#reservationdate" value="{{date("Y-m-d")}}" />
                        <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div>
                </div>

<div class="form-group col-md-3">
   <label>Time:</label>
<div class="input-group bootstrap-timepicker timepicker">
            <input id="time" name='time' type="text" class="form-control input-small" value="{{date("H:i")}}">
            <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
        </div>
</div>




<!-- /.card-body -->

<div class="card-footer col-md-12">
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