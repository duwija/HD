@extends('layout.main')
@section('title','invoice List')
@section('content')
<section class="content-header">




  <div class="card card-primary card-outline">
    <div class="card-header">
      <h3 class="card-title">invoice List  </h3>

{{--  <a href="{{url ('distpoint/create')}}" class=" float-right btn  bg-gradient-primary btn-sm">Add New Ticket</a> --}}
<br>
@if (empty($date_from))
   <form role="form" method="post" action="/suminvoice/find">
      @csrf
<div class="row pt-2 pl-2">
                <a class=" pt-2"> Show From :</a>
                    <div class="input-group p-1 col-md-2   date" id="reservationdate" data-target-input="nearest">
                        <input type="text" name="date_from" id="date" class="form-control datetimepicker-input" data-target="#reservationdate" value="{{date('Y-m-1')}}" />
                        <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div>
               <a class=" pt-2"> To </a>
                 
                    <div class="input-group p-1 col-md-2 date" id="reservationdate" data-target-input="nearest">
                        <input type="text" name="date_end" id="date" class="form-control datetimepicker-input" data-target="#reservationdate" value="{{date('Y-m-d')}}" />
                        <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div>
                    
          <select name="payment_status" id="payment_status" class="input-group m-1 col-md-2">
            <option value="">ALL</option>
            <option value="0">UNPAID</option>
             <option value="1">PAID</option>
            <option value="2">CANCEL</option>
          
          </select>
       

                    <div class="input-group p-1 col-md-3">
                       <button type="submit" class="btn btn-primary">show</button>
                    </div> 
                </div>
              </form>


@else

 <form role="form" method="post" action="/suminvoice/find">
      @csrf
<div class="row float-right  pt-2 col-md-12 m-auto pl-4">
                <a class=" pt-2"> Show From :</a>
                    <div class="input-group p-1 col-md-2   date" id="reservationdate" data-target-input="nearest">
                        <input type="text" name="date_from" id="date" class="form-control datetimepicker-input" data-target="#reservationdate" value="{{$date_from}}" />
                        <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div>
               <a class=" pt-2"> To </a>
                 
                    <div class="input-group p-1 col-md-2 date" id="reservationdate" data-target-input="nearest">
                        <input type="text" name="date_end" id="date" class="form-control datetimepicker-input" data-target="#reservationdate" value="{{$date_end}}" />
                        <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div>
                <select name="payment_status" id="payment_status" class="input-group m-1 col-md-2">
          @if ($payment_status == "0")
          {
            <option value="0" selected="">UNPAID</option>
            <option value="1">PAID</option>
            <option value="2">CANCEL</option>
             <option value="">ALL</option>
           }
           @elseif ($payment_status == "1")
           {
             <option value="0" >UNPAID</option>
            <option value="1" selected="">PAID</option>
            <option value="2">CANCEL</option>
             <option value="">ALL</option>
           }
           @elseif ($payment_status == "2")
           {
             <option value="0" >UNPAID</option>
            <option value="1">PAID</option>
            <option value="2" selected="">CANCEL</option>
             <option value="">ALL</option>
           }
            @else

           {
             <option value="0" >UNPAID</option>
            <option value="1">PAID</option>
            <option value="2">CANCEL</option>
             <option value="" selected="">ALL</option>
           }



           @endif
          </select>
                    <div class="input-group p-1 col-md-3">
                       <button type="submit" class="btn btn-primary">show</button>
                    </div> 
                </div>
              </form>


@endif
    </div>
  




    


    <!-- /.card-header -->
    <div class="card-body">
      <table id="example1" class="table table-bordered table-striped">

        <thead >
          <tr>
            <th scope="col">#</th>
            <th scope="col">Invoice Date</th>
            <th scope="col">Invoice NO</th>
            <th scope="col">CID</th>
            <th scope="col">Address</th>
            <th scope="col">Total Amount</th>
            <th scope="col">Status</th>
           
           {{--  <th scope="col">Action</th> --}}
          </tr>
        </thead>
        <tbody>
         @foreach( $suminvoice as $suminvoice)


         <tr {{-- style="background-color: {{$color}}" --}}>
          <th class=" text-center">{{ $loop->iteration }} 


          </th>
          <td><strong>{{ $suminvoice->date  }} </strong></td>

     <td><a  style="text-decoration:none; color: white" href="/suminvoice/{{ $suminvoice->tempcode }}"><button class="btn bg-primary btn-sm"><strong>#{{ $suminvoice->number  }}</strong> </button> </a> </td>

  {{-- @php
      $url_payment ="https://checkout-staging.xendit.co/web/".$suminvoice->payment_id;
      @endphp

         <button class="btn bg-info"><a href={{$url_payment}}> Cara Bayar </a></button>  

     </td> --}}




         
          <td><strong><a href="/customer/{{ $suminvoice->customer->id }}">{{ $suminvoice->customer->customer_id }} </a></strong> <br>{{ $suminvoice->customer->name  }}</td>
          <td>{{$suminvoice->customer->address}}</td>
<td><strong>{{ number_format($suminvoice->total_amount, 0, ',', ',') }}</strong></td>
      @php

             if ($suminvoice->payment_status == 1)
     { $badge_sts = "badge-success";
          $status = "PAID";}
      elseif ($suminvoice->payment_status == 2 )
        { $badge_sts = "badge-secondary";
               $status = "CANCEL";}
       elseif ($suminvoice->payment_status == 0)
         {$badge_sts = "badge-danger";
                $status = "UNPAID";}
       else
         {$badge_sts = "badge-warning";
                $status = "UNKNOW";}

      @endphp
     



          <td class="text-center"><a class="badge text-white {{$badge_sts}}">{{ $status }} </br>  {{  $suminvoice->payment_date }}</a></td>


        </tr>
        @endforeach

      </tbody>
    </table>
  </div>
</div>

</section>

@endsection
