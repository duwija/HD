@extends('layout.main')
@section('title',' Ticket')
@inject('statuscustomer', 'App\Statuscustomer')
@inject('plan', 'App\Plan')
@inject('distpoint', 'App\Distpoint')
@inject('user', 'App\User')

{{-- @section('maps')
{!! $map['js'] !!} --}}
{{-- @endsection --}}

{{-- <script type="text/javascript">
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

      <h3 class="card-title font-weight-bold"> Tittle : {{$ticket->tittle}}    </h3>
      <span class="float-right"><i class="far fa-ticket"></i><small> Id #{{$ticket->id}} | Create by : {{$ticket->create_by}} </small> </span> 

    </div>
    
      <div class="card-body row">

   {{--  <div class="form-group">
     
    <input type="hidden" name="id_customer" value="{{$ticket->customer->id_customer}}" >
  </div>
 --}}
        

  <table class="table table-borderless col-md-6 table-sm">
  
  <tbody>
    
      <tr class="col-md-6">
         <tr>
     <th style="width: 25%" class="text-right">Schedule :</th>
      <td><strong>{{$ticket->date}} | {{$ticket->time}} </strong></td>
      
    </tr>
         <tr>
     <th style="width: 25%" class="text-right">CID / Name :</th>
      <td><a href="/customer/{{$ticket->customer->id}}"><strong>{{$ticket->customer->customer_id}} ( {{$ticket->customer->name}} )</strong></td>
      
    </tr>
    <tr>
      <th style="width: 25%" class="text-right">Called by :</th>
      <td><a href="https://wa.me/{{$ticket->phone}}"> {{$ticket->called_by}} ( {{$ticket->phone}} ) </a></td>
      
    </tr>
   <tr>
      <th style="width: 25%" class="text-right">Address :</th>
      <td><a href="https://www.google.com/maps/place/{{ $ticket->customer->coordinate }}" target="_blank" >{{$ticket->customer->address}}</a>  </td>
      
    </tr>
    
      
    </tr>
  


  </tbody>
</table>
  <table class="table table-borderless col-md-6 table-sm">
  
  <tbody>
    
      <tr class="col-md-6">
    <tr>
      <th style="width: 25%" class="text-right">Status :</th>
      <td><strong>{{$ticket->status}}</strong> 
      </td>
      
    </tr>
    <tr>
     <th style="width: 25%" class="text-right">Assign to :</th>
      <td><strong>{{$user->user($ticket->assign_to)->name}} </strong> ( <a style="color:blue">{{$ticket->member}}</a> )
      
      </td>
      
    </tr>
     <tr>
      <th style="width: 25%" class="text-right">Distribution Point :</th>
      <td colspan="2">{{ $distpoint->distpoint($ticket->customer->id_distpoint)->name}}</td>
      
    </tr>
    
      
    </tr>
  


  </tbody>
</table>
<div class="card-body row">
  <button type="button" class="btn btn-sm btn-primary m-1" data-toggle="modal" data-target="#modal-ticketedit">      Edit Ticket</button>
   <form role="form" method="post" action="/ticket/wa_ticket">

        @csrf
        
            
                 

                   <input type='hidden' name='device' value="{{ env('WAPISENDER_TICKET') }}" class="form-control">
                   <input type='hidden' name='id_ticket' value="{{ $ticket->id }}" class="form-control">


                   <input type='hidden' name='phone' value="{{$user->user($ticket->assign_to)->phone}}" class="form-control">
                   
                   @php
                   $message  = "Hai ".$user->user($ticket->assign_to)->name.", ";
                   $message .= "\n ";
                   $message .= "\nYou have new ticket with detail below :";
                   $message .= "\nCustomer Name : *".$ticket->customer->name."*";
                  
                   $message .= "\nPhone: ".$ticket->customer->phone;
                   $message .= "\nAddress : ".$ticket->customer->address;
                   $message .= "\n";

                   $message .= "\nTitle  : *".$ticket->tittle."*";
                   $message .= "\nDescription  : ".$ticket->tittle; $ticket->description;
                   $message .= "\n";
                   $message .= "\nOpen your ticket on this url : http://".env('DOMAIN_NAME')."/ticket/".$ticket->id;
                   if (!empty($ticket->customer->coordinate))
                   {
                      $message .= "\nMaps: https://www.google.com/maps/place/".$ticket->customer->coordinate;
                   }
                   $message .= "\n";
                   $message .= "\n~ Hd System Trikamedia ~";

                      @endphp


                        <input type='hidden' name='message' value="{{$message}}" class="form-control">
                  
                    <!-- /.card-body -->

                   
                      <button type="submit" class="btn btn-success btn-sm m-1"><i class="fab fa-whatsapp">  </i> Notif</button>
                     

                   
                  </form>
         



</div>

{{-- <table class="table table-borderless col-md-6 table-sm">
  
  <tbody>
    
      <tr class="col-md-6">
    <tr>
      <th style="width: 25%" class="text-right">Customer ID (CID) :</th>
      <td>{{$ticket->customer->customer_id}}</td>
      
    </tr>
    <tr>
     <th style="width: 25%" class="text-right">Customer Name :</th>
      <td>{{$ticket->customer->name}}</td>
      
    </tr>
    <tr>
      <th style="width: 25%" class="text-right">Contact Name : </th>
      <td colspan="2">{{$ticket->customer->contact_name}}</td>
      
    </tr>
    <tr>
      <th style="width: 25%" class="text-right">Phone : </th>
      <td colspan="2">{{$ticket->customer->phone}}</td>
      
    </tr>
    <tr>
      <th style="width: 25%" class="text-right">Address : </th>
      <td colspan="2">{{$ticket->customer->address}}</td>
      
    </tr>
  </tr>


  </tbody>
</table>

  <table class="table table-borderless col-md-6 table-sm">
  
  <tbody>
    
      <tr class="col-md-6">
    <tr>
      <th style="width: 25%; " class="text-right">Status :</th>
      <th style="color: {{ $statuscustomer->status($ticket->customer->id_status)->color}}">{{ $statuscustomer->status($ticket->customer->id_status)->name}}
       
         


      </th>
      
    </tr>
    <tr>
     <th style="width: 25%" class="text-right">Plan :</th>
      <td>{{ $plan->plan($ticket->customer->id_plan)->name}}</td>
      
    </tr>
    <tr>
      <th style="width: 25%" class="text-right">Distribution Point :</th>
      <td colspan="2">{{ $distpoint->distpoint($ticket->customer->id_distpoint)->name}}</td>
      
    </tr>
     <tr>
      <th style="width: 25%" class="text-right">Note :</th>
      <td colspan="2">{{$ticket->customer->note}}</td>
      
    </tr>
  </tr>


  </tbody>
</table> --}}
{{-- <div class="col-md-12">
  <hr>
  </div>
 --}}
















<!-- /.card-body -->



</div>
<!-- /.card -->

<!-- Form Element sizes -->




      

















 
<div class="container-fluid ">
        <div class="row">
          <div class="col-12 border-dark">
            <div class="callout callout-warning" >
              <div class="col-12">
               <strong> Tiket Description </strong>
               <span class="float-right"><i class="far fa-clock"></i><small>{{$ticket->created_at}}</small> </span> 
            </div>
              <hr>
              {!! $ticket->description !!}
            </div>
          </div>
        </div>
      </div>



 @foreach( $ticket->ticketdetail as $ticketdetail)


 <div class="container-fluid ">
        <div class="row">
          <div class="col-12 border-dark">
            <div class="callout callout-success" >
              <div class="col-12">
               <strong>Update by:{{$ticketdetail->updated_by}} </strong>
               <span class="float-right"><i class="far fa-clock"></i><small> {{$ticketdetail->created_at}}</small></span> 
            </div>
              <hr>
              {!! $ticketdetail->description !!}
            </div>
          </div>
        </div>
      </div>




 @endforeach
  <div class="card-body row">
 <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-ticketupdate">Update Ticket</button>
</div>

      





<div class="modal fade" id="modal-ticketupdate">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
            <!-- <div class="modal-header">
             <h5 class="modal-title">drap Marker to Right Posision</h5> 
              
              
           </div>-->
           <div {{-- class="modal-body" --}}>
           <div {{-- class="content-header" --}}>

<div class="card card-primary card-outline">
    <div class="card-header">
      <h3 class="card-title font-weight-bold"> Ticket Update </h3>
    </div>

<form role="form" method="post" action="/ticketdetail">
      @csrf
      <input type="hidden" name="id_ticket" value="{{$ticket->id}}">
      <input type="hidden" name="updated_by" value=" {{ Auth::user()->name }}">
 <div class="form-group col-md-12">

             <label for="nama">Description</label>
            
              <!-- tools box -->
              
              <!-- /. tools -->
            
            <!-- /.card-header -->
            
              
                <textarea name="description" class="textarea" ></textarea>
            
             
           
          </div>
        
<div class="card-footer col-md-12">
  <button type="submit" class="btn btn-primary">Submit</button>
   <button type="button" class="btn btn-default float-right " data-dismiss="modal">cancel</button>

</div>
    </form>

  </div>

          </div>
          
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->


</div>



<div class="modal fade" id="modal-ticketedit">
  <div class="modal-dialog modal-lg">
    <div class="modal-content ">
            <!-- <div class="modal-header">
             <h5 class="modal-title">drap Marker to Right Posision</h5> 
              
              
           </div>-->
           <div class="">
           <div class="">

<div class="card card-primary card-outline p-5">
    <div class="card-header m-auto">
      <h3 class="card-title font-weight-bold"> Edit Ticket </h3>










    </div>


<form role="form" method="post" action="/ticket/{{$ticket->id}}/editticket">
                @method('patch')
                @csrf
      <input type="hidden" name="id_ticket" value="{{$ticket->id}}">
       <div class="form-group ">
          <label for="status">  Status </label>
         <div class="input-group ">
          @php
          $status=['Open', 'Inprogress','Pending','Close'];
          @endphp
          <select name="status" id="status" class="form-control">
                   {{--  <option selected=""> {{$ticket->status}}</option>
                    <option>Open</option>
                    <option>Inprogress</option>
                    <option>Pandding</option>
                    <option>Close</option> --}}


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

         <label for="status">  Assign to: </label>
         <div class="input-group ">
           <select name="assign_to" id="assign_to" class="form-control">
           
            @foreach ($users as $id => $name)
            @if ($ticket->assign_to == $id){
            <option value="{{ $id }}" selected="">{{ $name }}</option>

          }
          @else
          {
        <option value="{{ $id }}">{{ $name }}</option>
          }
          @endif
            
            @endforeach
          </select>
        </div>
           <label for="status">  Member : </label>
        <div class="input-group ">
           
                  <select style="width:100% " name="member[]" class="select2" multiple="multiple" data-placeholder="Select a member" >
           
             <option value="{{$ticket->member }}" selected="">{{ $ticket->member }}</option> 
             <option value="1">none</option>
            @foreach ($users as $id => $name)
            <option value="{{ $name }}">{{ $name }}</option>
            @endforeach
                  </select>
        </div>

  <div class="input-group ">
<div class="form-group col-md-6">
                  <label>Schedule Date:</label>
                    <div class="input-group date" id="reservationdate" data-target-input="nearest">
                        <input type="text" name="date" id="date" class="form-control datetimepicker-input" data-target="#reservationdate" value="{{$ticket->date}}" />
                        <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div>
                </div>

<div class="form-group col-md-6">
  
   <label>Schedule Time:</label>
<div class="input-group bootstrap-timepicker ">
            <input id="time_updates" name='time' type="time" class="form-control input-small" value="{{$ticket->time}}">
            <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
        </div>
</div>

        </div>
<div class="card-footer bg-light col-md-12">
  <button type="submit" class="btn btn-primary">Submit</button>
  {{-- <a href="{{url('customer')}}" class="btn btn-default float-right">Cancel</a> --}}
</div>
    </form>

  </div>

          </div>
          
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->


</div>


  
        


<div class="modal fade" id="modal-ticketassign">
  <div class="modal-dialog modal-lg">
    <div class="modal-content  ">
            <!-- <div class="modal-header">
             <h5 class="modal-title">drap Marker to Right Posision</h5> 
              
              
           </div>-->
           <div class="modal-body">
           <div class="content-header">

<div class="card card-primary card-outline p-5">
    <div class="card-header">
      <h3 class="card-title font-weight-bold"> Update Ticket </h3>
    </div>


<form role="form" method="post" action="/ticket/{{$ticket->id}}/assign">
                @method('patch')
                @csrf
      <input type="hidden" name="id_ticket" value="{{$ticket->id}}">
       <label for="assign_to">  Assign To </label>
        <div class="input-group mb-3">

          <select name="assign_to" id="assign_to" class="form-control">
           
            @foreach ($users as $id => $name)
            <option value="{{ $id }}">{{ $name }}</option>
            @endforeach
          </select>
        </div>
         <label for="member">  Assign To </label>
           <div class="form-group">
    
          <div class="form-group col-11">
                  
                  <select style="width:100% " name="member[]" class="select2" multiple="multiple" data-placeholder="Select a member" >
            <option value="1">none</option>
            @foreach ($users as $id => $name)
            <option value="{{ $name }}">{{ $name }}</option>
            @endforeach
                  </select>
                </div>
         
     </div>

        
<div class="card-footer col-md-12">
  <button type="submit" class="btn btn-primary">Submit</button>
  <a href="{{url('customer')}}" class="btn btn-default float-right">Cancel</a>
</div>
    </form>

  </div>

          </div>
          
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->

    </div>
    <!-- /.modal -->


</div>
 </section>
  @endsection