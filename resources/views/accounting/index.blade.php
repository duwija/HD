@extends('layout.main')
@section('title','Customer accounting List')
@section('content')
<section class="content-header">

  <div class="card card-primary card-outline">
              <div class="card-header">
                <h3 class="card-title"> <b>{{--  {{ $customeraccounting->id}} ({{ $customerdevice->name}})  --}}</b>  Device List  </h3>
                 <button type="button" class="float-right btn btn-sm bg-gradient-primary" data-toggle="modal" data-target="#modal-add-trx">Add New Client Device</button>
                <a href="/customer/{{-- {{$customerdevice->id}} --}}" class=" float-right btn btn-sm  bg-gradient-secondary btn-sm mr-3"> Back</a>
              </div>
              
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">

  <thead >
    <tr>
      <th scope="col">#</th>
      <th scope="col">Date</th>
       <th scope="col">ID</th>
      <th scope="col">Category</th>
      <th scope="col">Income</th>
      <th scope="col">Expense</th>
      <th scope="col">A Payable</th>
      <th scope="col">A Recievable</th>
      <th scope="col">Note</th>
      <th scope="col">Create By</th>
     

      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
    @php
    $income_sum=0;
    $expense_sum=0;
    @endphp
  	@foreach( $accounting as $accounting)

     @php
    $income_sum= $income_sum + $accounting->income;
    $expense_sum= $expense_sum + $accounting->expense ;
    @endphp
    <tr>
      <th scope="row">{{ $loop->iteration }}</th>
      <td>{{ $accounting->date }}</td>

    <td>{{ $accounting->id }}</td>
      <td>{{ $accounting->category->name }}</td>
      <td>{{ $accounting->income }}</td>
      <td>{{ $accounting->expense }}</td>
      <td>{{ $accounting->account_payable }}</td>
      <td>{{ $accounting->account_recievable }}</td>
      
      

      <td>{{ $accounting->note }}</td>
      

      <td>{{ $accounting->created_by }}</td>
   {{--    <td>{{ $plan->price }}</td>
      <td>{{ $plan->description }}</td> --}}
      <td >
        <div class="" >
        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-detail{{ $accounting->id }}">Edit </button>
       
        <form  action="/accounting/{{ $accounting->id }}/{{ $accounting->id }}" method="POST" class="d-inline distpoint-delete" >
                    @method('delete')
                    @csrf
                    
                      <button type="submit"  class="btn btn-danger btn-sm"> Delete </button>
                  </form>
        
      </div>
      </td>
    </tr>
   @endforeach
    <tr class="bg-primary">
      <td colspan="3">Total : </td>
      <td colspan="">{{  number_format($income_sum,0,',','.')}}</td>
      <td>{{   number_format($expense_sum,0,',','.') }}</td>
    </tr>


<table id="example1" class="table table-bordered table-striped">


@foreach( $ladger as $ledger)
 <tr>
      <td colspan="3">Total : </td>
      <td colspan="">{{ $ledger->category->name }}</td>
      <td><strong>{{ number_format($ledger->income,0,',','.') }}</strong></td>
      <td><strong>{{ number_format($ledger->expense,0,',','.') }}</strong></td>
    </tr>
