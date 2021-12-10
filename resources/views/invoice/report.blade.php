@extends('layout.main')
@section('title','Invoice created Report')
@section('content')
@inject('invoicecalc', 'App\Invoice')
<section class="content-header">

  <div class="card card-primary card-outline">
    <div class="card-header">
      <h3 class="card-title">Invoice Report </h3>
     
    </div>
    <div class="card-body row">

   
{!! nl2br(e($logs)) !!}



</div>






</div>

</section>


{{-- 
<div class="modal fade" id="modal-additeminvoice">
  <div class="modal-dialog modal-lg">
    <div class="modal-content ">
            <!-- <div class="modal-header">
             <h5 class="modal-title">drap Marker to Right Posision</h5> 
              
              
           </div>-->
           <div class="modal-body ">
           <div class="content-header">

<div class="card card-primary card-outline p-5">
    <div class="card-header">
      <h3 class="card-title font-weight-bold"> Add Invoice Item </h3>
    </div>

<div class="form-group col-md-12">
</div>
<form role="form" method="post" action="/invoice">
                
                @csrf
      <input type="hidden" name="id_customer" value="{{$customer->id}}">
      <div class="card-body row">
        <div class="form-group col-md-12">
          <label for="description">Description</label>
          <input type="text" class="form-control @error('description') is-invalid @enderror " name="description" id="description"  placeholder="Item Description" value="{{old('description')}}">
          @error('description')
          <div class="error invalid-feedback">{{ $message }}</div>
          @enderror
        </div>


         <div class="form-group col-md-6">
          <label for="invoice_type">  Invoice type </label>
         <div class="input-group mb-3">
          <select name="monthly_fee" id="monthly_fee" class="form-control" onchange="typeChange();">
                   
                    <option value="0">General</option>
                     <option value="1">Monthly Fee</option>
                   
                  
          </select>
        </div>

      </div>
        <div class="form-group col-md-6">
          <label for="periode">  Periode </label>
         <div class="input-group mb-4">
          
                   
<?php $monthArray = array(
                    "01" => "January", "02" => "February", "03" => "March", "04" => "April",
                    "05" => "May", "06" => "June", "07" => "July", "08" => "August",
                    "09" => "September", "10" => "October", "11" => "November", "12" => "December",
                );
$yearArray = range(2021, 2030);
?>
<select name="periode_month" id="_periode_month" class="form-control">

    @foreach ($monthArray as $index => $month) 
        <option value={{$index}} >{{$month}}</option>';
    
    @endforeach
    
                  
          </select>
          <select name="periode_year" id="periode_year" class="form-control">
    @foreach ($yearArray as $year) 
        <option >{{$year}}</option>';
    
    @endforeach 
          </select>
        </div>

      </div>
    
         <div class="form-group col-md-6 ">
          <label for="qty">qty</label>
          <input type="text" class="form-control @error('qty') is-invalid @enderror " name="qty" id="qty"  placeholder="Item qty" value="{{old('qty')}}">
          @error('qty')
          <div class="error invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
        <div class="form-group col-md-6">
          <label for="amount">amount</label>
          <input type="text" class="form-control @error('amount') is-invalid @enderror " name="amount" id="amount"  placeholder="Item amount" value="{{old('amount')}}">
          @error('amount')
          <div class="error invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
      </div>
        
<div class="card-footer col-md-12">
  <button type="submit" class="btn btn-primary">Submit</button>
  <a href="{{url('invoice').'/' .$customer->id}}" class="btn btn-default float-right">Cancel</a>
  </div>'
    </form>

  </div>

          </div>
          
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->


</div> --}}

@endsection
{{-- 
<script type="text/javascript">
  
   function typeChange() {
  
   var str = document.getElementById('monthly_fee').value;

      if (str==1)
      {
        document.getElementById('description').value="Monthly Fee";
      
        document.getElementById('amount').value=(JSON.parse("{{ json_encode($customer->plan_price) }}"));
        document.getElementById('qty').value="1";
      }
   
 }

</script> --}}