@extends('layout.main')
@section('title','Invoice')
@section('content')
@inject('encrypt', 'App\Invoice')
<section class="content-header">

  <div class="card card-primary card-outline">
    <div class="card-header">
      <h3 class="card-title"> <strong>INVOICE # {{$suminvoice_number->number }} </strong>  </h3>

@php
       $status = $suminvoice_number->payment_status;

      

       if ( $status ==0)
       {
        $inv_status ='UNPAID';
        $color ='red';
       }
       elseif ( $status ==1)
       {
       $inv_status ='PAID';
       $color ='blue';
       }
       elseif ( $status ==2)
       {
        $inv_status ='CANCEL';
        $color ='grey';
       }
      else
      {
         $inv_status ='UNKNOW';
         $color ='yellow';
      }

       @endphp

    </div>
    <div class="card-body row m-md-n2">

     

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
           
          
           
        <tr>
             <th style="width: 25%" class="text-right">Faktur :</th>
             <td><a href="/upload/tax/{{$suminvoice_number->file}}" target="_blank">{{$suminvoice_number->file}}</a> 
<br>
               <button type="button" class=" btn  bg-gradient-primary btn-sm" data-toggle="modal" data-target="#modal-faktur">Upload or replace Faktur</button>
             </td>
           </tr>

         </tbody>
       </table>





     </div>






     <!-- /.card -->
     <!-- /.card-header --> <div class="card-body row">




      {{-- ITEM INVOICE --}}
      <div class="col-md-12">
       
       <form role="form" method="post" action="/suminvoice">
        @csrf
        <table id="example1" class="table table-bordered table-striped">
      {{--   <div class="card card-primary card-outline">
        --}}