@endforeach
</table>
       <div class="modal fade" id="modal-detail{{-- {{ $device->id }} --}}">
        <div class="modal-dialog modal-lg card card-outline ">
          <div class="modal-content">
            <div class="card-header bg-dark ">
             <h5 class="modal-title">Edit category : {{ $accounting->category->id }} ({{  $accounting->category->name }}) </h5> 
              
              
            </div>
            <div class="modal-body ">

             
              <div class="container  ">

 <form role="form" action="/device/{{ $accounting->id }}" method="POST">
      @method('patch')
      @csrf

  <div class="card-body row col-md-12">
                  <div class="form-group col-md-6 ">
                    <input type="hidden" name="id_customer" value="{{$accounting->id_customer }}">
                    <label for="nama">Name</label>
                    <input type="text"  class="form-control  @error('name') is-invalid @enderror" name="name"  id="name" placeholder="accounting Name"  value="{{$accounting->name }}">
                  </div>
                  <div class="form-group col-md-6  ">
                    <label for="parrent">Parent </label>
                   <select name="parrent" id="parrent" class="form-control">
                  <option value="">none</option>
               {{--    @foreach ($accountinglist as $id => $name)
                   @if ($id == $accounting->parrent )
              {

                <option selected value="{{ $id }}">{{ $name }}</option>
              }
              @else
              {
                <option value="{{ $id }}">{{ $name }}</option>
              }
              @endif

                  
                  @endforeach --}}
                </select>
                  </div>
                  <div class="form-group col-md-6 ">
                    <label for="ip">Ip  </label>
                     <input type="text"   class="form-control  @error('ip') is-invalid @enderror" name="ip"  id="ip" placeher="accounting ip"   value="{{$accounting->ip}}">
                  </div>
                  <div class="form-group col-md-6 ">
                    <label for="type">type  </label>
                     <input type="text" class="form-control  @error('type') is-invalid @enderror" name="type"  id="type" placeher="accounting type"  value="{{$accounting->type }}">
                  </div>
                  <div class="form-group col-md-6 ">
                    <label for="sn">SN  </label>
                     <input type="text" class="form-control  @error('sn') is-invalid @enderror" name="sn"  id="sn" placeher="accounting sn"  value="{{$accounting->sn }}">
                  </div>
                   <div class="form-group col-md-6 ">
                    <label for="owner">Owner </label>
                    <select name="owner" id="owner" class="form-control select2 @error('owner') is-invalid @enderror"">
                     @if ($accounting->owner == 'Ours accounting' )
              {

                
                 <option selected value="Ours accounting">Ours accounting</option>
                  <option  value="Customer accounting"> Customer accounting </option>
              }
              @else
              {
               
                 <option  value="Ours accounting">Ours accounting</option>
                 <option selected  value="Customer accounting"> Customer accounting </option>
                   
              }
              @endif
            </select>
                  </div>
                   <div class="form-group col-md-12 ">
                    <label for="position">Position  </label>
                     <input type="text" class="form-control  @error('position') is-invalid @enderror" name="position"  id="position" placeher="accounting position"    value="{{ $accounting->position  }}">
                  </div>
                   <div class="form-group col-md-12 ">
                    <label for="note">note  </label>
                     <input type="text" class="form-control  @error('note') is-invalid @enderror" name="note"  id="note" placeher="accounting note"  value="{{ $accounting->note  }}">
                  </div>
                  
                </div> 
</div> 

              </div>
  
                  

           
            <div class="modal-footer justify-content-between float-right">
             <button type="submit" class="btn btn-primary">Submit</button>
              <button type="button" class="btn btn-primary float-right " data-dismiss="modal">Close</button>

              </form>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->



    </tr>



{{-- 
    @endforeach
 --}}


       <div class="modal fade" id="modal-add-trx">
        <div class="modal-dialog modal-lg card card-outline ">
          <div class="modal-content">
            <div class="card-header bg-dark ">
             <h5 class="modal-title">Add New Transaction {{-- {{ $customeraccounting->id}} ({{ $customeraccounting->name}} --}} </h5> 
              
              
            </div>
            <div class="modal-body ">

             
              <div class="container  ">

                <form role="form" method="post" action="/accounting">
      @csrf
  <div class="card-body row col-md-12">

                  <div class="form-group col-md-6 ">
                    <label for="sn">date </label>
                     <input type="text" name="date" id="date" class="form-control datetimepicker-input" data-target="#reservationdate" value="{{date('Y-m-d')}}" />
                  </div>
                   <div class="form-group col-md-6">
     </div>
                  <div class="form-group col-md-6 ">
                    <label for="type">type  </label>
                   <select name="type" id="type" class="form-control">
                  {{-- <option value="">none</option> --}}
                  <option value="expanse">expense</option>
                  <option value="income">income</option>
                  <option value="account_payable">A Payable</option>
                  <option value="account_recievable">A Recievable</option>
                  
                 
                 
                </select>
                  </div> 
                  <div class="form-group col-md-6  ">
                    <label for="parrent">category </label>
                    <select name="category" id="category" class="form-control">
                  {{-- <option value="">none</option> --}}
                  @foreach ($acccategory as $id => $name)
                  <option value="{{ $id }}">{{ $name }}</option>
                  @endforeach
                </select>
                    {{-- <input type="text"   class="form-control  @error('parrent') is-invalid @enderror" name="parrent"  id="parrent" placeholder="accounting parent"  value="{{old('parrent')  }}"> --}}
                  </div>
                  
                  <div class="form-group col-md-12 ">
                    <label for="nama">Name / Note</label>
                    <input type="text"  class="form-control  @error('name') is-invalid @enderror" name="name"  id="name" placeholder="Transaction Name"  value="{{old ('name') }}">
                  </div>
                 
          
                   <div class="form-group col-md-12 ">
                    <label for="amount">amount  </label>
                     <input type="text" class="form-control  @error('amount') is-invalid @enderror" name="amount"  id="amount" placeholder=" amount"    value="{{ old('amount')  }}">
                  </div>
                               

                  <input type="hidden" name="id_customer" id="id_customer" value="{{-- {{$customeraccounting->id}} --}}">
                  
                  
                </div> 
</div> 
<div class="modal-footer justify-content-between ">
  <button type="submit" class="btn btn-primary">Submit</button>
   <button type="button" class="btn btn-primary float-right " data-dismiss="modal">Close</button>

</div>

</form>
              </div>
  
                  

           
           
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->






    
  </tbody>
</table>
</div>
</div>



         


</section>

@endsection
