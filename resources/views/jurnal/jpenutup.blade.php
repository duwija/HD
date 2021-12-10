@extends('layout.main')
@section('title','JURNAL PENUTUP')
@section('content')
<section class="content-header">

  <div class="card card-primary card-outline">
              <div class="card-header">
                <h3 class="card-title font-weight-bold">JURNAL PENUTUP  </h3>





      
</br>

  




              </div>
           
          
              <div class="card-body">
               <table id="tabel" class="table table-bordered table-striped">
  <thead >
    <tr class="bg-primary">
      <th scope="col">#</th>
      
      <th scope="col">Akun ID</th>
      <th scope="col">Akun</th>
      
      <th scope="col">Debet</th>
       <th scope="col">Kredit</th>
        {{-- <th scope="col">Reff</th>
         <th scope="col">Description</th> 
         <th scope="col">Type</th>
          <th scope="col">Action</th> --}}
    </tr>
  </thead>
  <tbody>
     <form role="form" method="post" action="/jurnal/penutup">
      @csrf
    @php
   
    $debet =0;
    $kredit =0;
    $number=0;
    $total_pendapatan=0;
    $total_beban=0;
    $rugi_laba=0;
    $saldo_deviden=0;

    @endphp
{{-- PENDAPATAN --}}
  	@foreach( $pendapatan as $pendapatan)
    @php
     if ($pendapatan->type == 'jumum'){
        $badge_sts = "badge-success";
        $msg="pendapatan Umum";
      }
      elseif ($pendapatan->type == 'closed')
      {
         $badge_sts = "badge-secondary";
      
       $msg="pendapatan Penutup";
     }
      
       else
       {
         $badge_sts = "badge-warning";
       
       $msg=$pendapatan->type;
     }
    @endphp

@php
$saldo_pendapatan = $pendapatan->debet - $pendapatan->kredit;
if ($saldo_pendapatan < 0)
{
  $saldo_p_debet = abs($saldo_pendapatan);
  $saldo_p_kredit = 0;
}
elseif ($saldo_pendapatan > 0)

{
  $saldo_p_debet = 0;
  $saldo_p_kredit = abs($saldo_pendapatan);
}

@endphp

@if ($saldo_pendapatan != 0)

    <tr >
      <th scope="row" class="text-center">{{ $number=$number+1}}</th>
      <td>{{ $pendapatan->id_akun }}</td>
      <td>{{ $pendapatan->akun_name->name }}</td>
      <td><strong>{{ number_format($saldo_p_debet, 0, ',', ',') }}</strong></td>
      <td><strong>{{ number_format($saldo_p_kredit, 0, ',', ',') }}</strong></td>
     {{--  <td>{{ $pendapatan->reff }}</td>
      <td>{{ $pendapatan->description }}</td> --}}
      <td> <input type="hidden" name="akun_id[]" value={{$pendapatan->id_akun }}></td>
       <td><input type="hidden" name="akun_debet[]" value={{$saldo_p_debet }}></td>
      <td> <input type="hidden" name="akun_kredit[]" value={{$saldo_p_kredit }}></td>



    </tr>


@endif
@php
$total_pendapatan = $total_pendapatan + $saldo_pendapatan;
@endphp
    @endforeach
    @if ($saldo_pendapatan < 0)    <tr class="bg-secondary">
      <td class="text-center">{{ $number=$number+1}}</td>
      <td>{{env('IKHTISAR_LABA_RUGI_ID')}}</td>
       <td>Iktisar Laba rugi </td>
       
      
      <td colspan=""><strong>0</strong></td>
      <td colspan=""><strong>{{number_format(abs($saldo_pendapatan), 0, ',', ',')}}</strong></td>
       {{--  <td colspan=""></td> <td></td> --}}
   
           <input type="hidden" name="akun_id[]" value={{env('IKHTISAR_LABA_RUGI_ID')}}>
       <input type="hidden" name="akun_debet[]" value='0'>
       <input type="hidden" name="akun_kredit[]" value={{abs($saldo_pendapatan) }}>
   
    </tr>
  
  @elseif(($saldo_pendapatan > 0))
     <tr class="bg-secondary">
      <td class="text-center ">{{ $number=$number+1}}</td>
       <td>{{env('IKHTISAR_LABA_RUGI_ID')}}</td>
       <td>Iktisar Laba rugi </td>
       
      
      <td colspan=""><strong>{{number_format(abs($saldo_pendapatan),0 , ',', ',')}}</strong></td>
      <td colspan=""><strong>0</strong></td>
       {{--  <td colspan=""></td> <td></td> --}}
       
           <input type="hidden" name="akun_id[]" value={{env('IKHTISAR_LABA_RUGI_ID')}}>
       <input type="hidden" name="akun_debet[]" value={{abs($saldo_pendapatan) }}>
       <input type="hidden" name="akun_kredit[]" value='0'>
   
    </tr>
  
  @endif


