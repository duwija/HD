<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=0.45">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Invoice</title>
   
    <style>
        body{
            font-family:'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
            color:#333;
            text-align:left;
            font-size:10px;
            margin:2;
        }

        .btn {

  box-sizing: border-box;
  -webkit-appearance: none;
     -moz-appearance: none;
          appearance: none;
  background-color: RoyalBlue; 
  border: 1px solid #FFFF;
  border-radius: 0.3em;
  color: #FFFF;
  cursor: pointer;
  display: flex;
  align-self: center;
 /* font-size: 1rem;*/
  font-weight: 200;
  line-height: 1;
  margin: 5px;
  padding: 0.5em 0.5em;
  text-decoration: none;
  text-align: center;
  text-transform: uppercase;
  font-family: 'Montserrat', sans-serif;
  font-weight: 700;
}

/* Darker background on mouse-over */
.btn:hover {
  background-color: RoyalBlue;
}
        .container{
            margin:0 auto;
            margin-top:15px;
            padding:40px;
            width:700px;
            height:auto;
            background-color:#fff;
        }
        caption{
            font-size:28px;
            margin-bottom:10px;
        }
        table{
           /* border:1px solid #333;*/
            border-collapse:collapse;
           /* margin:0 auto;*/
            width:100%;
        }
        td, tr, th{
            padding:5px;
/*            border:1px solid #333;*/
            /*width:185px;*/
        }
        th{
            background-color: #f0f0f0;
        }
        h4, p{
            margin:0px;
        }
    </style>
    {{-- <script>
		window.print();
	</script> --}}
</head>
<body>

    <div class="container" id="invoice_pr">
  <div  >
<button style="float:right;" class="btn" onclick="window.print()">Print</button>
@php
if(!empty($suminvoice_number->file))
{
  $url=url('upload/tax').'/'.$suminvoice_number->file;

 echo' <button class="btn"><a  style="float:right; text-decoration: none; color: #FFFF" href='.$url.'> Faktur pajak </a></button>';
    
    }
@endphp


   
 
</div>
      
      <table style="border: none">
        <tr style="border: none">
          <td align="left" colspan="3">
             <img width="100px" src="/dashboard/dist/img/logo.jpg">
          </td>
          <td align="right">

<p>
PT TRIKA GLOBAL MEDIA <br>
Jl. Ir Soekarno
Br. Guliang, Desa Pejeng, <br>
Kec. Tampaksiring (80552)<br>
0361-9201919 <br>
WA : {{env('PAYMENT_WA')}}<br>
NPWP : 95.733.946.8-907.000<br>
</p>
</td>
        </tr>
         
      </table> 
      <hr> 
      @php
      $url_payment ="https://checkout-staging.xendit.co/web/".$suminvoice_number->payment_id;
      @endphp

         {{-- <button class="btn"><a  style="float:left; text-decoration: none; color: #FFFF" href={{$url_payment}}> Cara Bayar </a></button>  
       <p style="padding: 10px">
                </p> --}}
    	<div {{-- style=" background-image: url('/dashboard/dist/img/unpaid.png');background-repeat:no-repeat;background-position: center; background-size: 300px; " --}}>
    	<table style="border: none; ">
    		<tr style="border: none">
    			<td colspan="2" align="center">
    				<p> <strong>INVOICE</strong>  </p>
    			</td>
    		</tr>
    		<tr>
    		    <td >
                         <h4>Bill To:  </h4>
                        <p>{{ $customer->customer_id }}( {{ $customer->name}} )<br>
                        {{ $customer->address }}<br>
                        {{ $customer->phone }} <br>
                        {{ $customer->npwp }}
                        </p>
                        
                    </td>
                    <td style="text-align: right;" >

<?php 
if ( $suminvoice_number->payment_status == 1)
{
echo '<a style="font-size: 20; color: green">PAID </a><br>';
echo '<a style="font-size: 11; color: green">( SUDAH TERBAYAR ) </a><br>';
}
else
{
 echo ' <a style="font-size: 20; color: red">UNPAID </a><br>';
 echo ' <a style="font-size: 11; color: red">( BELUM TERBAYAR ) </a><br>';
}
?>

                     
                  
