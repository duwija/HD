@extends('layout.main')
@section('title','Create Invoice')
@section('content')
@inject('encrypt', 'App\Invoice')
<section class="content-header">

  <div class="card card-primary card-outline">
    <div class="card-header">
      <h3 class="card-title"> <strong>INVOICE - Create New Invoice </strong>  </h3>
     

      
    </div>
    <div class="card-body row">

   

  <table class="table table-borderless col-md-6 table-sm">
  
  <tbody>
    
      <tr class="col-md-6">

         <tr>
     <th style="width: 25%" class="text-right">CID / Name :</th>
      <td><a href="/customer/{{ $customer->id}}"><strong>{{$customer->customer_id}} ( {{$customer->name}} )</strong></td>
      
    </tr>
    <tr>
      <th style="width: 25%" class="text-right">Phone :</th>
      <td><a href="https://wa.me/{{$customer->phone}}">  ( {{$customer->phone}} ) </a></td>
      
    </tr>
   <tr>
      <th style="width: 25%" class="text-right">Address :</th>
      <td><a href="https://www.google.com/maps/place/{{ $customer->coordinate }}" target="_blank" >{{$customer->address}}</a>  </td>
      
    </tr>
    
      
    </tr>
  


  </tbody>
</table>
  <table class="table table-borderless col-md-6 table-sm">
  
  <tbody>
    
      <tr class="col-md-6">
    <tr>
      <th style="width: 25%" class="text-right">Status :</th>
      <td><strong>{{$customer->status_name}}</strong> 
       </td>
      
    </tr>
    <tr>
     <th style="width: 25%" class="text-right">Plan :</th>
      <td><strong>{{$customer->plan_name}} </strong> </td>
      
       </tr>
  <tr>
     <th style="width: 25%" class="text-right">NPWP :</th>
      <td><strong>{{strtoupper($customer->npwp)}} </strong> </td>
    </tr>
  
  


  </tbody>
</table>





</div>






<!-- /.card -->
    <!-- /.card-header --> <div class="card-body row">




      {{-- ITEM INVOICE --}}
    <div class="col-md-12">
     <button type="button" class="float-right btn  bg-gradient-primary btn-sm btn-primary mb-2" data-toggle="modal" data-target="#modal-additeminvoice">  +   Add Invoice Item</button>
         <form role="form" method="post" action="/suminvoice">
      @csrf
      <table id="example1" class="table table-bordered table-striped">
      {{--   <div class="card card-primary card-outline">
    --}}

        <thead >
          <tr>
            <th scope="col">#</th>
            <th scope="col">Created At</th>
            <th scope="col">Description</th>
            <th scope="col">Price @</th>
            {{-- <th scope="col">Periode</th>
            <th scope="col">Payment Status</th> --}}
            <th scope="col">Qty</th>
            <th scope="col">Total</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>
         
      <input type="hidden" name="id_customer" value={{$customer->id}}>
      @php $subtotal=0; 
       // $tempcode=$invoice->tempcode;


      @endphp
         @foreach( $invoice as $invoice)
         @php 
         $subtotal = $subtotal + $invoice->amount * $invoice->qty ;

         $strmonth = substr( $invoice->periode, -6, 2);
         $stryear = substr( $invoice->periode, -4, 4);
     

         $month_num = $strmonth[1];
  
           
        $month_name = date("F", mktime(0, 0, 0, $month_num, 10)); 
        if ( $invoice->monthly_fee == 1 )
        {
          $description = $invoice->description.' - '.$month_name.' '.$stryear;
        }
        else
        {
          $description = $invoice->description;
        }

         @endphp
         <tr>
          <th scope="row">{{ $loop->iteration }}</th>
          <td>{{ $invoice->created_at }}</td>
          <td>{{ $description }}</td>
          
          <td>{{ number_format($invoice->amount, 0, ',', '.') }}</td>
         {{--  <td>{{ $invoice->periode }}</td> --}}
        <input type="hidden" name="invoice_item[]" value={{ $invoice->id }}>
         {{--  @if($invoice->payment_status == 0)
          
            <td style="color:white; background-color: blue" >{{ 'Un Invoice' }}</td>
             <td>
            <input type="hidden" name="invoice_item[]" value={{ $invoice->id }}>
          </td>
          @elseif($invoice->payment_status == 3)
           <td style="color:white; background-color: green" >{{ 'Invoiced' }}</td>
          @endif --}}
          <td>{{ $invoice->qty }}</td>
          <td>{{ $invoice->qty * $invoice->amount }}</td>
          <td>
           <a href="/invoice/{{ $encrypt->encrypt($invoice->id) }}/delete/{{$customer->id}}" title="delete" class="btn btn-danger btn-sm "> <i class="fa fa-times"> </i> Delete</a>
