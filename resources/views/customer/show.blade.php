@extends('layout.main')
@section('title',' Customer Detail')
@section('maps')
@inject('distrouter', 'App\Distrouter')
{!! $map['js'] !!}
@endsection
 <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>



<script type="text/javascript">
      google.charts.load('current', {packages:["orgchart"]});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = new google.visualization.DataTable();

        data.addColumn('string', 'Name');
        data.addColumn('string', 'Manager');
        data.addColumn('string', 'ToolTip');
      //  data.setRowProperty(3, 'style', 'border: 1px solid green');

        // For each orgchart box, provide the name, manager, and tooltip to show.
        data.addRows([
          

  
          @foreach ($customer->device as $topology)
             [{'v':'{{$topology->id}}', 'f':'{{$topology->name}}<div style="color:blue;">{{$topology->ip}} <br>{{$topology->type}}</div>'},
           '{{$topology->parrent}}', 'owner: {{$topology->owner}} | Position :{{$topology->position}} | Note :{{$topology->note}}'],
         
      
          @endforeach
        ]);

         @foreach ($customer->device as $topology)
        
          
      data.setRowProperty({{ $loop->iteration-1 }}, 'style', ' border: 0px; ');
          @endforeach

       
        // Create the chart.
        var chart = new google.visualization.OrgChart(document.getElementById('chart_div_topology'));
        // Draw the chart, setting the allowHtml option to true for the tooltips.
    
        chart.draw(data, {'allowHtml':true});
      }
   </script>

<script type="text/javascript">

 
</script>
@section('content')
<section class="content-header">


  <div class="card  card-outline">
    <div class="card-header bg-dark  ">
      <h3 class="card-title font-weight-bold "> Show Detail Customer </h3>
    </div>
    
      <div class="card-body">


         <div class="row">


<table class="table table-borderless col-md-6 table-sm">
  
  <tbody>
    
      <tr class="col-md-6">
    <tr>
      <th style="width: 30%" class="text-right">Customer ID (CID) :</th>
      @php

             if ($customer->status_name->name == 'Active')
        $btn_sts = "btn-success";
      elseif ($customer->status_name->name == 'Inactive')
         $btn_sts = "btn-secondary";
       elseif ($customer->status_name->name == 'Block')
         $btn_sts = "btn-danger";
        elseif ($customer->status_name->name == 'Company_Properti')
         $btn_sts = "btn-primary";
       else
         $btn_sts = "btn-warning";

      @endphp
     
      <td><div class="btn {{$btn_sts}} bt btn-sm  mr-2 ">{{$customer->customer_id}}
        
 
<strong> | {{$customer->status_name->name}}</strong></div></td>
    </tr>
     <tr>
      <th style="width: 25%; " class="text-right">Password :</th>
    <td>{{$customer->password}}</td>
    </tr>
    <tr>
     <th style="width: 30%" class="text-right">Customer Name :</th>
      <td>{{$customer->name}}</td>
      
    </tr>
    <tr>
      <th style="width: 30%" class="text-right">Contact Name : </th>
      <td colspan="">{{$customer->contact_name}}</td>
      
    </tr>
    <tr>
      <th style="width: 30%" class="text-right">Phone : </th>
      <td colspan=""><a href="https://wa.me/{{$customer->phone}}"> {{$customer->phone}}</a></td>
      
    </tr>
    <tr>
      <th style="width: 30%" class="text-right">Address : </th>
      <td colspan="">{{$customer->address}}</td>
      
    </tr>
      <tr>
      <th style="width: 25%" class="text-right">Note :</th>
      <td colspan="2">{{$customer->note}}</td>
      
    </tr>
  </tr>


  </tbody>
</table>

  <table class="table table-borderless col-md-6 table-sm">
  
  <tbody>
    
      <tr class="col-md-6">
   
    <tr>
     <th style="width: 25%" class="text-right">Plan :</th>
      <td>{{$customer->plan_name->name}}</td>
      
    </tr>
     <tr>
     <th style="width: 25%" class="text-right">On Router Status :</th>
      <td>
        
<strong>
  
  @php
  try
  {
       $status = $distrouter->mikrotik_status($customer->distrouter->ip,$customer->distrouter->user,$customer->distrouter->password,$customer->distrouter->port,$customer->customer_id);
       if ($status['user'] == 'Enable')
        $btn_status = "btn-success";
      elseif ($status['user'] == 'Disable')
         $btn_status = "btn-secondary";
       else
         $btn_status = "btn-warning";

       if ($status['online'] == 'Online')
        $btn_online = "btn-success";
      elseif ($status['online'] == 'Offline')
         $btn_online = "btn-secondary";
       else
         $btn_online = "btn-warning";
     }
     catch (Exception $e)
     {
     $btn_status = "btn-warning";
     $btn_online = "btn-warning";
     $status['user'] = 'Unknow';
     $status['online'] = 'Unknow';
     $status['ip'] = 'Unknow';
     $status['uptime'] = 'Unknow';
     }

