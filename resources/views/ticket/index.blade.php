@extends('layout.main')
@section('title','Ticket List')
@section('content')
<section class="content-header">




  <div class="card card-primary card-outline">
    <div class="card-header">
      <h3 class="card-title">Ticket List  </h3>

{{--  <a href="{{url ('distpoint/create')}}" class=" float-right btn  bg-gradient-primary btn-sm">Add New Ticket</a> --}}
<br>
@if (empty($date_from))
   <form role="form" method="post" action="/ticket/search">
      @csrf
<div class="row pt-2 pl-2">
                <a class=" pt-2"> Show From :</a>
                    <div class="input-group p-1 col-md-2   date" id="reservationdate" data-target-input="nearest">
                        <input type="text" name="date_from" id="date" class="form-control datetimepicker-input" data-target="#reservationdate" value="{{date('Y-m-01')}}" />
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

 <form role="form" method="post" action="/ticket/search">
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
      <table id="example1" class="table table-bordered table-striped">

        <thead >
          <tr>
            <th scope="col">#</th>
            <th scope="col">Ticket ID</th>
             <th scope="col">Status</th>
            <th scope="col">CID</th>
            {{-- <th scope="col">Customer Name</th> --}}
            <th scope="col">Title</th>
             <th scope="col">Assign to</th>
           {{--  <th scope="col">Action</th> --}}
          </tr>
        </thead>
        <tbody>
         @foreach( $ticket as $ticket)
<?php
          if ($ticket->status == "Open")
         
      {
              $color='bg-danger'; 
            $btn_c='bg-danger'; }
      
      
      elseif ($ticket->status == "Close")
        {$color='bg-secondary'; 
               $btn_c='bg-secondary'; }
         elseif ($ticket->status == "Pending")
      {  $color='bg-warning'; 
            $btn_c='bg-warning'; }
        else
       {  $color='bg-primary'; 
                $btn_c='bg-primary'; }
         
         ?>

         <tr {{-- style="background-color: {{$color}}" --}}>
          <th class="{{-- {{$color}} --}} text-center">{{ $loop->iteration }} 


          </th>
          <td align="center"><a href="{{url ('ticket')  }}/{{$ticket->id}}" {{-- class=" btn-outline-primary btn-sm --}} ><strong class="btn btn-primary {{-- {{ $btn_c}} --}} btn-sm pl-3 pr-3">{{ $ticket->id }}{{-- <br> {{ $ticket->status }}  --}}</strong> </a></td>
         <td><strong><a class="badge text-white {{$color}}">{{$ticket->status}}</a> </strong></td>

          
         
          <td><strong><a href="/customer/{{ $ticket->customer->id }}">{{ $ticket->customer->customer_id }} </a></strong> <br>{{ $ticket->customer->name  }}</td>

          
          {{-- <td>{{ $ticket->customer_id->name  }}</td> --}}
          

          <td>Scheduled : {{ $ticket->date }}  {{ $ticket->time }} </i><span class="float-right"> Created at : {{ $ticket->created_at }}</span><br><strong>{{ $ticket->tittle }} </strong></td>

          <td><strong>{{ $ticket->user->name }} </strong><br>{{ $ticket->member }} 

                      </div></td>
       
        {{--   <td >
            <div class="float-right " >
            

              <a href="/ticket/{{ $ticket->id }}/edit" title="edit" class="btn btn-primary btn-sm "> <i class="fa fa-edit"> </i> </a>


              <form  action="/ticket/{{ $ticket->id }}" method="POST" class="d-inline ticket-delete" >
                @method('delete')
                @csrf

                <button title="Delete" type="submit"  class="btn btn-danger btn-sm"> <i class="fa fa-times"> </i> </button>
              </form>

            </div>
          </td> --}}

        </tr>
        @endforeach

      </tbody>
    </table>
  </div>
</div>

</section>

@endsection
