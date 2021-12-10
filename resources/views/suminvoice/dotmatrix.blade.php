<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invoice</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        body{
            font-family:'Arial';
            color:#333;
            
           
            margin:1;

          }
           .container{
           
            width:175px;
            font-size: 6px;
            background-color:#fff;
        }
        table{
           /* border:1px solid #333;*/
            border-collapse:collapse;
           /* margin:0 auto;*/
            width:95%;
        }
        td, tr, th{
          font-size: 12px;
        }
        </style>
    {{-- <style>
        body{
            font-family:"Arial Black";
            color:#333;
            text-align:left;
            font-size:10px;
            margin:2;
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
    </style> --}}
    {{-- <script>
		window.print();
	</script> --}}
</head>
<body style="font-size: 8px">
 
    <div class="container" >
      
      <table style="border: none">
        <tr style="border: none">
         
         
          <td align="center">
            
<img width="50px" src="/dashboard/dist/img/logo.jpg">
<p>
<strong>PT TRIKA GLOBAL MEDIA </strong> <br>
Jl. Ir Soekarno, Pejeng<br>
0361-9201919 <br>
NPWP : 95.733.946.8-907.000<br>
</p>
<p>

</p>
</td>
        </tr>
        
             
      </table> 

      
    
    	<div {{-- style=" background-image: url('/dashboard/dist/img/unpaid.png');background-repeat:no-repeat;background-position: center; background-size: 300px; " --}}>
    	<table style="border: none; ">
    		<tr style="border: none">
    			<td colspan="2" align="center">
    				<p> <strong>INVOICE</strong>  </p>
    			</td>
    		</tr>
    		<tr>
    		    <td >
              <?php 
if ( $suminvoice_number->payment_status == 1)
{
echo ' <strong><a style="font-size: 15; color: green">PAID </a> </stong><br>';
}
else
{
 echo ' <strong><a style="font-size: 15; color: red">UNPAID </a></strong><br>';
}
?>

                     
                  
         Date : {{ $suminvoice_number->date }}<br>
              No. Invoice : <strong>#{{ $suminvoice_number->number }}</strong>
<br>
                         <a>Bill To: </a>
                        {{ $customer->customer_id }}( {{ $customer->name}} )<br>
                        {{ $customer->address }}<br>
                        {{ $customer->phone }} <br>
                        {{ $customer->npwp }}
                       <br>
                        
                    </td>
                  
                
                </tr>
             
    	</table>   
        <table >
           
           
            <tbody>
                <tr >
                   
                    <th style="border: 1px solid #333">Description</th>
                   {{--  <th style="border: 1px solid #333">price</th> --}}
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
        
        {{--   <td>{{ $invoice->created_at }}</td> --}}
          <td style="border: 1px solid #333">{{ $description }}</td>
          
          {{-- <td style="border: 1px solid #333">{{ number_format($invoice->amount, 0, ',', '.') }}</td> --}}
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
          <td style="border: 1px solid #333" >
           {{ number_format($invoice->qty * $invoice->amount, 0, ',', '.') }}


          </td>
          

        </tr>

        @endforeach
        <tr>
         <td colspan="3" style="border: 1px solid #333; text-align: right;"> <strong> Subtotal </strong><strong>Rp. {{ number_format($subtotal, 0, ',', '.') }} </strong></td>

        
        </tr>
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
             
              <td colspan="3" style="border: 1px solid #333; text-align: right;"> <strong> Ppn  ({{$taxfee}}%)</strong><strong> Rp. 

      {{ number_format($tax, 0, ',', '.') }}

    </strong>
              {{-- <input type="text" name="subtotal" id="subtotal" value={{$subtotal}} >--}}
              <input type="hidden" name="tax" id="tax" value={{$taxfee}} ></td> 
            {{--   <input type="text" name="tempcode" id="tempcode" value={{ $tempcode }}> --}}
          
        </tr>
        <tr>
         
 <td colspan="3" style="border: 1px solid #333; text-align: right;"> <strong > Total  Rp. {{ number_format($total, 0, ',', '.') }}</strong></td>
          
        </tr>
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
          <td align="left" colspan="0">
             
          </td>
          <br>
          <td align="center">
            <p> Gianyar, {{ now() }}<br><br>

{!! QrCode::size(120)->generate(url('suminvoice/'.$suminvoice_number->tempcode.'/viewinvoice')); !!}<br><br>
{{-- {{url('suminvoice/'.$suminvoice_number->tempcode.'/viewinvoice')}} --}}
</p>
</td>
        </tr>
        
             
      </table> 
    </div>


    
    
      


</body>
</html>
