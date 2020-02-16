@extends('layouts.punk')

@php
$request = app('request');
$ids = [];
@endphp

@section('content')
<div class="container">
  @if(auth()->user()->role == 'admin')
  <div class="row justify-content-center">
      <div class="col-md-10">
          <div class="card">
              <div class="card-header">Payments Report</div>

              <div class="card-body">
                  <form method="get" action="{{ route('punk.paymentview') }}">
                    <div class="form-group row">
                        <label for="shift" class="col-md-4 col-form-label text-md-right">Range Date</label>

                        <div class="col-md-3">
                        <input type="date" name="from" value="{{ $request->from }}" class="form-control">
                        </div>
                        <span class="p-2"> TO </span>
                        <div class="col-md-3">
                        <input type="date" name="to" value="{{ $request->to }}" class="form-control">
                        </div>
                    </div>
                          <div class="form-group inline-block row">
                          <label for="fuel" class="col-md-4 col-form-label text-md-right">
                            FUEL
                          </label>
                          <div class="col-md-6 p-2">

                              <div class="form-check form-check-inline">
                                <input class="form-check-input" {{ $request->fuel == 'petrol' ? 'checked' : '' }}  type="radio" name="fuel" id="petrol" value="petrol">
                                <label class="form-check-label" for="petrol">Cash</label>
                              </div>
                              <div class="form-check form-check-inline">
                                <input class="form-check-input" {{ $request->fuel == 'diesel' ? 'checked' : '' }}  type="radio" name="fuel" id="diesel" value="diesel">
                                <label class="form-check-label" for="diesel">Diesel</label>
                              </div>
                              <div class="form-check form-check-inline">
                                <input class="form-check-input" {{ $request->fuel == 'speed' ? 'checked' : '' }}  type="radio" name="fuel" id="speed" value="speed">
                                <label class="form-check-label" for="speed">Speed</label>
                              </div>
                              <div class="form-check form-check-inline">
                                <input class="form-check-input" {{ $request->fuel == 'all' ? 'checked' : '' }}  type="radio" name="fuel" id="all" value="all">
                                <label class="form-check-label" for="all">All</label>
                              </div>

                          </div>
                      </div>

                          <div class="form-group inline-block row">
                          <label for="fuel" class="col-md-4 col-form-label text-md-right">
                            Payment
                          </label>
                          <div class="col-md-6 p-2">
                            <select class="custom-select" name="payment" id="payment" required>
                             <option selected disabled value="">Choose...</option>
                             <option value="paytm" {{ $request->payment == 'paytm' ? 'checked' : '' }}>PayTM</option>
                             <option value="cash" {{ $request->payment == 'cash' ? 'checked' : '' }}>Cash</option>
                             <option value="checque" {{ $request->payment == 'checque' ? 'checked' : '' }}>Checque</option>
                             <option value="card" {{ $request->payment == 'card' ? 'checked' : '' }}>Card</option>
                             <option value="all" {{ $request->payment == 'all' ? 'checked' : '' }}>All</option>
                           </select>

                          </div>
                      </div>

                        <div class="form-group row mb-0">
                          <div class="col-md-6 offset-md-4">
                              <button type="submit" class="btn btn-primary">
                                View
                              </button>
                            </div>
                      </div>

                  </form>

              </div>
              @if(!empty($payments ?? ''))
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Date</th>
                    <th> Fuel </th>
                    <th scope="col">Pay Method</th>
                    <th scope="col">In Amount</th>
                    <th scope="col">Out Amount</th>
                    <th scope="col">Balance Amount</th>
                     <th scope="col">Comments</th>
                     <th scope="col">updated By</th>
                  </tr>
                </thead>
                <tbody>

                  @forelse($payments ?? '' as $key => $payment)
                   <tr>
                     @php
                     array_push($ids, $payment->id);
                     @endphp
                    <th scope="row">{{ $key + 1 }}</th>
                    <td>{{ $payment->created_at }}</td>
                    <td>{{ ucfirst($payment->fuel) }}</td>
                    <td>{{ $payment->type }}</td>
                    <td>{{ $payment->in_amount }}</td>
                    <td>{{ $payment->out_amount }}</td>
                    <td>{{ $payment->bal_amt }}</td>
                    <td>{{ $payment->comment }}</td>
                    <td>{{ ucfirst($payment->user->name) }}</td>
                  </tr>
                  @empty
                  <tr>
                    <td class="text-center" colspan="10"> No Data Available </td>
                  </tr>
                  @endforelse
                </tbody>
              </table>
              @endif

              @if(!empty($payments ?? ''))

              <div class="text-center pb-3">
                  <a href="{{ route('punk.tcpdfFuel', ['print' => $ids]) }}" class="btn btn-danger">
                    Report
                  </a>
                </div>

              @endif
          </div>
      </div>
  </div>

 @else

    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Payment Method
                  <a href="#" data-target=".showpayment" data-toggle="modal" class=" float-right btn btn-danger btn-sm">View Payment Details</a>

                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('punk.paymentstore') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Payment Method</label>

                            <div class="col-md-6">
                              <select class="custom-select" name="payment" id="payment" required>
                               <option selected disabled value="">Choose...</option>
                               <option value="paytm">PayTM</option>
                               <option value="cash">Cash</option>
                               <option value="checque">Checque</option>
                               <option value="card">Card</option>
                             </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="fuel" class="col-md-4 col-form-label text-md-right">
                              FUEL
                            </label>
                            <div class="col-md-6 p-3">

                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" required checked type="radio" name="fuel" id="petrol" value="petrol">
                                  <label class="form-check-label" for="petrol">Petrol</label>
                                </div>
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" required type="radio" name="fuel" id="diesel" value="diesel">
                                  <label class="form-check-label" for="diesel">Diesel</label>
                                </div>
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" required type="radio" name="fuel" id="speed" value="speed">
                                  <label class="form-check-label" for="speed">Speed</label>
                                </div>

                            @error('fuel')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="price" class="col-md-4 col-form-label text-md-right">In Amount</label>
                            <div class="col-md-6">
                                <input id="in_amount" type="text" required class="form-control @error('in_amount') is-invalid @enderror" name="in_amount">

                                @error('in_amount')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="price" class="col-md-4 col-form-label text-md-right">Out Amount</label>
                            <div class="col-md-6">
                                <input id="out_amount" type="text" required class="form-control @error('out_amount') is-invalid @enderror" name="out_amount">

                                @error('out_amount')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="comment" class="col-md-4 col-form-label text-md-right">Comment in out Amount</label>
                            <div class="col-md-6">
                                <textarea id="comment" type="text" placeholder="(Optional)..." class="form-control @error('comment') is-invalid @enderror" name="comment"></textarea>

                                @error('comment')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="bal_amt" class="col-md-4 col-form-label text-md-right">Today Balance Amount</label>
                            <label id="today_bal_amt" class="col-md-6 col-form-label ">0</label>
                            <input id="bal_amt" type="hidden" name="bal_amt" required class="form-control disabled @error('bal_amt') is-invalid @enderror">

                        </div>


                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                  Add Payment
                                </button>
                            </div>
                        </div>
                    </form>

                    @if (session('status'))
                    <div class="alert alert-success alert-dismissible hide show mt-3" role="alert">
                      Hello! <strong>{{ ucfirst(auth()->user()->name) }}</strong> Your Payment Detail has been updated...
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>

                  @endif
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade showpayment" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
 <div class="modal-dialog modal-lg">
   <div class="modal-content">
     <div class="modal-header">
       <h5 class="modal-title">Fuel Details</h5>
       <button type="button" class="close" data-dismiss="modal" aria-label="Close">
         <span aria-hidden="true">&times;</span>
       </button>
     </div>
     <table class="table table-striped">
       <thead>
         <tr>
           <th scope="col">#</th>
           <th scope="col">Date</th>
           <th> Fuel </th>
           <th scope="col">Pay Method</th>
           <th scope="col">In Amount</th>
           <th scope="col">Out Amount</th>
           <th scope="col">Balance Amount</th>
           <th scope="col">Comments</th>
         </tr>
       </thead>
       <tbody>

         @forelse(optional(auth()->user())->payments ?? '' as $key => $payment)
          <tr>

           <th scope="row">{{ $key + 1 }}</th>
           <td>{{ $payment->created_at }}</td>
           <td>{{ ucfirst($payment->fuel) }}</td>
           <td>{{ $payment->type }}</td>
           <td>{{ $payment->in_amount }}</td>
           <td>{{ $payment->out_amount }}</td>
           <td>{{ $payment->bal_amt }}</td>
           <td>{{ $payment->comment }}</td>
         </tr>
         @empty
         <tr>
           <td class="text-center" colspan="8"> No Data Available </td>
         </tr>
         @endforelse
       </tbody>
     </table>

   </div>
 </div>
</div>
    @endif
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function(){

  $('#in_amount, #out_amount').keyup(function(){
    var out_amt = $('#out_amount').val();
    var in_amt = $('#in_amount').val();
    $('#bal_amt').val(parseInt(in_amt) - parseInt(out_amt));
    $('#today_bal_amt').text(parseInt(in_amt) - parseInt(out_amt));
  });
});

</script>
@endpush
