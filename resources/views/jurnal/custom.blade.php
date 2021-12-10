@extends('layout.main')
@section('title','Add New Site')
@section('maps')

@endsection

@section('content')
<section class="content-header">

  <div class="card card-primary card-outline">
    <div class="card-header">
      <h3 class="card-title font-weight-bold text-uppercase"> Add New {{ $transactionname->name}} </h3>
{{-- 
      <div class="">
        <div class="input-group col-md-4 float-md-right">
          <form role="form" method="post" action="/cjurnal/create">
            @csrf
            <select  name="akuntransaction" id="akuntransaction" class="form-control">

              @foreach ($akuntransaction as $id =>$name)
              @if ($name == $transactionname->name)
              {
<option selected="" value="{{ $id }}">{{ $name }}</option>
              }
              @else
              {
<option value="{{ $id }}">{{ $name }}</option>
              }
              @endif


              
              @endforeach
            </select>
            <button type="submit" class="float-right btn bg-primary btn-sm"> Add New jurnal  </button>
          </form>
        </div>
      </div>

  --}}



    </div>
    <p class="text-center text-uppercase p-2 "><strong>{{ $transactionname->name}}</strong> </p>
    <form role="form" method="post" action="/jurnal/cstore">
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
     {{--                   @if (( $transactionname->name == "bayar utang") OR ($transactionname->name == "dibayar piutang"))

      <select  name="reff" id="reff" class="form-control">

        @foreach ($utang as $utang)
        @php
        $result =($utang->kredit) - ($utang->debet);
        @endphp
        @if ($result !=0)
        {
        <option value="{{ $utang->reff }}">{{ $utang->description}}  (Remaining  :  Rp.{{ number_format(abs(($utang->kredit) - ($utang->debet)), 0, ',', '.') }} ) </option>
}
@endif


        @endforeach
      </select>

      @else 

      @endif --}}
                </div>

        <div class="form-group col-md-6">
         <label for="location">AKUN : {{-- {{ $transactionname->debet}} --}} </label>


         <select name="akun" id="akun" class="form-control">

          @foreach ($akun as $akun)
          <option value="{{ $akun->id }}" > {{$akun->type}} | {{  $akun->name }}</option>
          @endforeach
        </select>

      </div>
        <div class="form-group col-md-6">
          <input type="hidden" name="type" value="{{$transactionname->name}}">
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
  <button type="submit" class="btn btn-primary">Submit</button>
  <a href="{{url('jurnal')}}" class="btn btn-default float-right">Cancel</a>
</div>

      </div>
      <!-- /.card-body -->


    </form>
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

     <form role="form" method="post" action="/jurnal/cupdate">
      @csrf
    @foreach( $cjurnal as $cjurnal)
    <tr>
      <th scope="row">{{ $loop->iteration }}</th>
       <td>{{ $cjurnal->id }}</td>
      <td>{{ $cjurnal->date }}</td>
      <td>{{ $cjurnal->akun_name->name }}</td>
      <td>{{ number_format($cjurnal->debet, 0, ',', '.') }}</td>
      <td>{{ number_format($cjurnal->kredit, 0, ',', '.') }}</td>
      <td>{{ $cjurnal->reff }}</td>
      <td>{{ $cjurnal->description }}</td>
      @php
$debet =$debet + $cjurnal->debet;
$kredit =$kredit + $cjurnal->kredit;
@endphp


    </tr>
     <input type="hidden" name="jcustomid[]" value={{ $cjurnal->id }}>
    @endforeach
    <tr class="bg-primary">
      <td colspan="4"><strong>Total : </strong></td>
      <td colspan=""><strong>{{number_format($debet, 0, ',', '.')}}</strong></td>
      <td colspan=""><strong>{{number_format($kredit, 0, ',', '.')}}</strong></td>

        <td colspan="2"><strong> <button type="submit" class="btn btn-success">Submit</button> </strong></td>

   
    </tr>
   
  </form>
    
  </tbody>
</table>

</div>
  <!-- /.card -->

  <!-- Form Element sizes -->


</div>

<!-- /.modal -->
</section>

@endsection