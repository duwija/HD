<!DOCTYPE html>
<html>
<head>
  <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
  @inject('ticket', 'App\Ticket')
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  {{--   <meta name="csrf-token" content="{{ csrf_token() }}"> --}}
  <title>| {{env('APP_NAME')}} Helpdesk System | @yield('title')</title>

  @yield('maps')
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- DataTables -->
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
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
  <link rel="stylesheet" href="{{url('dashboard/dist/css/adminlte.min.css')}}">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">



  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css">
  <style>

    @keyframes glowing {
      0% {
        background-color: #ffd700;
        box-shadow: 0 0 1px #2ba805;
      }
      50% {
        background-color: #ffd966;
        box-shadow: 0 0 2px #49e819;
      }
      100% {
        background-color: #2ba805;
        box-shadow: 0 0 1px #2ba805;
      }
    }
    .btnblink {
      animation: glowing 1300ms infinite;
    }
  </style>

</head>
<body class="hold-transition sidebar-mini sidebar-collapse">

  <!-- Site wrapper -->
  <div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white ">
      <!-- Left navbar links -->
      <ul class="navbar-nav  m-2">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
   {{--    <li class="nav-item d-none d-sm-inline-block">
        <a href="../../index3.html" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li> --}}
    </ul>

    <!-- SEARCH FORM -->



    <form action="/customer/search" method="GET" class="form-inline bg-light ml-6">
      <div class="input-group input-group-sm m-1  ">
        <input class="form-control form-control-navbar  navbar-light badge-light" name='search' type="search" placeholder="Search Customer" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-success" type="submit">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Messages Dropdown Menu -->
      <a class="nav-link">
        <i class="nav-icon fas fa-mobile-alt p-1 " > </i>
        <span class="badge badge-warning navbar-badge" data-toggle="tooltip" data-placement="top" title="WA Payment"> <b>{{App\Whatsapp::wa_payment()}} </b></span>
      </a>
      <a class="nav-link">
        <i class="nav-icon fas fa-mobile-alt p-1"> </i>
        <span class="badge badge-warning navbar-badge" data-toggle="tooltip" data-placement="top" title="WA NOC"><b> {{App\Whatsapp::wa_noc()}} </b> </span>
      </a>

      <li class="nav-item dropdown">


        <a class="nav-link" href="/uncloseticket">
          <i class="nav-icon fas fa-ticket-alt"></i>
          <span class="badge badge-danger navbar-badge" data-toggle="tooltip" data-placement="top" title="My Ticket"> {{ $ticket->my_ticket() }}</span>
        </a>

        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">

        </div>
      </li>

      <li class="nav-item dropdown">


        <a id="navbarDropdown"  href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
          <img src="/storage/users/{{Auth::user()->photo}}" alt="User Avatar" class="img-size-50 mr-3 img-circle">
          {{--  <span class="caret"></span> --}}
        </a>


        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
         <a class="dropdown-item font-weight-bold" >
          {{ Auth::user()->name }} 
        </a>
        <hr>

        <a class="dropdown-item" href="/myticket">
          {{ " My Ticket"}}
        </a>


        @switch (Auth::user()->privilege)

        @case ("admin") 





        <a class="dropdown-item" href="/suminvoice/mytransaction">
          {{ " My Transaction"}}
        </a>
        @break
        @case ("accounting") 





        <a class="dropdown-item" href="/suminvoice/mytransaction">
          {{ " My Transaction"}}
        </a>
        @break

        @default



        @endswitch




        <hr>
        <a class="dropdown-item" href="{{'/user/'.(Auth::user()->id.'/myprofile') }}">
          {{ " My Profile"}}
        </a>
        <a class="dropdown-item" href="{{ route('logout') }}"
        onclick="event.preventDefault();
        document.getElementById('logout-form').submit();">
        {{ __('Logout') }}
      </a>

      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
      </form>


    </div>

  </li>

  
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="../../" class="brand-link">
      <img src="{{ asset('favicon.png') }}"
      alt="AdminLTE Logo"
      class="brand-image img-circle elevation-3"
      style="opacity: .8">
      <span class="brand-text font-weight-light">{{env('APP_NAME')}}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
     {{--  <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="/storage/users/{{Auth::user()->photo}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"> {{ Auth::user()->name }}</a>
        </div>
      </div>
      --}}
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
           with font-awesome or any other icon font library -->
           <li class="nav-item">

            <a href="{{ url ('/')}}" class="nav-link">
              <i class="nav-icon  fas fa-tachometer-alt"></i>
              <p>
                Dashboard
                <span class="right badge badge-danger">New</span>
              </p>
            </a>

          </li>
          <li class="nav-item">
            <a href="{{ url ('schedule')}}" target="_blank" class="nav-link">
             <i class="nav-icon fas fa-tasks"></i></i>
             <p>
              Job Schedules
              

            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ url ('customer')}}" class="nav-link">
           <i class="nav-icon fas fa-user-tag"></i></i>
           <p>
            Customers

            <object  class="right badge badge-primary"><a href="{{ url ('customer/create')}}">+ Add
            </a></object>
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ url ('ticket')}}" class="nav-link">
          <i class="nav-icon fas fa-ticket-alt"></i>
          <p>
            Tickets
            {{-- <span class="right badge badge-danger">New</span> --}}
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ url ('plan')}}" class="nav-link">
          <i class="nav-icon fas fa-money-check-alt"></i>
          <p>
            Plans
           {{--  <span class="right badge badge-danger">New</span> --}}
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ url ('site')}}" class="nav-link">
          <i class="nav-icon fa fa-globe"></i></i>
          <p>
            Sites
           {{--  <span class="right badge badge-danger">New</span> --}}
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ url ('distpoint')}}" class="nav-link">
         <i class="nav-icon fas fa-project-diagram"></i></i>
         <p>
          Distributin Point
         {{--  <span class="right badge badge-danger">New</span> --}}
        </p>
      </a>
    </li>
    <hr>
    @switch (Auth::user()->privilege)

    @case ("admin") 
    <li class="nav-item has-treeview">
      <a href="#" class="nav-link">
        <i class="nav-icon fas fa-list"></i>
        <p>
          Accounting
          <i class="right fas fa-angle-left"></i>
        </p>
      </a>
      <ul class="nav nav-treeview">
        <li class="nav-item">
          <a href="{{ url ('invoice')}}" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>Invoice</p>
          </a>
        </li>
      </ul>
      <ul class="nav nav-treeview">
        <li class="nav-item">
          <a href="{{ url ('suminvoice/transaction')}}" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>Payment</p>
          </a>
        </li>
      </ul>
      <ul class="nav nav-treeview">
        <li class="nav-item">
          <a href="{{ url ('invoice/bulk')}}" class="nav-link invoice-bulk">
            <i class="far fa-circle nav-icon"></i>
            <p>Crate Mounthly Invoice</p>
          </a>
        </li>
      </ul>
    </li>


    <li class="nav-item has-treeview">
      <a href="#" class="nav-link">
        <i class="nav-icon fas fa-list"></i>
        <p>
          Financial Report
          <i class="right fas fa-angle-left"></i>
        </p>
      </a>
      <ul class="nav nav-treeview">
        <li class="nav-item">
          <a href="{{ url ('jurnal')}}" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>Jurnal Umum</p>
          </a>
        </li>
      </ul>
      <ul class="nav nav-treeview">
        <li class="nav-item">
          <a href="{{ url ('jurnal/bukubesar')}}" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>Buku Besar</p>
          </a>
        </li>
      </ul>
      <ul class="nav nav-treeview">
        <li class="nav-item">
          <a href="{{ url ('jurnal/report')}}" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>Report</p>
          </a>
        </li>
      </ul>
      <ul class="nav nav-treeview">
        <li class="nav-item">
          <a href="{{ url ('jurnal/jpenutup')}}" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>Jurnal Penutup</p>
          </a>
        </li>
      </ul>

    </li>

    <li class="nav-item">
      <a href="{{ url ('user')}}" class="nav-link">
       <i class="nav-icon fas fa-user"></i></i>
       <p>
         User Management
         <span class="right badge badge-danger">New</span>
       </p>
     </a>
   </li>
   @break
 @case ("noc") 
 <li class="nav-item has-treeview">
      <a href="#" class="nav-link">
        <i class="nav-icon fas fa-list"></i>
        <p>
          Accounting
          <i class="right fas fa-angle-left"></i>
        </p>
      </a>
      <ul class="nav nav-treeview">
        <li class="nav-item">
          <a href="{{ url ('invoice')}}" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>Invoice</p>
          </a>
        </li>
      </ul>
      <ul class="nav nav-treeview">
        <li class="nav-item">
          <a href="{{ url ('suminvoice/transaction')}}" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>Payment</p>
          </a>
        </li>
      </ul>
    
    </li>




 @break

 @case ("accounting")

  <li class="nav-item has-treeview">
      <a href="#" class="nav-link">
        <i class="nav-icon fas fa-list"></i>
        <p>
          Accounting
          <i class="right fas fa-angle-left"></i>
        </p>
      </a>
      <ul class="nav nav-treeview">
        <li class="nav-item">
          <a href="{{ url ('invoice')}}" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>Invoice</p>
          </a>
        </li>
      </ul>
      <ul class="nav nav-treeview">
        <li class="nav-item">
          <a href="{{ url ('suminvoice/transaction')}}" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>Payment</p>
          </a>
        </li>
      </ul>
      <ul class="nav nav-treeview">
        <li class="nav-item">
          <a href="{{ url ('invoice/bulk')}}" class="nav-link invoice-bulk">
            <i class="far fa-circle nav-icon"></i>
            <p>Crate Mounthly Invoice</p>
          </a>
        </li>
      </ul>
    </li>


    <li class="nav-item has-treeview">
      <a href="#" class="nav-link">
        <i class="nav-icon fas fa-list"></i>
        <p>
          Financial Report
          <i class="right fas fa-angle-left"></i>
        </p>
      </a>
      <ul class="nav nav-treeview">
        <li class="nav-item">
          <a href="{{ url ('jurnal')}}" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>Jurnal Umum</p>
          </a>
        </li>
      </ul>
      <ul class="nav nav-treeview">
        <li class="nav-item">
          <a href="{{ url ('jurnal/bukubesar')}}" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>Buku Besar</p>
          </a>
        </li>
      </ul>
{{--       <ul class="nav nav-treeview">
        <li class="nav-item">
          <a href="{{ url ('jurnal/report')}}" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>Report</p>
          </a>
        </li>
      </ul>
      <ul class="nav nav-treeview">
        <li class="nav-item">
          <a href="{{ url ('jurnal/jpenutup')}}" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>Jurnal Penutup</p>
          </a>
        </li>
      </ul> --}}

    </li>

    

 @break

   @default



   @endswitch





       {{--  
          <li class="nav-item">
            <a href="https://adminlte.io/docs/3.0" class="nav-link">
              <i class="nav-icon fas fa-file"></i>
              <p>Documentation</p>
            </a>
          </li> --}}
          
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <div class="row">

      <div class="col-12 p-1 float-sm-right">
        @include('layout/flash-message')
      </div>
    </div>
    @yield('content')
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> Pre Beta 1.0
    </div>
    <strong>Copyright &copy; 2021 <a href="http://duwija.io">lubax</a>.</strong> All rights
    reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
{{-- <script src="{{url('dashboard/plugins/jquery/jquery.min.js')}}"></script>
Bootstrap 4
<script src="{{url('dashboard/plugins/datatables/jquery.dataTables.min.js')}}"></script> --}}
<script src="{{url('dashboard/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{url('dashboard/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{url('dashboard/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{url('dashboard/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- Sweetalert -->

