@extends('layout.main')
@section('title','JURNAL UMUM')
@section('content')
<section class="content-header">

{{--   <div class="card card-primary card-outline">
              <div class="card-header">
                <h3 class="card-title font-weight-bold">JURNAL UMUM  </h3>
  

                <div class="float-right">
                <div class="input-group ">
  <form role="form" method="post" action="/jurnal/create">
                @csrf
            <select style="border: 1px solid blue"  name="akuntransaction" id="akuntransaction" class="form-control-sm ">
         
            @foreach ($akuntransaction as $id =>$name)
            <option value="{{ $id }}">{{ $name }}</option>
            @endforeach
          </select>
             <button type="submit" class="float-right btn bg-primary btn-sm " Add New jurnal </button>
           </form>
              </div>
            </div>
              </div>
          
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">

  <thead >
    <tr>
      <th scope="col">#</th>
       <th scope="col">ID</th>
      <th scope="col">Date</th>
      <th scope="col">Akun</th>
      
      <th scope="col">Debet</th>
       <th scope="col">Kredit</th>
        <th scope="col">Reff</th>
         <th scope="col">Description</th>
    </tr>
  </thead>
  <tbody>
    @php
    $debet =0;
    $kredit =0;
    @endphp
  	@foreach( $jurnal as $jurnal)
    <tr>
      <th scope="row">{{ $loop->iteration }}</th>
       <td>{{ $jurnal->id }}</td>
      <td>{{ $jurnal->date }}</td>
      <td>{{ $jurnal->akun_name->name }}</td>
      <td>{{ number_format($jurnal->debet, 0, ',', ',') }}</td>
      <td>{{ number_format($jurnal->kredit, 0, ',', ',') }}</td>
      <td>{{ $jurnal->reff }}</td>
      <td>{{ $jurnal->description }}</td>
      @php
$debet =$debet + $jurnal->debet;
$kredit =$kredit + $jurnal->kredit;
@endphp

      
      <td >
        <div class="float-right " >
        
        <a href="/jurnal/{{ $jurnal->id }}/edit" class="btn btn-primary btn-sm "> <i class="fa fa-edit"> </i> </a>

        
        <form  action="/jurnal/{{ $jurnal->id }}" method="POST" class="d-inline site-delete" >
                    @method('delete')
                    @csrf
                    
                      <button type="submit"  class="btn btn-danger btn-sm"> <i class="fa fa-times"> </i> </button>
                  </form>
        
      </div>
      </td>

    </tr>
    @endforeach
    <tr class="bg-primary">
      <td colspan="4"><strong>Total : </strong></td>
      <td colspan=""><strong>{{number_format($debet, 0, ',', ',')}}</strong></td>
      <td colspan=""><strong>{{number_format($kredit, 0, ',', ',')}}</strong></td>
        <td colspan="3"><strong> </strong></td>
   
    </tr>
    
  </tbody>
</table>

</div>
</div> --}}




  <div class="card card-primary card-outline">
              <div class="card-header">
                <h3 class="card-title font-weight-bold">NERACA SALDO </h3>
  

       
              </div>
          
              <div class="card-body">


<table id="example1" class="table table-bordered table-striped">
  
  
<thead >
    <tr>
      <th scope="col">#</th>
     
      <th scope="col">Akun</th>
      
     {{--  <th scope="col">Debet</th>
       <th scope="col">Kredit</th> --}}
         <th scope="col">Saldo Debet</th>
       <th scope="col">Saldo Kredit</th>
        
    </tr>
  </thead>
@php
$number=0;
$sumdebet =0;
$sumkredit=0;
@endphp
@foreach( $nsaldo as $nsaldo)



 
 

 @if ($nsaldo->debet-$nsaldo->kredit > 0)
 @php
 $sumdebet=$sumdebet+$nsaldo->debet-$nsaldo->kredit;
 @endphp
 <tr>
 <td scope="row">{{ $number=$number+1}}</td>
 <td colspan="">{{ $nsaldo->akun_name->name }}</td>
{{--  <td><strong>{{ number_format($nsaldo->debet,0,',',',') }}</strong></td>
 <td><strong>{{ number_format($nsaldo->kredit,0,',',',') }}</strong></td> --}}
 <td><strong>{{ number_format($nsaldo->debet-$nsaldo->kredit,0,',',',') }}</strong></td>
 <td><strong>0</strong></td>
