@extends('layout.main')
@section('title','Add New Site')
@section('maps')

@endsection

@section('content')
<section class="content-header">

  <div class="card card-primary card-outline">
    <div class="card-header">
      <h3 class="card-title font-weight-bold"> Add New {{ $transactionname->name}} </h3>

       <div class="float-right">
                <div class="input-group ">
          <form role="form" method="post" action="/jurnal/create">
            @csrf
             <select style="border: 1px solid blue "  name="akuntransaction" id="akuntransaction" class="form-control-sm ">
         
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
            <button type="submit" class="float-right btn  bg-primary btn-sm"{{--  data-toggle="modal" data-target="#modal-jurnal" --}}> Add New jurnal  </button>
          </form>
        </div>
      </div>

 



    </div>
    <p class="text-center text-uppercase p-2 "><strong>{{ $transactionname->name}}</strong> </p>
    <form role="form" method="post" action="/jurnal/store">
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
                       @if (( $transactionname->name == "bayar utang") OR ($transactionname->name == "dibayar piutang"))

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

      @endif
                </div>

        <div class="form-group col-md-6">
         <label for="location">DEBET : {{ $transactionname->debet}} </label>


         <select name="debet" id="debet" class="form-control">

          @foreach ($akundebet as $akundebet)
          <option value="{{ $akundebet->id }}" > {{$akundebet->type}} | {{  $akundebet->name }}</option>
          @endforeach
        </select>
      </div>
        <div class="form-group col-md-6">
          <label for="coordinate">KREDIT : {{ $transactionname->kredit}} </label>
          <select name="kredit" id="kredit" class="form-control">

            @foreach ($akunkredit as $akunkredit)
            <option value="{{ $akunkredit->id }}" > {{$akunkredit->type}} | {{  $akunkredit->name }}</option>
            @endforeach
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

        <div class="card-footer col-md-12">
  <button type="submit" class="btn btn-primary">Submit</button></form>
  <a href="{{url('jurnal')}}" class="btn btn-default float-right ">Cancel</a>
</div>

      </div>
      <!-- /.card-body -->


    
  </div>
  <!-- /.card -->

  <!-- Form Element sizes -->


</div>

<!-- /.modal -->
</section>

@endsection