<div class="d-flex bg-white justify-content-center p-2  "><strong style="color:{{$color}}; font-size: 30px;"> {{$inv_status}} </strong></div>
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

          $strmonth = substr(  $invoice->periode, -6, 2);
          $stryear = substr( $invoice->periode, -4, 4);
        

          $month_num = $strmonth;
            
          
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
           

         </tr>

         @endforeach
         <tr> <td colspan="5"> <strong> Subtotal</strong></td>
          <td colspan="2">
           <strong> {{ number_format($subtotal, 0, ',', '.') }} </strong> </td></tr>
           @php 
          

           if ( $suminvoice_number->tax == null){
            $taxfee =0;
          }
          else
          {
            $taxfee =  $suminvoice_number->tax;
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
               <strong id="total"> {{ number_format($total, 0, ',', '.') }} </strong> </td></tr>
               
             </tbody>
           </table>
           
         </form>

           @if ($suminvoice_number->payment_status ==0)
           
           <button type="button" class="float-right btn p-2  bg-gradient-primary btn-sm btn-primary mb-2" data-toggle="modal" data-target="#modal-payment">  + Make Payment </button>
           <form  action="/suminvoice/{{$suminvoice_number->id }}" method="POST" class="d-inline invoice-cancel" >
                    @method('delete')
                    @csrf
                    
                     <input type="hidden" name="tempcode" value="{{$suminvoice_number->tempcode}}">
                     <input type="hidden"  class="form-control " name="updated_by" id="updated_by"  value="{{ Auth::user()->id }}">
                       
                      <button  type="submit"  class="float-left btn p-2  bg-gradient-warning btn-sm btn-warning mr-2  mb-2 "> Cancel </button>
                  </form>
         
         @else
         
          <button disabled="" type="button" class="float-right btn p-2 btn-sm btn-secondary mb-2" data-toggle="modal" data-target="#modal-payment">  + Make Payment </button>
{{-- 
          <form  action="/suminvoice/{{$id}}" method="POST" class="d-inline item-delete" >
                    @method('delete')
                    @csrf
                    
                      <button disabled="" type="submit"  class="float-left btn p-2  bg-gradient-warning btn-sm btn-warning mr-2 mb-2 "> Cancel </button>
                  </form> --}}

         
         @endif 
                  

           


         <a href="{{url('suminvoice').'/' .$invoice->tempcode. '/print'}}" target="_blank" class="btn btn-primary float-left mr-2 ">Print</a>
         <a href="{{url('suminvoice').'/' .$invoice->tempcode. '/dotmatrix'}}" target="_blank" class="btn btn-primary float-left">Print Dotmatrix</a>
       </div>
     </div>
  


<div class="modal fade" id="modal-faktur">
  <div class="modal-dialog modal-lg">
    <div class="modal-content ">
           

<div class="card card-primary card-outline p-5">
    <div class="card-header">
      <h3 class="card-title font-weight-bold"> Upload Faktur </h3>
    </div>


         <!-- Alert message (start) -->
         @if(Session::has('message'))
         <div class="alert {{ Session::get('alert-class') }}">
            {{ Session::get('message') }}
         </div>
         @endif 
         <!-- Alert message (end) -->

         <form action="/suminvoice/{{$suminvoice_number->id}}/faktur"  enctype='multipart/form-data' method="post" >
          @method('patch')
           {{csrf_field()}}

           <div class="form-group">
             <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">File <span class="required">*</span></label>
             <div class="col-md-6 col-sm-6 col-xs-12">
             
               <input type='file' name='file' class="form-control">
                <input type='hidden' name='tempcode' value="{{$suminvoice_number->tempcode}}">

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
 <div class="modal fade" id="modal-payment">
  <div class="modal-dialog modal-lg card card-primary card-outline">
    <div class="modal-content ">
            <!-- <div class="modal-header">
             <h5 class="modal-title">drap Marker to Right Posision</h5> 
              
              
           </div>-->
           <div class="modal-body ">
             <div class="content-header">

              <div class="">
                <div class="card-header">
                  <h3 class="card-title font-weight-bold"> Make Payment  </h3>
                </div>

                <div class="form-group col-md-10">
                </div>
                <form role="form" method="post" action="/suminvoice/{{$suminvoice_number->id }} ">
                  @method('patch')
                  @csrf
                  <input type="hidden"  name="tempcode" value="{{$suminvoice_number->tempcode}}">
                  <div class="card-body row">
                    <div class="form-group m-0 col-md-12">
                       <label for="description">CID / Name #</label>
                      <a href="/customer/{{ $customer->id}}"><strong>{{$customer->customer_id}} ( {{$customer->name}} )</strong></a></br>
                      <label for="description">Invoice Number #</label> 
                      <input type="hidden" name="id_customer" value="{{$customer->id}}"> 
                      <input type="hidden" name="id" value="{{$invoice->id}}"> 

                      <a href="/suminvoice/{{$suminvoice_number->tempcode}}">{{$suminvoice_number->number}} </a>
<hr>
                    </div>
                   

                    <div class="form-group m-0 col-md-6">
                      <label for="invoice_type">  Amount </label>
                      <div class="input-group mb-3">
                        <input type="text" class="form-control @error('reciece_payment') is-invalid @enderror " name="recieve_payment" id="reciece_payment"  placeholder="Rp. XXXX.XXXX" value="{{$total}}">
                    @error('amount')
                    <div class="error invalid-feedback">{{ $message }}</div>
                    @enderror
                      </div>

                    </div>
  <div class="form-group col-md-6">
                      <label for="payment_point">Payment Point</label>
                      <select name="payment_point" id="payment_point" class="form-control">
                        <option value="1">none</option>
                        @foreach ($bank as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                        @endforeach
                      </select>
                    </div>

                    
                  
                  <div class="form-group m-0 col-md-12 ">
                    <label for="qty">note</label>
                    <input type="text" class="form-control @error('note') is-invalid @enderror " name="note" id="note"  placeholder="note" value="{{old('note')}}">
                    @error('note')
                    <div class="error invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="form-group col-md-6">
                    <label for="amount">Recieve By</label>
                     <input type="hidden" readonly class="form-control " name="updated_by" id="updated_by"  value="{{ Auth::user()->id }}">
                       
                      <input type="text" readonly class="form-control"   value="{{ Auth::user()->name }}">
                   
                   
                </div>
                
                <div class=" col-md-12">
                  <button type="submit" class="btn btn-primary">Submit</button>
                  <a href="/suminvoice/{{$suminvoice_number->tempcode}}" class="btn btn-default float-right">Cancel</a>
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




 </section>
  @endsection