</tr>
 @elseif ($nsaldo->debet-$nsaldo->kredit < 0)
 @php
 $sumkredit=$sumkredit+$nsaldo->debet-$nsaldo->kredit;
 @endphp
 <tr>
 <td scope="row">{{ $number=$number+1}}</td>
 <td colspan="">{{ $nsaldo->akun_name->name }}</td>
{{--  <td><strong>{{ number_format($nsaldo->debet,0,',',',') }}</strong></td>
 <td><strong>{{ number_format($nsaldo->kredit,0,',',',') }}</strong></td> --}}
 <td><strong>0</strong></td>
 <td><strong>{{ number_format(abs($nsaldo->debet-$nsaldo->kredit),0,',',',') }}</strong></td>
 </tr>
 @else

 @endif

 {{--  <td><strong>{{ number_format($sum->debet-$sum->kredit,0,',',',') }}</strong></td> --}}

@endforeach
<tr class="bg-primary">
   <td colspan="" >{{ $number=$number+1}}</td>
   <td colspan="" >Total</td>
  <td><strong>{{ number_format(($sumdebet),0,',',',')}}</strong></td>
 <td><strong>{{ number_format(abs($sumkredit),0,',',',')}}</strong></td>

  </tr>
</table>
</div>
</div>





  <div class="card card-primary card-outline">
              <div class="card-header">
                <h3 class="card-title font-weight-bold">LAPORAN RUGI LABA </h3>
  

       
              </div>
          
              <div class="card-body">
<table id="datatablerugilaba" class="table table-bordered table-striped">
  
  
<thead >
    <tr>
      <th scope="col">#</th>
     
      <th scope="col">Akun</th>
      
     {{--  <th scope="col">Debet</th>
       <th scope="col">Kredit</th> --}}
       <th scope="col">Saldo Debet</th>
       <th scope="col">Saldo Kredit</th>
      
        
    </tr>
  </thead>
@php
$number=0;
$sumdebet =0;
$sumkredit=0;
@endphp
@foreach( $nrugilaba as $nrugilaba)


 

@if ($nrugilaba->debet-$nrugilaba->kredit > 0)
 @php
 $sumdebet=$sumdebet+$nrugilaba->debet-$nrugilaba->kredit;
 @endphp
 <tr>
 <td scope="row">{{ $number=$number+1}}</td>

 <td colspan="">{{ $nrugilaba->name }}</td>
{{--  <td><strong>{{ number_format($nrugilaba->debet,0,',',',') }}</strong></td>
 <td><strong>{{ number_format($nrugilaba->kredit,0,',',',') }}</strong></td> --}}
 <td><strong>{{ number_format($nrugilaba->debet-$nrugilaba->kredit,0,',',',') }}</strong></td>
 <td><strong>0</strong></td>
</tr>
 @elseif ($nrugilaba->debet-$nrugilaba->kredit < 0)
 @php
 $sumkredit=$sumkredit+$nrugilaba->debet-$nrugilaba->kredit;
 @endphp
 <tr>
 <td scope="row">{{ $number=$number+1}}</td>
 <td colspan="">{{ $nrugilaba->name }}</td>
 <td><strong>0</strong></td>
 <td><strong>{{ number_format(abs($nrugilaba->debet-$nrugilaba->kredit),0,',',',') }}</strong></td>
 
{{--  <td><strong>{{ number_format($nrugilaba->debet,0,',',',') }}</strong></td>
 <td><strong>{{ number_format($nrugilaba->kredit,0,',',',') }}</strong></td> --}}
</tr> 
@endif




 {{--  <td><strong>{{ number_format($sum->debet-$sum->kredit,0,',',',') }}</strong></td> --}}

