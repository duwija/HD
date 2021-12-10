@extends('layout.main')
@section('title','New Transaction')
@section('maps')

@endsection

@section('content')
<section class="content-header">

  <div class="card card-primary card-outline">
    <div class="card-header">
      <h3 class="card-title font-weight-bold text-uppercase"> Add New Transaction </h3>



    </div>
    <p class="text-center text-uppercase p-2 "><strong>General Transaction</strong> </p>
    <form role="form" method="post" action="/jurnal/trxstore">
      @csrf
      <div class="card-body row">
        <div class="form-group col-md-6">
                  <label>Date:</label>
                    <div class="input-group date" id="reservationdate" data-target-input="nearest">
                        <input type="text" name="date" id="date" class="form-control datetimepicker-input" data-target="#reservationdate" value="{{date("Y-m-d")}}" />
                        <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div>
                </div>
                <div class="form-group col-md-6">
     
                </div>
                <input type="hidden" name="type" id="type" value="general">
        <div class="form-group col-md-6">
         <label for="location">AKUN : {{-- {{ $transactionname->debet}} --}} </label>


         <select name="akun" id="akun" class="form-control">

          @foreach ($akun as $akun)
          <option value="{{ $akun->id }}" > {{$akun->type}} | {{  $akun->name }}</option>
          @endforeach
        </select>

      </div>
        <div class="form-group col-md-6">
          
          <label for="coordinate">D/K :  </label>
          <select name="debetkredit" id="debetkredit" class="form-control">

            
            <option value="d" >debet</option>
            <option value="k" >kredit</option>
           
          </select>
        </div>
        {{-- <div class="form-group">
          <input type="hidden" name="create_at" value="{{now()}}" >
        </div> --}}
         <div class="form-group  col-md-6">
          <label for="description">Amount  </label>
          <input type="text" class="form-control @error('amount') is-invalid @enderror" name="amount" id="amount" placeholder="ex: 1000000 " value="{{old('amount')}}">
          @error('amount')
          <div class="error invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="form-group  col-md-6">
          <label for="description">Description  </label>
          <input type="text" class="form-control @error('description') is-invalid @enderror" name="description" id="description" placeholder="Site Descrition " value="{{old('description')}}">
          @error('description')
          <div class="error invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="card-footer">
  <button type="submit" class="btn btn-primary">Add</button>
  
</div>

      </div>
      <!-- /.card-body -->


    </form>
  </div>



<div class="card card-primary card-outline">

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
          <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
    @php
    $debet =0;
    $kredit =0;
    @endphp
 
  <form role="form" method="post" action="/jurnal/trxupdate">
      @csrf
    @foreach( $jurnal as $jurnal)
    <tr>
      <th scope="row">{{ $loop->iteration }}</th>
       <td>{{ $jurnal->id }}</td>
      <td>{{ $jurnal->date }}</td>
      <td>{{ $jurnal->akun_name->name }}</td>
      <td>{{ number_format($jurnal->debet, 0, ',', '.') }}</td>
      <td>{{ number_format($jurnal->kredit, 0, ',', '.') }}</td>
      <td>{{ $jurnal->reff }}</td>
      <td>{{ $jurnal->description }}</td>
      <td><a href="/jurnal/generaldel/{{$jurnal->id}}"><button title="Delete" type="button"  class="btn btn-danger btn-sm"> <i class="fa fa-times"> Delete </i> </button> </a> </td>
      @php
$debet =$debet + $jurnal->debet;
$kredit =$kredit + $jurnal->kredit;
@endphp


    </tr>
     <input type="hidden" name="jurnalid[]" value={{ $jurnal->id }}>
    @endforeach
    <tr class="bg-primary">
      <td colspan="4"><strong>Total : </strong></td>
      <td colspan=""><strong>{{number_format($debet, 0, ',', '.')}}</strong></td>
      <td colspan=""><strong>{{number_format($kredit, 0, ',', '.')}}</strong></td>

        <td colspan="2"><strong> <button type="" class="btn btn-success">Submit</button> </strong></td>

   
    </tr>
   
  </form>

    
  </tbody>
</table>

</div>
</div>
  <!-- /.card -->

  <!-- Form Element sizes -->


</div>

<!-- /.modal -->
</section>

@endsection