<script src="{{url('dashboard/plugins/sweetalert2/sweetalert2.all.js')}}"></script>
<!-- Select2-->

<script src="{{url('dashboard/plugins/select2/js/select2.min.js')}}"></script>
<!-- Itik -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>

<script src="{{url('dashboard/dist/js/itik.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{url('dashboard/dist/js/adminlte.min.js')}}"></script>
<!-- AdminLTE fr demo purposes -->
<script src="{{url('dashboard/dist/js/demo.js')}}"></script>
<script src="{{url('dashboard/plugins/summernote/summernote-bs4.min.js')}}"></script>


<script>
  $(document).ready(function(){
        var date_input=$('input[id="date"]'); //our date input has the name "date"
        var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
        date_input.datepicker({
          format: 'yyyy-mm-dd',
          container: container,
          todayHighlight: true,
          autoclose: true,
        })
      })
    </script>
    <script>
     $(function () {
      $("#example1").DataTable({

        "lengthMenu": [[25, 50, 100, 200, -1], [25, 50, 100, 200, "All"]],



        "responsive": true,
        "autoWidth": false,
        dom: 'Bfrtip',
        buttons: [
        'pageLength',
        'copyHtml5',
        'print',

        'excelHtml5',
        'csvHtml5',
        'pdfHtml5'
        ]
      });
      $("#datatablerugilaba").DataTable({

        "lengthMenu": [[10, 25, 50, 100, 200, -1], [10, 25, 50, 100, 200, "All"]],



        "responsive": true,
        "autoWidth": false,
        dom: 'Bfrtip',
        buttons: [
        'pageLength',
        'copyHtml5',
        'excelHtml5',
        'csvHtml5',
        'pdfHtml5'
        ]
      });
      $("#datatableneraca").DataTable({

        "lengthMenu": [[10, 25, 50, 100, 200, -1], [10, 25, 50, 100, 200, "All"]],



        "responsive": true,
        "autoWidth": false,
        dom: 'Bfrtip',
        buttons: [
        'pageLength',
        'copyHtml5',
        'excelHtml5',
        'csvHtml5',
        'pdfHtml5'
        ]
      });

      $('.select2').select2();
      $('#time').timepicker({ timeFormat: 'hh:mm', startTime: '08:00',dynamic: false,
        dropdown: true,});

      $('#time_update').timepicker({ timeFormat: 'hh:mm', startTime: '08:00',dynamic: false,
        dropdown: true,});

      $('.textarea').summernote({

        height: 300,
        dialogsInBody: true,
        callbacks:{
          onInit:function(){
            $('body > .note-popover').hide();
          }
        },

      });
      $('#example2').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
        dom: 'Bfrtip',
        buttons: [
        'copyHtml5',
        'excelHtml5',
        'csvHtml5',
        'pdfHtml5'
        ]
      });
      $('#example3').DataTable({
        "paging": false,
        "lengthChange": false,
        "searching": true,
        "ordering": true,
        "info": false,
        "autoWidth": false,
        "responsive": true,
        dom: 'Bfrtip',
        buttons: [
        'copyHtml5',
        'excelHtml5',
        'csvHtml5',
        'pdfHtml5'
        ]
      });
    });
  </script>
</body>
</html>