@endphp
<div class="btn {{$btn_status}} bt btn-sm  mr-2 ">
  {{$status['user']}}
</div>

<a href="http://{{$status['ip']}}" class="btn {{$btn_online}} bt btn-sm  mr-2 ">
  {{$status['online']}} | {{$status['ip']}} |  {{$status['uptime']}}
</a>

     </strong>

      </td>
      
    </tr>
    <tr>
     <th style="width: 25%" class="text-right">Distribution Router :</th>
      <td colspan="2">
        @if ( empty($customer->distrouter->name))

        {{'-'}}
        @else
{{-- <a href="/distpoint/{{ $customer->distrouter->id}}" > --}}
        {{ $customer->distrouter->name }}
     {{--  </a>  --}}

        @endif

      </td>
      
    </tr>
    <tr>
    
      <th style="width: 25%" class="text-right">Distribution Point :</th>
      <td colspan="2">
       

        @if ( empty($customer->distpoint_name->name))

        {{'-'}}
        @else
 <a href="/distpoint/{{ $customer->distpoint_name->id }}" >
        {{ $customer->distpoint_name->name }}
      </a>
        @endif

      </td>
      
    </tr>


   
     {{--  <tr>
      <th style="width: 25%" class="text-right">Device :</th>
      <td colspan="2"><a href="/device/{{ $customer->id }}" title="device" class="btn btn-primary btn-sm "> <i class="fas fa-network-wired"></i> Device </a></td>
      
    </tr> --}}
     <tr>
      <th style="width: 25%" class="text-right">Ticket :</th>
      <td colspan="2"><a href="/ticket/{{ $customer->id }}/create" title="device" class="btn btn-success btn-sm  mr-2"> <i class="fas fa-ticket-alt"></i> Create Ticket </a><a href="/ticket/view/{{ $customer->id }}" title="device" class="btn btn-primary btn-sm "> <i class="fas fa-ticket-alt"></i> View Ticket </a></td>
      
    </tr>
         <tr>
      <th style="width: 25%" class="text-right">Invoice :</th>
      <td colspan="2"><a href="/invoice/{{ $customer->id }}/create" title="device" class="btn btn-success btn-sm  mr-2"> <i class="fas fa-ticket-alt"></i> Create Manual Invoice </a><a href="/invoice/{{ $customer->id }}" title="device" class="btn btn-primary btn-sm "> <i class="fas fa-ticket-alt"></i> View Invoice </a></td>
      
    </tr>
  </tr>


  </tbody>
</table>


  <div class="card-footer col-md-12 mt-5 mb-5">
   <a href="/customer/{{ $customer->id }}/edit" title="edit" class="btn btn-primary btn-sm "> <i class="fa fa-edit">  </i> Edit </a>
    <button type="button" class="{{-- float-right  --}}btn bg-success btn-sm" data-toggle="modal" data-target="#modal-wa"> <i class="fab fa-whatsapp">  </i> WA</button>
    <form  action="/customer/{{ $customer->id }}" method="POST" class="d-inline item-delete " >
                @method('delete')
                @csrf

                <button title="Delete" type="submit"  class="btn btn-danger btn-sm float-right"> <i class="fa fa-times"> </i> Delete </button>
              </form>

</div>






  <div class=" col-md-12 card card-primary card-outline pt-2">
              <div class="card-header">
                <h3 class="card-title">File List  </h3>


 
              <button type="button" class="float-right btn  bg-gradient-primary btn-sm" data-toggle="modal" data-target="#modal-customerfile">Upload File</button>



           
              </div>
              
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">

  <thead >
    <tr>
      <th scope="col">#</th>
      <th scope="col">Name</th>
     
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
    @foreach( $customer->file as $file)
    <tr>
      <th scope="row">{{ $loop->iteration }}</th>
      <td>{{ $file->name }}</td>
    
      <td >
         <a href="{{url ($file->path) }}"  target="_blank" title="Download" class="btn btn-primary btn-sm "> <i class="" aria-hidden="true"></i> Download </a>
          <form  action="/file/{{ $file->id }}" method="POST" class="d-inline distpoint-delete" >
                @method('delete')
                @csrf

                <button title="Delete" type="submit"  class="btn btn-danger btn-sm"> Delete </button>
              </form>
   
      </td>

       
      <!-- /.modal -->



    </tr>




    @endforeach
    
  </tbody>
</table>
</div>
</div>




















 <div class=" col-md-6  card card-primary card-outline">
 
      {{-- <label for="maps">Topology   </label> --}}
  
       <a href="/device/{{ $customer->id }}" title="device" class="btn btn-info btn-sm mt-2 "> <i class="fas fa-network-wired"></i>Manage Topology </a>
     <div class="overflow-auto" id="chart_div_topology"></div>

      

    </div>
    

         

    <div class="col-md-6  card card-primary card-outline">
    {{--   <label for="maps">Maps   </label> --}}
       <a href="https://www.google.com/maps/place/{{ $customer->coordinate }}" target="_blank" class="btn btn-info btn-sm mt-2"><i  class="fa fa-map"> </i> Show in Google Maps </a>
      
      @if ($customer->coordinate == null)
      
        <br><a class="">No Map set !!</a> 
      
      @else
      <div>
            {!! $map['html'] !!}
          </div>
          <div class="float-right " >
             
            </div>
      @endif
   
    </div>

      




  </div>
  <!-- /.card-body -->


  