</td>

        </tr>

        @endforeach
        <tr> <td colspan="5"> <strong> Subtotal</strong></td>
          <td colspan="2">
       <strong> {{ number_format($subtotal, 0, ',', '.') }} </strong> </td></tr>
       @php 
      

       if ($customer->tax == null){
        $taxfee =0;
       }
       else
       {
        $taxfee = $customer->tax;
       }

        $tax = $subtotal * $taxfee/100;

       $total = $subtotal + $tax;

        @endphp

             <tr> <td colspan="5"> <strong> Tax Ppn ({{$taxfee}}%)</strong>
              {{-- <input type="text" name="subtotal" id="subtotal" value={{$subtotal}} >--}}
              <input type="hidden" name="tax" id="tax" value={{$taxfee}} ></td> 
            {{--   <input type="text" name="tempcode" id="tempcode" value={{ $tempcode }}> --}}
          <td colspan="2">
       <strong> 

      {{ number_format($tax, 0, ',', '.') }}

    </strong> </td></tr>
        <tr> <td colspan="5"> <strong> Total</strong></td>
          <td colspan="2">

            <input type="hidden" name="total" value={{ $total }}>
       <strong id="total"> {{ number_format($total, 0, ',', '.') }} </strong> </td></tr>
      
      </tbody>
    </table>
    <div class="float-right btn  btn-sm btn-primary mb-2">
        <button type="submit" class="btn btn-primary">Create Invoice</button>
        </div>
  

</form>
  </div>
</div>
</div>

</section>



<div class="modal fade" id="modal-additeminvoice">
  <div class="modal-dialog modal-lg">
    <div class="modal-content card card-primary card-outline ">
            <!-- <div class="modal-header">
             <h5 class="modal-title">drap Marker to Right Posision</h5> 
              
              
           </div>-->
           <div class="modal-body ">
           <div class="content-header">

<div class=" ">
    <div class="card-header">
    

     <p>   
     <a style="width: 25%" class="text-left">CID / Name :</a>
      <a href="/customer/{{ $customer->id}}"><strong>{{$customer->customer_id}} ( {{$customer->name}} )</strong></a>
      </p>
    </tr>




      <h3 class="card-title font-weight-bold"> Add Invoice Item </h3>
    </div>

<div class="form-group col-md-12">
</div>
<form role="form" method="post" action="/invoice">
                
                @csrf
      <input type="hidden" name="id_customer" value="{{$customer->id}}">
      <div class="card-body row">
        

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
    
    @if ($index == date("m"))
    {
      <option value={{$index}}  selected=''>{{$month}}</option>;
    }
    @else
    {
       <option value={{$index}}>{{$month}}</option>;
    }
    @endif
    
    @endforeach
    
                  
          </select>
          <select name="periode_year" id="periode_year" class="form-control">
    @foreach ($yearArray as $year) 
        <option >{{$year}}</option>';
    
    @endforeach 
          </select>
        </div>

      </div>
      <div class="form-group col-md-12">
          <label for="description">Description</label>
          <input type="text" class="form-control @error('description') is-invalid @enderror " name="description" id="description"  placeholder="Item Description" value="{{old('description')}}">
          @error('description')
          <div class="error invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

    
         <div class="form-group col-md-6 ">
          <label for="qty">qty</label>
          <input type="text" class="form-control @error('qty') is-invalid @enderror " name="qty" id="qty"  placeholder="Item qty" value="1">
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
  <a href="{{url('invoice').'/' .$customer->id. '/create'}}" class="btn btn-default float-right">Cancel</a>
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


</div>

@endsection

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

</script>