@endforeach
<tr class="bg-primary">
   <td colspan="" >{{ $number=$number+1}}</td>
     <td colspan="" >Total</td>
  <td><strong>{{ number_format(abs($sumdebet),0,',',',')}}</strong></td>
 <td><strong>{{ number_format(abs($sumkredit),0,',',',')}}</strong></td>

  </tr>

  @php
  $rl=abs($sumkredit)-abs($sumdebet);
  @endphp
  @if ($rl<=0)
  <tr  class="bg-primary">
    <td colspan="" >{{ $number=$number+1}}</td>
  <td colspan="" >Laba Rugi</td>
  <td><strong>0</strong></td>
 <td><strong>{{ number_format($rl,0,',',',')}}</strong></td>
</tr>
 @else
 <tr>
  <td colspan="" >9{{ $number=$number+1}}</td>
<td colspan="" >Laba Rugi</td>
 <td><strong>{{ number_format($rl,0,',',',')}}</strong></td>
 <td><strong>0</strong></td>
 
 </tr>
@endif
</table>
</div>
</div>






  <div class="card card-primary card-outline">
              <div class="card-header">
                <h3 class="card-title font-weight-bold">NERACA </h3>
  

       
              </div>
          
              <div class="card-body">


<table id="datatableneraca" class="table table-bordered table-striped">
  
  
<thead >
    <tr>
      <th scope="col">#</th>
     
      <th scope="col">Akun</th>
      
     {{--  <th scope="col">Debet</th>
       <th scope="col">Kredit</th> --}}
        <th scope="col">Saldo Debet</th>
       <th scope="col">saldo Kredit</th>
      
        
    </tr>
  </thead>
@php
$number=0;
$sumdebet =0;
$sumkredit=0;
@endphp
@foreach( $neraca as $neraca)

 
{{--  @php
 $sumdebet=$sumdebet+$neraca->debet;
 $sumkredit=$sumkredit+$neraca->kredit;
 @endphp --}}

 @if ($neraca->debet-$neraca->kredit > 0)
 @php
 $sumdebet=$sumdebet+$neraca->debet-$neraca->kredit;
 @endphp
 <tr>
 <th scope="row">{{ $number=$number+1}}</th>

 <td colspan="">{{ $neraca->name }}</td>
{{--  <td><strong>{{ number_format($neraca->debet,0,',',',') }}</strong></td>
 <td><strong>{{ number_format($neraca->kredit,0,',',',') }}</strong></td> --}}
 <td><strong>{{ number_format(abs($neraca->debet-$neraca->kredit),0,',',',') }}</strong></td>
 <td><strong>0</strong></td>
</tr>
 @elseif ($neraca->debet-$neraca->kredit < 0)
 @php
 $sumkredit=$sumkredit+$neraca->debet-$neraca->kredit;
 @endphp
 <tr>
 <th scope="row">{{ $number=$number+1}}</th>

 <td colspan="">{{ $neraca->name }}</td>
{{--  <td><strong>{{ number_format($neraca->debet,0,',',',') }}</strong></td>
 <td><strong>{{ number_format($neraca->kredit,0,',',',') }}</strong></td> --}}
 <td><strong>0</strong></td>
 <td><strong>{{ number_format(abs($neraca->debet-$neraca->kredit),0,',',',') }}</strong></td>
 </tr>
 @else

 @endif


 {{--  <td><strong>{{ number_format($sum->debet-$sum->kredit,0,',',',') }}</strong></td> --}}

@endforeach
<tr class="bg-primary">
 
  <td>{{ $number=$number+1}}</td>
   <td colspan="" >Total</td>
  <td><strong>{{ number_format(abs($sumdebet),0,',',',')}}</strong></td>
 <td><strong>{{ number_format(abs($sumkredit),0,',',',')}}</strong></td>

  </tr>
<tr  class="bg-primary">
  @php
  $sumneraca=abs($sumdebet)-abs($sumkredit);
  @endphp
  @if ($sumneraca>=0)

  <td>{{ $number=$number+1}}</td>
  <td colspan="" >Laba ditahan</td>
  <td><strong>0</strong></td>
 <td><strong>{{ number_format(abs($sumneraca),0,',',',')}}</strong></td>
 @else
 
 <td>{{ $number=$number+1}}</td>
<td colspan="" >Selisih</td>
 <td><strong>{{ number_format(abs($sumneraca),0,',',',')}}</strong></td>
 <td><strong>0</strong></td>
 @endif
 </tr>

</table>
</div>
</div>






</section>

@endsection

    