@extends('layout.main')
@section('title',' Distribution Point')
@section('maps')
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

        // For each orgchart box, provide the name, manager, and tooltip to show.
        data.addRows([
         
           [{'v':'{{$distpoint->id}}', 'f':'{{$distpoint->name}}<div style="color:blue; border:0px; "></div>'},
           '', 'Parents'],
          @foreach( $distpoint_chart as $distpoint_chart)
        
          ['{{$distpoint_chart->name}}', '{{$distpoint_chart->parrent}}', '{{$distpoint_chart->name}}'],
      
          @endforeach
        ]);

       @foreach( $distpoint_chart as $distpoint_chart)
        
          
      data.setRowProperty({{ $loop->iteration-1 }}, 'style', ' border: 0px; ');
          @endforeach
       

        // Create the chart.
        var chart = new google.visualization.OrgChart(document.getElementById('chart_div_distpoint'));
        // Draw the chart, setting the allowHtml option to true for the tooltips.
    
        chart.draw(data, {'allowHtml':true});
      }
   </script>

@section('content')
<section class="content-header">

  <div class="card card-primary card-outline">
    <div class="card-header">
      <h3 class="card-title font-weight-bold"> Show Detail Distribution Point </h3>
    </div>
    
      <div class="card-body">
         <div class="row">
        <div class="form-group col-md-6">
          <label style="width: 25%;"  for="nama">Name</label>
           <a class="p-md-2">{{$distpoint->name}}</a>
          </div>
        <div class="form-group col-md-6">
          <label style="width: 25%;"  for="location">Location  </label>
          <a class="p-md-2">{{$site->name}}</a>
        </div>
    </div>

     <div class="row">
      <div class="form-group col-md-6">
        <label style="width: 25%;"  for="ip">IP Address</label>
        <a class="p-md-2">{{$distpoint->ip}}</a>
        
</div>
      <div class="form-group col-md-6">
        <label style="width: 25%;"  for="security">Security</label>
       <a class="p-md-2">{{$distpoint->security}}</a>
       
      </div>
    </div>
 <div class="row">
      <div class="form-group col-md-6">
       <label style="width: 25%;"  for="parrent"> Parrent </label>
       <a href="{{$distpoint->parrent}}" class="p-md-2">{{$distpoint_name->name}}</a>
       
    </div>
    <div class="form-group col-md-6">
      <label style="width: 25%;"  for="coordinate"> Description</label>
      <a class="p-md-2">{{$distpoint->description}}</a>
    </div>
  </div>

    


 <div class=" col-md-12 card card-primary card-outline">
              <div class="card-header">
                <h3 class="card-title">Distpoint Member  </h3>


<div id="chart_div_distpoint"></div>
 
             
           
              </div>
              
              <!-- /.card-header --> <h3 class="card-title">Customer Member  </h3><br>
              <div class="card-body">
                
                <table id="example1" class="table table-bordered table-striped">

  <thead >
    <tr>
      <th scope="col">#</th>
      <th scope="col">CID</th>
     
      <th scope="col">Name</th>
    </tr>
  </thead>
  <tbody>
    @foreach( $distpoint->customer as $customer)
    <tr>
      <th scope="row">{{ $loop->iteration }}</th>
      <td>
<a href="/customer/{{$customer->id}}"> {{ $customer->customer_id }}</a></td>
    
      <td >
         {{ $customer->name }}
   
      </td>

      
      <!-- /.modal -->



    </tr>




    @endforeach
    
  </tbody>
</table>
</div>
</div>








<div class=" col-md-12 card card-primary card-outline">
    <div class="form-group">
      <label for="maps">Maps   </label>
      
      @if ($distpoint->coordinate == null)
      
        <br><a class="p-md-2">No Map set !!</a> 
      
      @else
      <div>
            {!! $map['html'] !!}
          </div>
          <div class="float-right " >
              <a href="https://www.google.com/maps/place/{{ $distpoint->coordinate }}" target="_blank" class="btn btn-info btn-sm "><i  class="fa fa-map"> </i> Show in Google Maps </a>
            </div>
      @endif
     
    </div>
  </div>



 


<div>

  {{--   @foreach( $distpoint_chart as $distpoint_chart)
  
            @endforeach
</div>
 --}}







  </div>
  <!-- /.card-body -->







  
</div>
<!-- /.card -->

<!-- Form Element sizes -->





 












</div>

  </section>

  @endsection