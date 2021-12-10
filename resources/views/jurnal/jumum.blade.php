@extends('layout.main')
@section('title','JURNAL UMUM')
@section('content')
<section class="content-header">

  <div class="card card-primary card-outline">
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
             <button type="submit" class="float-right btn bg-primary btn-sm "{{--  data-toggle="modal" data-target="#modal-jurnal" --}}> Add New jurnal </button>
           </form>
              </div>
            </div>
</br>

  

@if (empty($date_from))
   <form role="form" method="post" action="/jurnal">
      @csrf
<div class="row pt-2 pl-2">
                <a class=" pt-2"> Show From :</a>
                    <div class="input-group p-1 col-md-2   date" id="reservationdate" data-target-input="nearest">
                        <input type="text" name="date_from" id="date" class="form-control datetimepicker-input" data-target="#reservationdate" value="{{date('Y-m-1')}}" />
                        <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div>
               <a class=" pt-2"> To </a>
                 
                    <div class="input-group p-1 col-md-2 date" id="reservationdate" data-target-input="nearest">
                        <input type="text" name="date_end" id="date" class="form-control datetimepicker-input" data-target="#reservationdate" value="{{date('Y-m-d')}}" />
                        <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div>
                    
         {{--  <select   name="akun" id="akun" class="input-group m-1 col-md-2" >
            <option value="0">All</option>
            @foreach ($akun as $id =>$name)
            <option value="{{ $id }}">{{ $name }}</option>
            @endforeach
          </select> --}}
       

                    <div class="input-group p-1 col-md-3">
                       <button type="submit" class="btn btn-primary">show</button>
                    </div> 
                </div>
              </form>


@else
@endif


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
          <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
    @php
  
    $debet =0;
    $kredit =0;
    $number=0;

    @endphp

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

      
      <td >
        <div class="text-center">
        
       {{--  <a href="/jurnal/{{ $jurnal->id }}/edit" class="btn btn-primary btn-sm "> <i class="fa fa-edit"> </i> </a>
 --}}
        
        <form  action="/jurnal/{{ $jurnal->id }}" method="POST" class="d-inline item-delete" >

                    @method('delete')
                    @csrf
                    
                      <button type="submit"  class="btn btn-danger btn-sm"> <i class="fa fa-times"> </i> Delete </button>
                  </form>
        
      </div>
      </td>

    </tr>
    @endforeach
    <tr class="bg-primary">
      <td class="text-center">{{ $number=$number+1}}</td>
      <td></td>
       <td></td>
       
      <td colspan=""><strong>Total : </strong></td>
      <td colspan=""><strong>{{number_format($debet, 0, ',', ',')}}</strong></td>
      <td colspan=""><strong>{{number_format($kredit, 0, ',', ',')}}</strong></td>
        <td colspan=""></td> <td></td>
         <td></td>
          
   
    </tr>
    
  </tbody>
</table>

</div>
</div>



















</section>

@endsection

    