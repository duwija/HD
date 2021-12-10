
@extends('layout.main')
@section('title','My Transaction')
@section('content')
<section class="content-header">




  <div class="card  card-outline">
    <div class="card-header bg-primary">
      <h3 class="card-title badge badge-primary">{{\Auth::user()->name}}'s Transaction  </h3>
      
</div>
      {{--  <a href="{{url ('distpoint/create')}}" class=" float-right btn  bg-gradient-primary btn-sm">Add New Ticket</a> --}}
      <div class="m-4">
      
      @if (empty($date_from))
      <form role="form" method="post" action="/suminvoice/mytransaction">
        @csrf
        <div class="row pt-2 pl-2">
          <a class=" pt-2"> Show transaction From :</a>
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

          
          <div class="input-group p-1 col-md-3">
           <button type="submit" class="btn btn-warning">show</button>
         </div> 
       </div>
     </form>


     @else

     <form role="form" method="post" action="/suminvoice/mytransaction">
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

      

        <div class="input-group p-1 col-md-3">
         <button type="submit" class="btn btn-warning">show</button>
       </div> 
     </div>
   </form>


   @endif
 

</div>






 <!-- /.card-header -->
 <div class="card-body">
  <table id="example3" class="table table-bordered table-striped">
    @php
    $total=0;
    @endphp
    <thead >
      <tr>
        <th scope="col">#</th>
        <th scope="col">Recieve Payment</th>
        <th scope="col">Recieve By</th>

        <th scope="col">Invoice NO</th>
        <th scope="col">CID</th>
        <th scope="col">Note</th>
        <th scope="col">Tax %</th>
        <th scope="col">Amount</th>
         <th scope="col">Status</th>

        {{--  <th scope="col">Action</th> --}}
      </tr>
    </thead>
    <tbody>
     @foreach( $suminvoice as $suminvoice)


     <tr>
      <th class=" text-center">{{ $loop->iteration }} 


      </th>
      <td>{{ $suminvoice->payment_date  }}</td>
       <td>{{ $suminvoice->user->name  }}</td>
      <td><a href="/suminvoice/{{ $suminvoice->tempcode }}">{{ $suminvoice->number  }} </a></td>



      <td><strong><a href="/customer/{{ $suminvoice->customer->id }}">{{ $suminvoice->customer->customer_id }} </a></strong> </br> {{ $suminvoice->customer->name  }}</td>
      <td>{{ $suminvoice->note  }}</td>
      <td>{{ $suminvoice->tax  }}</td>
      <td align="right"><strong>{{ number_format($suminvoice->recieve_payment, 0, ',', '.')}} </strong></td>

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

      @php
      $total =$total + $suminvoice->recieve_payment;
      @endphp
    </tr>
    @endforeach
 <tr class="bg-primary">
<td align="center">x</td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
      <td><strong>
      Total :</strong>
    </td>
    <td align="right"><strong>{{'Rp. '. number_format($total, 0, ',', '.')}} </strong></td>
    <td></td>
  </tr>
</tbody>
</table>   

</div>
</div>

</section>

@endsection