{{-- BEBAN --}}
    @foreach( $beban as $beban)
{{--     @php
     if ($beban->type == 'jumum'){
        $badge_sts = "badge-success";
        $msg="beban Umum";
      }
      elseif ($beban->type == 'closed')
      {
         $badge_sts = "badge-secondary";
      
       $msg="beban Penutup";
     }
      
       else
       {
         $badge_sts = "badge-warning";
       
       $msg=$beban->type;
     }
    @endphp
 --}}
@php
$saldo_beban = $beban->debet - $beban->kredit;
if ($saldo_beban < 0)
{
  $saldo_b_debet = abs($saldo_beban);
  $saldo_b_kredit = 0;
}
elseif ($saldo_beban > 0)

{
  $saldo_b_debet = 0;
  $saldo_b_kredit = abs($saldo_beban);
}

@endphp

@if ($saldo_beban != 0)

    <tr>
      <th scope="row" class="text-center">{{ $number=$number+1}}</th>
      <td>{{ $beban->id_akun }}</td>
      <td>{{ $beban->akun_name->name }}</td>
      <td><strong>{{ number_format($saldo_b_debet, 0, ',', ',') }}</strong></td>
      <td><strong>{{ number_format($saldo_b_kredit, 0, ',', ',') }}</strong></td>
    {{--   <td>{{ $beban->reff }}</td>
      <td>{{ $beban->description }}</td> --}}
      <input type="hidden" name="akun_id[]" value={{$beban->id_akun }}>
       <input type="hidden" name="akun_debet[]" value={{$saldo_b_debet }}>
       <input type="hidden" name="akun_kredit[]" value={{$saldo_b_kredit }}>
      
        

    </tr>


@endif
@php
$total_beban = $total_beban + $saldo_beban;
@endphp
    @endforeach
    @if ($total_beban < 0)    <tr class="bg-secondary">
      <td class="text-center">{{ $number=$number+1}}</td>
     <td>{{env('IKHTISAR_LABA_RUGI_ID')}}</td>
       <td>Iktisar Laba rugi </td>
       
      
      <td colspan=""><strong>0</strong></td>
      <td colspan=""><strong>{{number_format(abs($total_beban), 0, ',', ',')}}</strong>
   {{--      <td colspan=""></td> <td></td> --}}

       <input type="hidden" name="akun_id[]" value={{env('IKHTISAR_LABA_RUGI_ID')}}>
      <input type="hidden" name="akun_debet[]" value='0'></td>
      <input type="hidden" name="akun_kredit[]" value={{abs($total_beban) }}>
  
    </tr>
  
  @elseif(($total_beban > 0))
     <tr class="bg-secondary">
      <td class="text-center">{{ $number=$number+1}}</td>
      <td>{{env('IKHTISAR_LABA_RUGI_ID')}}</td>
       <td>Iktisar Laba rugi </td>
       
      
      <td colspan=""><strong>{{number_format(abs($total_beban),0 , ',', ',')}}</strong></td>
      <td colspan=""><strong>0</strong></td>
    {{--     <td colspan=""></td> <td></td> --}}
         <input type="hidden" name="akun_id[]" value={{env('IKHTISAR_LABA_RUGI_ID')}}>
       <input type="hidden" name="akun_debet[]" value={{abs($total_beban) }}>
      <input type="hidden" name="akun_kredit[]" value='0'>
   
    </tr>
  
  @endif
@php
$saldo_rl_debet=0;
$saldo_rl_kredit=0;
@endphp

 @foreach( $nrugilaba as $nrugilaba)
 @php
$saldo_rl_debet=$saldo_rl_debet+$nrugilaba->debet;
$saldo_rl_kredit=$saldo_rl_kredit+$nrugilaba->kredit;

@endphp
  @endforeach
@php

$rugi_laba = $saldo_rl_kredit - $saldo_rl_debet;

@endphp
 @if ($rugi_laba > 0)