</div>
<!-- /.card -->

<!-- Form Element sizes -->


</div>


<div class="modal fade" id="modal-wa">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
       <div class="card-header text-center">
      <h3 class="card-title font-weight-bold"> Message </h3>
    </div>
                          <form role="form" method="post" action="/customer/wa">

                @csrf
                <div class="card-body">
               {{--    <div class="form-group">
                    <label for="nama">FROM</label>
                    <input type="text" class="form-control @error('key') is-invalid @enderror " name="key" id="key"  placeholder="Enter Plan key" value="{{env('WAPISENDER_KEY')}}">
                    @error('key')
                      <div class="error invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div> --}}
                  <div class="form-group">
                    <label for="nama">FROM</label>
                    

<select name="device" id="device" class="form-control">
  <option value="{{env('WAPISENDER_PAYMENT')}}">WA PAYMENT</option>
  <option value="{{env('WAPISENDER_TICKET')}}">WA NOC</option>

</select>

                  </div>
                  <div class="form-group">
                     <input type='hidden' name='id_customer' value="{{ $customer->id }}" class="form-control">
                    <label for="phone">To  </label>
                    <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone"  id="phone" placeholder="Phone" value="{{$customer->phone}}">
                    @error('phone')
                      <div class="error invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
             
                  <div class="form-group">
                    <label for="description">Description  </label>
                    @php
                      if ($customer->status_name->name == 'Active'){                      {}
                        $message = "Yth. ".$customer->name." ";
                        $message .= "\nAccount Anda dengan CID ".$customer->customer_id." Saat ini telah *ACTIVE*";
                        $message .= "\nSilahkan Menikmati layanan kami dengan aman dan nyaman  ";
                        $message .= "\n~ Trikamedia ~";
                      }
                      elseif ($customer->status_name->name == 'Inactive')
                      {
                       $message = "Yth. ".$customer->name." ";
                        $message .= "\nAccount Anda dengan CID ".$customer->customer_id." Saat ini dalam masa *INACTIVE*";
                        $message .= "\nSilahkan menghubungi bagian Payment untuk informasi lebih lanjut";
                         $message .= "\n~ Trikamedia ~";
                       }
                      elseif ($customer->status_name->name == 'Block')
                      {
                        $message = "Yth. ".$customer->name." ";
                        $message .= "\nAccount Anda dengan CID ".$customer->customer_id." Saat ini telah *TERISOLIR*";
                        $message .= "\nSilahkan menghubungi bagian Payment untuk informasi lebih lanjut";
                         $message .= "\n~ Trikamedia ~";
                    }
                      else
                     $message = "";
                    @endphp

                  <textarea style="height: 110px;" class="form-control" name="message" id="message" placeholder="Message" value={{$message}} >{{$message}} </textarea>
                  </div>
                  
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                  <button type="button" class="btn btn-default float-right " data-dismiss="modal">Cancel</button>
                 
                </div>
              </form>
         
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>


<div class="modal fade" id="modal-customerfile">
  <div class="modal-dialog modal-lg">
    <div class="modal-content ">
            <!-- <div class="modal-header">
             <h5 class="modal-title">drap Marker to Right Posision</h5> 
              
              
           </div>-->
           {{-- <div class="modal-body"> --}}
         {{--   <div class="content-header"> --}}

<div class="card card-primary card-outline p-5">
    <div class="card-header">
      <h3 class="card-title font-weight-bold"> Upload File </h3>
    </div>


         <!-- Alert message (start) -->
         @if(Session::has('message'))
         <div class="alert {{ Session::get('alert-class') }}">
            {{ Session::get('message') }}
         </div>
         @endif 
         <!-- Alert message (end) -->

         <form action="/file"  enctype='multipart/form-data' method="post" >
           {{csrf_field()}}

           <div class="form-group">
             <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">File <span class="required">*</span></label>
             <div class="col-md-6 col-sm-6 col-xs-12">
              <input type='hidden' name='id_customer' value="{{ $customer->id }}" class="form-control">

               <input type='file' name='file' class="form-control">

               @if ($errors->has('file'))
                 <span class="errormsg text-danger">{{ $errors->first('file') }}</span>
               @endif
             </div>
           </div>

           <div class="form-group">
             <div class="col-md-6">
               <input type="submit" name="submit" value='Submit' class='btn btn-success'>
             </div>
           </div>

         </form>
  </div>

         {{--  </div> --}}
          
        {{-- </div> --}}
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->


</div>

  </section>

  @endsection