@extends('layout.main')
@section('title','BUKU BESAR')
@section('content')
<section class="content-header">

  <div class="card card-primary card-outline">
              <div class="card-header">
                <h3 class="card-title font-weight-bold">BUKU BESAR  </h3>



  <br>

@if (empty($date_from))
@php
$date_from=date('Y-m-d');
$date_to=date('Y-m-d');
@endphp

@else

@endif
   <form role="form" method="post" action="/jurnal/bukubesar">
      @csrf
<div class="row pt-2 pl-2">
                <a class=" pt-2"> Show From :</a>
                    <div class="input-group p-1 col-md-2   date" id="reservationdate" data-target-input="nearest">
                        <input type="text" name="date_from" id="date" class="form-control datetimepicker-input" data-target="#reservationdate" value="{{$date_from}}" />
                        <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div>
               <a class=" pt-2"> To </a>
                 
                    <div class="input-group p-1 col-md-2 date" id="reservationdate" data-target-input="nearest">
                        <input type="text" name="date_end" id="date" class="form-control datetimepicker-input" data-target="#reservationdate" value="{{$date_to}}" />
                        <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div>
                    
          <select   name="akun" id="akun" class="input-group m-1 col-md-2" >
         
            @foreach ($akun as $id =>$name)
            <option value="{{ $id }}">{{ $name }}</option>
            @endforeach
          </select>
       

                    <div class="input-group p-1 col-md-3">
                       <button type="submit" class="btn btn-primary">show</button>
                    </div> 
                </div>
              </form>





              </div>
              <div class="text-center bg-primary p-2 ">
                {{$date_msg}}
              </div>
          
              <div class="card-body">
               <table id="example1" class="table table-bordered table-striped">
  <thead >
    <tr>
      <th scope="col">#</th>
      
      <th scope="col">Date</th>
      <th scope="col">Akun</th>
      
      <th scope="col">Debet</th>
       <th scope="col">Kredit</th>
        <th scope="col">Reff</th>
         <th scope="col">Description</th> 
         <th scope="col">Type</th>
       {{--    <th scope="col">Action</th> --}}
    </tr>
  </thead>
  <tbody>
    @php
    $debet =0;
    $kredit =0;
    $number=0;
   //  $date_from= date("Y-m", strtotime($date['from']));
   // $date_to= date("Y-m", strtotime($date['to']));

    $debet= $jsaldo['debet'];
    $kredit=  $jsaldo['kredit'];

    @endphp
        <tr>
      <th scope="row" class="text-center">{{ $number=$number+1}}</th>
     
    <td>{{ $date_from }}</td>
      <td>Saldo Awal</td>
      <td>{{ number_format($jsaldo['debet'], 0, ',', ',') }}</td>
      <td>{{ number_format($jsaldo['kredit'], 0, ',', ',') }}</td>
      <td>{{ '0000000000' }}</td>
      <td> Saldo Awal</td>
   
    </tr>
  	@foreach( $jurnal as $jurnal)
    @php
     if ($jurnal->type == 'jumum'){
        $badge_sts = "badge-success";
        $msg="Jurnal Umum";
      }
      elseif ($jurnal->type == 'closed')
      {
         $badge_sts = "badge-secondary";
      
       $msg="Jurnal Penutup";
     }
      
       else
       {
         $badge_sts = "badge-warning";
       
       $msg=$jurnal->type;
     }
    @endphp


    <tr>
      <th scope="row" class="text-center">{{ $number=$number+1}}</th>
     
      <td>{{ $jurnal->date }}</td>
      <td>{{ $jurnal->akun_name->name }}</td>
      <td>{{ number_format($jurnal->debet, 0, ',', ',') }}</td>
      <td>{{ number_format($jurnal->kredit, 0, ',', ',') }}</td>
      <td>{{ $jurnal->reff }}</td>
      <td>{{ $jurnal->description }}</td>
        <td class="text-center"><a class="badge text-white {{$badge_sts}}">{{ $msg }}</a></td>
      @php
$debet =$debet + $jurnal->debet;
$kredit =$kredit + $jurnal->kredit;
@endphp

    
    </tr>
    @endforeach
    <tr class="bg-primary">
      <td class="text-center border-right-0 text-primary">{{ $number=$number+1}}</td>
       <td class="border-right-0" colspan=""><strong>Total : </strong></td>
      <td class="border-right-0"></td>
      
       
     
      <td class="border-right-0" colspan=""><strong>{{number_format($debet, 0, ',', ',')}}</strong></td>
      <td class="border-right-0" colspan=""><strong>{{number_format($kredit, 0, ',', ',')}}</strong></td>
        <td class="border-right-0" colspan=""></td> 
        <td class="border-right-0"></td>
         <td class="border-right-0"></td>
          
   
    </tr>
       <tr class="bg-primary ">
      <td class="text-center  border-right-0  text-primary">{{ $number=$number+1}}</td>
      <td class="border-right-0" colspan=""><strong>Saldo : </strong></td>
      <td class="border-right-0"></td>
      
       <td class="border-right-0"></td>
      
      <td class="border-right-0"colspan=""><strong>{{number_format($debet-$kredit, 0, ',', ',')}}</strong></td>
   
        <td class="border-right-0" colspan=""></td> <td class="border-right-0"></td>
         <td class="border-right-0"></td>
          
   
    </tr>
    
  </tbody>
</table>

</div>
</div>



















</section>

@endsection

    