<tr >
      <td class="text-center">{{ $number=$number+1}}</td>
      <td>{{env('IKHTISAR_LABA_RUGI_ID')}}</td>
      <td>Iktisar Laba rugi </td>
       
      
      <td colspan=""><strong>{{number_format(abs($rugi_laba),0 , ',', ',')}}</strong></td>
      <td colspan=""><strong>0</strong></td>
  {{--       <td colspan=""></td> <td></td> --}}
        <input type="hidden" name="akun_id[]" value={{env('IKHTISAR_LABA_RUGI_ID')}}>
       <input type="hidden" name="akun_debet[]" value={{abs($rugi_laba) }}>
       <input type="hidden" name="akun_kredit[]" value='0'>
   
    </tr>
    <tr class="bg-secondary">
      <td class="text-center">{{ $number=$number+1}}</td>
      <td>{{env('MODAL_ID')}}</td>
      <td>Modal Pemilik </td>
       
      <td colspan=""><strong>0</strong></td>
      <td colspan=""><strong>{{number_format(abs($rugi_laba),0 , ',', ',')}}</strong></td>
      {{-- 
        <td colspan=""></td> <td></td> --}}
         <input type="hidden" name="akun_id[]" value={{env('MODAL_ID')}}>
       <input type="hidden" name="akun_debet[]" value='0'></td>
       <input type="hidden" name="akun_kredit[]" value={{abs($rugi_laba) }}>
   
    </tr>
    @elseif ($rugi_laba < 0)

    <tr >
      <td class="text-center">{{ $number=$number+1}}</td>
      <td>{{env('IKHTISAR_LABA_RUGI_ID')}}</td>
      <td>Iktisar Laba rugi </td>
       
      
      <td colspan=""><strong>{{number_format(abs($rugi_laba),0 , ',', ',')}}</strong></td>
      <td colspan=""><strong>0</strong></td>
      {{--   <td colspan=""></td> <td></td> --}}
        <td> <input type="hidden" name="akun_id[]" value={{env('IKHTISAR_LABA_RUGI_ID')}}></td>
       <td><input type="hidden" name="akun_debet[]" value='0'></td>
      <td> <input type="hidden" name="akun_kredit[]" value={{abs($rugi_laba) }}></td>
   
    </tr>
    <tr class="bg-secondary">
      <td class="text-center">{{ $number=$number+1}}</td>
      <td>{{env('MODAL_ID')}}</td>
      <td>Modal Pemilik </td>
       
      <td colspan=""><strong>0</strong></td>
      <td colspan=""><strong>{{number_format(abs($rugi_laba),0 , ',', ',')}}</strong></td>
      
   {{--      <td colspan=""></td> <td></td> --}}
         <input type="hidden" name="akun_id[]" value={{env('MODAL_ID')}}>
       <input type="hidden" name="akun_debet[]" value={{abs($rugi_laba) }}>
      <input type="hidden" name="akun_kredit[]" value='0'>
   
    </tr>
    @endif



@php
$saldo_dv_debet=0;
$saldo_dv_kredit=0;
@endphp

 @foreach( $deviden as $deviden)
 @php
$saldo_dv_debet=$saldo_dv_debet+$deviden->debet;
$saldo_dv_kredit=$saldo_dv_kredit+$deviden->kredit;

@endphp
  @endforeach
  @php

$saldo_deviden = $saldo_dv_debet-$saldo_dv_kredit;

@endphp
 @if ($saldo_deviden !=0)
    <tr >
      <td class="text-center">{{ $number=$number+1}}</td>
      <td>{{env('MODAL_ID')}}</td>
      <td>Modal Pemilik </td>
       
      
      <td colspan=""><strong>{{number_format(abs($saldo_deviden),0 , ',', ',')}}</strong></td>
      <td colspan=""><strong>0</strong></td>
   {{--      <td colspan=""></td> <td></td> --}}
        <input type="hidden" name="akun_id[]" value={{env('MODAL_ID')}}>
       <input type="hidden" name="akun_debet[]" value={{abs($saldo_deviden) }}>
       <input type="hidden" name="akun_kredit[]" value='0'>
   
    </tr>

<tr class="bg-secondary" >
      <td class="text-center">{{ $number=$number+1}}</td>
      <td>{{env('DEVIDEN_ID')}}</td>
      <td>Deviden</td>
       
      <td colspan=""><strong>0</strong></td>
      <td colspan=""><strong>{{number_format(abs($saldo_deviden),0 , ',', ',')}}</strong></td>
      
       {{--  <td colspan=""></td> <td></td> --}}
       <input type="hidden" name="akun_id[]" value={{env('DEVIDEN_ID')}}>
      <input type="hidden" name="akun_debet[]" value='0'>
      <input type="hidden" name="akun_kredit[]" value={{abs($saldo_deviden) }}>
   
    </tr>
    @endif


 <div class="input-group p-1 col-md-3">
                       <button type="submit" class="btn btn-primary">POST JURNAL PENUTUP</button>
                    </div> 

</form>
    
  </tbody>
</table>

</div>
</div>



















</section>

@endsection

    