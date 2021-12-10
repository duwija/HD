@extends('layout.main')

@section('content')
<div class="container">
 {{--    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                </div>



            </div>
        </div>
    </div> --}}
            <div class="row">
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-info elevation-1"><a href="/ticket"><i class="fas fa-ticket-alt"> </a></i></span>

              <div class="info-box-content">
                
                <span class="info-box-text"> Total Open Ticket :<b>{{$ticket_count}}</b></span>


                
                 <span class="info-box-text">Todays Ticket :<b> {{$ticket_count_today}} </b> </span>
           
                
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-danger elevation-1"><a href="/suminvoice"><i class="fas fa-money-check-alt"></i></a></span>

              <div class="info-box-content">
                <span class="info-box-text">Pendding Invoice</span>
                <span class="info-box-number">{{$invoice_count}}</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

          <!-- fix for small devices only -->
          <div class="clearfix hidden-md-up"></div>

          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-cash-register"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Todays Transaction</span>
                <span class="info-box-number">{{$invoice_paid}}</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-warning elevation-1"><a href="/customer"><i class="fas fa-users"></a></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Customer</span>
                 <span class="info-box-number"> {{$cust_active}}</span>
                
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->




         
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        
            <h1>Job Schedule</h1>
          </div>
        
      
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">

        
        <!-- Timelime example  -->
        <div class="row">
          <div class="col-md-12">
            <!-- The time line -->
            <div class="timeline bg">
              <!-- timeline time label -->
              <div class="time-label">
                <span class="bg-red">{{date(" j, F Y")}}</span>
              </div>
              <!-- /.timeline-label -->
              <!-- timeline item -->
 @foreach( $ticket as $ticket)
<?php
         if ($ticket->status == "Open")
         
      
        $color='bg-danger'; 
      
      
      elseif ($ticket->status == "Close")
        $color='bg-secondary'; 
         elseif ($ticket->status == "Panding")
        $color='bg-warning'; 
        else
         $color='bg-primary'; 
         
         ?>
              <div>
               
                <div class="timeline-item  m-1 row pt-2">
                   <div class="col-md-12">
                   <span class="time p-1"><i class="fas fa-clock "></i> {{date('H:i',strtotime( $ticket->time))}}</span>
                <strong> <i class="fas fa-user-friends pl-4 pr-lg-1"></i>  {{ $ticket->user->name }} </strong> | {{ $ticket->member }}  <span{{--  class="float-right" --}}> #Created at : {{ $ticket->created_at }}</span>
              <hr class="bg-info"> </div>

                     <div class="col-md-7">

                  
                  <span class="timeline-header  ">Ticket ID : <a href="/ticket/{{ $ticket->id }}" ><button class="btn {{$color}} btn-sm">{{ $ticket->id }}</button></a> <br> CID/ Customer : <a href="/customer/{{ $ticket->customer->id }}">{{ $ticket->customer->customer_id }} ({{ $ticket->customer->name  }})</a>  </span>
              </div>
               <div class="col-md-5">
                <span class=" pr-lg-5"> Report by : {{ $ticket->called_by }} | {{$ticket->phone}} <br> Created by : {{$ticket->create_by}} </span>
               </div>

                  <div class="timeline-body">
                     <div class="ribbon-wrapper">
                        <div class="ribbon {{ $color }}">
                          {{ $ticket->status }}
                        </div>
                      </div>
                  <strong> {{ $ticket->tittle }} </strong>
                  </div>
                  
                </div>
              </div>
              <!-- END timeline item -->
              <!-- timeline item -->

@endforeach


            
            </div>
          </div>
          <!-- /.col -->
        </div>
      </div>
      <!-- /.timeline -->

    </section>
    <!-- /.content -->
  
  <!-- /.content-wrapper -->
</div>
@endsection