<p>					Date : {{ $suminvoice_number->date }}<br>
                    No. Invoice : <strong>#{{ $suminvoice_number->number }}</strong>
                       
                    </td>
                </p>
                </tr>
             
    	</table>   <p style="padding: 10px">
                </p>
        <table >
           
           
            <tbody>
                <tr >
                    <th style="border: 1px solid #333">#</th>
                    <th style="border: 1px solid #333">Description</th>
                    <th style="border: 1px solid #333">price</th>
                    <th style="border: 1px solid #333">Qty</th>
                    <th style="border: 1px solid #333">Total</th>
                </tr>
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
         <tr style="border: 1px solid #333" >
          <th style="border: 1px solid #333" scope="row">{{ $loop->iteration }}</th>
        {{--   <td>{{ $invoice->created_at }}</td> --}}
          <td style="border: 1px solid #333">{{ $description }}</td>
          
          <td style="border: 1px solid #333">{{ number_format($invoice->amount, 0, ',', '.') }}</td>
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
          <td align="center" style="border: 1px solid #333">{{ $invoice->qty }}</td>
          <td style="border: 1px solid #333" >{{ number_format($invoice->qty * $invoice->amount, 0, ',', '.')  }}</td>
          

        </tr>

        @endforeach
        <tr>
        <td colspan="2" style="border: 0px solid #333" ></td> <td colspan="2" style="border: 1px solid #333"> <strong> Subtotal</strong></td>

          <td style="border: 1px solid #333">
       <strong>Rp. {{ number_format($subtotal, 0, ',', '.') }} </strong> </td></tr>
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

             <tr>
             <td colspan="2" >{{-- Pembayaran ke Rek BCA  :41066666899 --}}</td>
              <td colspan="2" style="border: 1px solid #333"> <strong> Tax Ppn ({{$taxfee}}%)</strong>
              {{-- <input type="text" name="subtotal" id="subtotal" value={{$subtotal}} >--}}
              <input type="hidden" name="tax" id="tax" value={{$taxfee}} ></td> 
            {{--   <input type="text" name="tempcode" id="tempcode" value={{ $tempcode }}> --}}
          <td colspan="2" style="border: 1px solid #333">
       <strong> Rp.

      {{ number_format($tax, 0, ',', '.') }}

    </strong> </td></tr>
        <tr>
        <td colspan="2">{{-- A.N   : PT. Trika Global Media --}}</td> 
 <td colspan="2" style="border: 1px solid #333"> <strong> Total</strong></td>
          <td colspan="2" style="border: 1px solid #333">
       <strong id="total">Rp. {{ number_format($total, 0, ',', '.') }} </strong> </td></tr>
            </tbody>
            <tfoot>
                {{-- <tr>
                    <th colspan="3">Total</th>
                    <td>Rp {{ number_format($invoice->total_price) }}</td>
                </tr> --}}

               
            </tfoot>
        </table>
      </div>
         <table style="border: 1px">
        <tr style="border: none">
          <td align="left" colspan="3">
             
          </td>
          <br>
          <td align="right">
            <p> Gianyar, {{ $suminvoice_number->date }}<br><br>

{!! QrCode::size(80)->generate(url('suminvoice/'.$suminvoice_number->tempcode.'/viewinvoice')); !!}<br><br>
<strong>Finance</strong>
</p>
</td>
        </tr>
        
             
      </table> 

<hr>




@if ( $suminvoice_number->payment_status == 1)
{

}
@else
{

<a style='font-size: 14px'>
<p>Pembayaran dapat dilakukan dengan cara:</p>
<p> 1. Langsung datang ke kantor TRIKAMEDIA </p>
<p> 2. Melalui transfer Bank ke Rek BCA 41066666899 a/n PT. TRIKA GLOBAL MEDIA ( Konfirmasike bagian Payment via WA atau Tlp ) </p>
<p> 3. Melalui Pembayaran Online di link berikut :   
 </a> <button class='btn'><a  style='float:left; text-decoration: none; color: #FFFF' href={{$url_payment}}>Bayar Online </a></button>  
       
    </div>
   
}
@endif




  
    
      


</body>
</html>
