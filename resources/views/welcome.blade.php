<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="refresh" content="180" />

        <title>Today's Schedule</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link rel="stylesheet" href="{{url('dashboard/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{url('dashboard/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
  <!-- Select2 -->
  <link rel="stylesheet" href="{{url('dashboard/plugins/select2/css/select2.min.css')}}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{url('dashboard/plugins/fontawesome-free/css/all.min.css')}}">
  <link rel="stylesheet" href="{{url('dashboard/plugins/summernote/summernote-bs4.css')}}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
  <link rel="stylesheet" href="{{url('dashboard/dist/css/adminlte.min.css')}}">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">


        <!-- Styles -->
        {{-- <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style> --}}

    </head>
    <body>
        <div class="flex-center position-ref full-height">
           

            <div class="content card card-primary card-outline badge-info">
               
            
                 <section class="content-header">
       <div class="card-header align-middle">
          <script type="text/javascript" charset="utf-8">
    let a;
    let time;
    setInterval(() => {
      a = new Date();
      time = a.getHours() + ':' + a.getMinutes() + ':' + a.getSeconds();
      document.getElementById('time').innerHTML = time;
    }, 1000);
  </script>
 
      <h3 class="card-title font-weight-bold "> TODAY'S SCHEDULE </h3>
     
       <span class="float-right card-title font-weight-bold" id="time"></span>
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

              <?php
              $open =0;
              $close =0;
              $pending =0;
              $solved =0;
              ?>
          <?php

          if (empty($ticket[0]))
          {


}
          ?>    

 @foreach( $ticket as $ticket)

<?php
        if ($ticket->status == "Open")
        {
         $open = $open + 1;
       
      
        $color='bg-danger'; 
       }
      
      elseif ($ticket->status == "Close")
      {
         $close = $close + 1;
      
        $color='bg-secondary'; 
    }
         elseif ($ticket->status == "Pending")
       { $color='bg-warning';
        $pending =$pending + 1;
        }
        else
      {  
        $color='bg-primary';
    
        $solved = $solved + 1;
     }

         
         ?>
              <div>
               <i class="fas fa-clock bg-danger"></i>
                <div class="timeline-item  row pt-1">
                   <div class="col-md-12 p-0">
                   <span class="time p-1 "><strong> {{date('H:i',strtotime( $ticket->time))}}</strong></span>
                <strong> <i class="fas fa-user-friends pl-4 pr-lg-1"></i>  {{ $ticket->user->name }} </strong> | {{ $ticket->member }}  <span{{--  class="float-right" --}}> #Created at : {{ $ticket->created_at }}</span>  <span class="timeline-header  "> | <strong>Ticket ID : </strong> <a href="/ticket/{{ $ticket->id }}" ><span class="badge {{$color}}">{{ $ticket->id }}</span></a> </span>
              <hr class="bg-info"> </div>

                     <div class="col-md-7">

                  <span>
                 CID/ Customer : <a href="/customer/{{ $ticket->customer->id }}">{{ $ticket->customer->customer_id }} ({{ $ticket->customer->name  }})</a><br><strong> {{ $ticket->tittle }} </strong>  </span>
              </div>
               <div class="col-md-5 pt-0">
                <span class=" pr-lg-5"> Report by : {{ $ticket->called_by }} | {{$ticket->phone}} <br> Created by : {{$ticket->create_by}} </span>
               </div>

                  <div class="timeline-body">
                     <div class="ribbon-wrapper">
                        <div class="ribbon {{ $color }}">
                          {{ $ticket->status }}
                        </div>
                      </div>
                  
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
            </div>
            <div class="fixed-bottom bg-success p-2">
                <span class="badge badge-danger p-2">OPEN TICKET :  {{$open}}</span>
                  <span class="badge badge-secondary p-2">CLOSED TICKET :  {{$close}}</span>
                    <span class="badge badge-warning p-2">PENDING TICKET :  {{$pending}}</span>
                      <span class="badge badge-primary p-2">SOLVED TICKET :  {{$solved}}</span>


           </div>
        </div>
    </body>
</html>
