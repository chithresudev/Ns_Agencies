@extends('layouts.punk')

@php
$request = app('request');
$ids = [];
@endphp

@section('content')
<div class="container">
  @if(auth()->user()->role == 'admin')
  <div class="row justify-content-center">
    <div class="col-md-12">

    @if (session('paymentstatus'))
    <div class="alert alert-success alert-dismissible hide show mt-3" role="alert">
      Hello! <strong>{{ ucfirst(auth()->user()->name) }}</strong> Payment Detail has been updated...
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
  @endif

      @if (session('removestatus'))
      <div class="alert alert-danger alert-dismissible hide show mt-3" role="alert">
        Hello! <strong>{{ ucfirst(auth()->user()->name) }}</strong> Payment Detail has been removed...
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    @endif

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
                          <!-- <div class="form-group inline-block row">
                          <label for="fuel" class="col-md-4 col-form-label text-md-right">
                            FUEL
                          </label>
                          <div class="col-md-6 p-2">

                              <div class="form-check form-check-inline">
                                <input class="form-check-input" required {{ $request->fuel == 'petrol' ? 'checked' : '' }}  type="radio" name="fuel" id="petrol" value="petrol">
                                <label class="form-check-label" for="petrol">Petrol</label>
                              </div>
                              <div class="form-check form-check-inline">
                                <input class="form-check-input" required {{ $request->fuel == 'diesel' ? 'checked' : '' }}  type="radio" name="fuel" id="diesel" value="diesel">
                                <label class="form-check-label" for="diesel">Diesel</label>
                              </div>
                              <div class="form-check form-check-inline">
                                <input class="form-check-input" required {{ $request->fuel == 'speed' ? 'checked' : '' }}  type="radio" name="fuel" id="speed" value="speed">
                                <label class="form-check-label" for="speed">Speed</label>
                              </div>
                              <div class="form-check form-check-inline">
                                <input class="form-check-input" required  {{ $request->fuel == 'all' || $request->fuel == ' ' ? 'checked' : '' }}  type="radio" name="fuel" id="all" value="all">
                                <label class="form-check-label" for="all">All</label>
                              </div>

                          </div>
                      </div> -->
                      <div class="form-group row">
                          <label for="tank" class="col-md-4 col-form-label text-md-right">MPD</label>
                          <div class="col-md-6">
                            <select class="custom-select @error('tank') is-invalid @enderror" name="tank" id="tank" required>
                             <option selected disabled value="">Choose...</option>
                             <option {{ $request->tank == 'a1' ? 'selected' : '' }} value="a1">MPD A1</option>
                             <option {{ $request->tank == 'a2' ? 'selected' : '' }} value="a2">MPD A2</option>
                             <option {{ $request->tank == 'b1' ? 'selected' : '' }} value="b1">MPD B1</option>
                             <option {{ $request->tank == 'b2' ? 'selected' : '' }} value="b2">MPD B2</option>
                             <option {{ $request->tank == 'all' ? 'selected' : '' }} value="all">MPD All</option>
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
                    <th scope="col">MPD</th>
                    <th> Shift </th>
                    <th scope="col">Shift Time</th>
                    <th scope="col">Fuel</th>
                    <th scope="col">Cash</th>
                    <th scope="col">Checque</th>
                    <th scope="col">Card</th>
                    <th scope="col">Paytm</th>
                    <th scope="col">Total</th>
                    <th scope="col">Comment</th>
                    <th scope="col">Updated By</th>
                    <th scope="col">Updated At</th>
                    <th scope="col">Pay Date</th>
                    <th scope="col"></th>
                  </tr>
                </thead>
                <tbody>

                  @forelse($payments ?? '' as $key => $payment)
                   <tr>
                     @php
                     array_push($ids, $payment->id);
                     @endphp

                      <th scope="row">{{ $key + 1 }}</th>
                      <td>{{ ucfirst($payment->tank )}}</td>
                      <td>{{ ucfirst(str_replace('_', ' ', $payment->shift)) }}</td>
                      <td>{{ str_replace('_', ' ', $payment->shift_time) }}</td>
                      <td>{{ ucfirst($payment->fuel)  }}</td>
                      <td>{{ $payment->cash  }}</td>
                      <td>{{ $payment->checque }}</td>
                      <td>{{ $payment->card }}</td>
                      <td>{{ $payment->paytm }}</td>
                      <td data-total="{{ $payment->bal_amt }}">{{ $payment->bal_amt }}</td>
                      <td>{{ $payment->comment }}</td>
                      <td>{{ ucfirst($payment->user->name ?? '') }}</td>
                      <td>{{ $payment->created }}</td>
                      <td>{{ $payment->insert }}</td>
                    <td>
                    <a href="#" data-toggle="modal" data-target=".editpayment_{{ $payment->id }}" class="btn btn-sm btn-info"><i class="fa fa-pencil"></i> </a>
                    <a href="{{ route('punk.remove' , ['module' => 'payment', 'payment_id' => $payment->id ]) }}" class="btn btn-sm btn-danger"><i class="fa fa-close"></i> </a>
                  </td>
                  </tr>
                  {{-- Edited Fules --}}
                  <div class="modal fade editpayment_{{ $payment->id }}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title">Edit Payments</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>

                    <form method="POST" action="{{ route('punk.paymentupdate', ['payment' => $payment]) }}">
                        @csrf

                        <div class="form-group row">
                            <label for="tank" class="col-md-4 col-form-label text-md-right text-info">Date</label>

                            <div class="col-md-6">
                              <input type="date" name="insert_date"  value="{{ $payment->insert_date }}" required class="form-control @error('insert_date') is-invalid @enderror">
                              @error('insert_date')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                           </div>

                        </div>

                        <div class="form-group row">
                            <label for="tank" class="col-md-4 col-form-label text-md-right text-info">Tank</label>
                            <div class="col-md-6">
                              <select class="custom-select @error('tank') is-invalid @enderror" name="tank" id="tank" required>
                               <option selected disabled value="">Choose...</option>
                               <option {{ $payment->tank == 'a1' ? 'selected' : '' }} value="a1">MPD A1</option>
                               <option {{ $payment->tank == 'a2' ? 'selected' : '' }} value="a2">MPD A2</option>
                               <option {{ $payment->tank == 'b1' ? 'selected' : '' }} value="b1">MPD B1</option>
                               <option {{ $payment->tank == 'b2' ? 'selected' : '' }} value="b2">MPD B2</option>
                             </select>
                             @error('tank')
                                 <span class="invalid-feedback" role="alert">
                                     <strong>{{ $message }}</strong>
                                 </span>
                             @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="shift" class="col-md-4 col-form-label text-md-right text-info">Shift</label>

                            <div class="col-md-6">
                              <select class="custom-select @error('shift') is-invalid @enderror" name="shift" id="shift" required>
                               <option selected disabled value="">Choose...</option>
                               <option {{ $payment->shift == 'shift_1' ? 'selected' : '' }} value="shift_1">Shift 1</option>
                               <option {{ $payment->shift == 'shift_2' ? 'selected' : '' }} value="shift_2">Shift 2</option>
                               <option {{ $payment->shift == 'shift_3' ? 'selected' : '' }} value="shift_3">Shift 3</option>
                               <option {{ $payment->shift == 'shift_4' ? 'selected' : '' }} value="shift_4">Shift 4</option>
                             </select>
                             @error('shift')
                                 <span class="invalid-feedback" role="alert">
                                     <strong>{{ $message }}</strong>
                                 </span>
                             @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="shit_time" class="col-md-4 col-form-label text-md-right text-info">Shift Timing</label>

                            <div class="col-md-6">
                              <select class="custom-select" name="shift_time" id="shift_time" required>
                               <option selected disabled value="">Choose...</option>
                               <option {{ $payment->shift_time == '9am_to_9pm' ? 'selected' : '' }} value="9am_to_9pm">9AM to 9PM</option>
                               <option {{ $payment->shift_time == '6am_to_2pm' ? 'selected' : '' }} value="6am_to_2pm">6AM to 2PM</option>
                               <option {{ $payment->shift_time == '2pm_to_9pm' ? 'selected' : '' }} value="2pm_to_9pm">2Pm to 9PM</option>
                               <option {{ $payment->shift_time == '9pm_to_6am' ? 'selected' : '' }} value="9pm_to_6am">9PM to 6AM</option>
                           </select>
                            </div>
                        </div>


                        <div class="form-group inline-block row">
                            <label for="fuel" class="col-md-4 col-form-label text-md-right text-info">
                              FUEL
                            </label>
                            <div class="col-md-6 p-3">

                                <div class="form-check form-check-inline d-none" id="petrol">
                                  <input class="form-check-input" required  type="radio" name="fuel" id="petrol" value="petrol">
                                  <label class="form-check-label" for="petrol">Petrol</label>
                                </div>
                                <div class="form-check form-check-inline d-none" id="diesel">
                                  <input class="form-check-input" required  type="radio" name="fuel" id="diesel" value="diesel">
                                  <label class="form-check-label" for="diesel">Diesel</label>
                                </div>
                                <div class="form-check form-check-inline d-none" id="speed">
                                  <input class="form-check-input" required  type="radio" name="fuel" id="speed" value="speed">
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
                            <label for="name" class="col-md-4 col-form-label text-md-right text-info">Payment Method </label>
                            <label for="name" class="col-md-6 col-form-label text-md-right"></label>
                        </div>

                        <div class="form-group row">
                            <label for="paytm" class="col-md-4 col-form-label text-md-right text-danger">PayTM</label>
                            <div class="col-md-3">
                                <input id="paytm_{{ $payment->id }}" type="text" required value="{{ $payment->paytm }}" class="form-control @error('paytm') is-invalid @enderror" name="paytm">
                                @error('paytm')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="cash" class="col-md-4 col-form-label text-md-right text-danger">Cash</label>
                            <div class="col-md-3">
                                <input id="cash_{{ $payment->id }}" type="text" required value="{{ $payment->cash }}" class="form-control @error('cash') is-invalid @enderror" name="cash">
                                @error('cash')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="checque" class="col-md-4 col-form-label text-md-right text-danger">Checque</label>
                            <div class="col-md-3">
                                <input id="checque_{{ $payment->id }}" type="text" required value="{{ $payment->checque }}" class="form-control @error('checque') is-invalid @enderror" name="checque">
                                @error('checque')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="card" class="col-md-4 col-form-label text-md-right text-danger">Card</label>
                            <div class="col-md-3">
                                <input id="card_{{ $payment->id }}" type="text" required value="{{ $payment->card }}" class="form-control @error('card') is-invalid @enderror" name="card">
                                @error('card')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                          <div class="form-group row">
                              <label for="total_amt" class="col-md-4 col-form-label text-md-right text-info">Today Balance Amount</label>
                              <label id="total_amt_{{ $payment->id }}" class="col-md-6 col-form-label ">{{ $payment->bal_amt }}</label>
                              <input id="total_bal_amt_{{ $payment->id }}" type="hidden" value="{{ $payment->bal_amt }}" name="bal_amt" required class="form-control">

                          </div>
                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-info">
                                  Update
                                </button>
                            </div>
                        </div>
                    </form>

                </div>
              </div>
              </div>
              </div>
            </div>

                  @empty
                  <tr>
                    <td class="text-center" colspan="15"> No Data Available </td>
                  </tr>
                  @endforelse
                </tbody>
              </table>
              @endif

              @if(!empty($payments ?? ''))
                  <h4 class="text-right pr-5">Grand Total : <strong id="grandTotal"></strong></h4>
              <div class="text-center pb-3">
                  <a href="{{ route('punk.tcpdfpayment', ['print' => $ids]) }}" class="btn btn-danger">
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

              @if (session('status'))
              <div class="alert alert-success alert-dismissible hide show mt-3" role="alert">
                Hello! <strong>{{ ucfirst(auth()->user()->name) }}</strong> Your Payment Detail has been updated...
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>

            @endif
            <div class="card">
                <div class="card-header">Payment Method
                  <a href="#" data-target=".showpayment" data-toggle="modal" class=" float-right btn btn-danger btn-sm">View Payment Details</a>

                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('punk.paymentstore') }}">
                        @csrf
                        <div class="form-group row">
                            <label for="tank" class="col-md-4 col-form-label text-md-right text-info">Date</label>

                            <div class="col-md-6">
                              <input type="date" name="insert_date" class="form-control @error('insert_date') is-invalid @enderror">
                              @error('insert_date')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                           </div>

                        </div>

                        <div class="form-group row">
                            <label for="tank" class="col-md-4 col-form-label text-md-right text-info">MPD</label>
                            <div class="col-md-6">
                              <select class="custom-select @error('tank') is-invalid @enderror" name="tank" id="tank" required>
                               <option selected disabled value="">Choose...</option>
                               <option value="a1">MPD A1</option>
                               <option value="a2">MPD A2</option>
                               <option value="b1">MPD B1</option>
                               <option value="b2">MPD B2</option>
                             </select>
                             @error('tank')
                                 <span class="invalid-feedback" role="alert">
                                     <strong>{{ $message }}</strong>
                                 </span>
                             @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="shift" class="col-md-4 col-form-label text-md-right text-info">Shift</label>

                            <div class="col-md-6">
                              <select class="custom-select @error('shift') is-invalid @enderror" name="shift" id="shift" required>
                               <option selected disabled value="">Choose...</option>
                               <option value="shift_1">Shift 1</option>
                               <option value="shift_2">Shift 2</option>
                               <option value="shift_3">Shift 3</option>
                               <option value="shift_4">Shift 4</option>
                             </select>
                             @error('shift')
                                 <span class="invalid-feedback" role="alert">
                                     <strong>{{ $message }}</strong>
                                 </span>
                             @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="shit_time" class="col-md-4 col-form-label text-md-right text-info">Shift Timing</label>

                            <div class="col-md-6">
                              <select class="custom-select" name="shift_time" id="shift_time" required>
                               <option selected disabled value="">Choose...</option>
                               <option value="9am_to_9pm">9AM to 9PM</option>
                               <option value="6am_to_2pm">6AM to 2PM</option>
                               <option value="2pm_to_9pm">2Pm to 9PM</option>
                               <option value="9pm_to_6am">9PM to 6AM</option>
                               <option value="custom_time">Custom Timing</option>
                             </select>
                            </div>
                        </div>

                        <div class="form-group row d-none" id="custom_time_show">
                            <label for="from_hr" class="col-md-4 col-form-label text-md-right text-danger">Custom Timing</label>

                            <div class="col-md-6">
                              <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                  <select class="custom-select rounded-left" name="from_hr" id="from_hr">
                                    <option disabled selected>Choose...</option>
                                    @for($i = 1; $i <=12; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                  </select>

                                <select class="custom-select" name="from_format" id="from_format">
                                  <option disabled selected>Choose...</option>
                                  <option value="am">AM</option>
                                  <option value="pm">PM</option>
                                </select>
                                 <span class="p-2"> TO </span>
                                <select class="custom-select" name="to_hr" id="to_hr">
                                  <option disabled selected>Choose...</option>
                                  @for($i = 1; $i <=12; $i++)
                                  <option value="{{ $i }}">{{ $i }}</option>
                                  @endfor
                                </select>
                                <select class="custom-select"  name="to_format" id="to_format">
                                  <option disabled selected>Choose...</option>
                                  <option value="am">AM</option>
                                  <option value="pm">PM</option>
                                </select>
                                  </div>
                              </div>
                            </div>
                        </div>
                        <div class="d-none" id="detailshow">

                        <div class="form-group inline-block row">
                            <label for="fuel" class="col-md-4 col-form-label text-md-right text-info">
                              FUEL
                            </label>
                            <div class="col-md-6 p-3">

                                <div class="form-check form-check-inline d-none" id="petrol">
                                  <input class="form-check-input" required  type="radio" name="fuel" id="petrol" value="petrol">
                                  <label class="form-check-label" for="petrol">Petrol</label>
                                </div>
                                <div class="form-check form-check-inline d-none" id="diesel">
                                  <input class="form-check-input" required  type="radio" name="fuel" id="diesel" value="diesel">
                                  <label class="form-check-label" for="diesel">Diesel</label>
                                </div>
                                <div class="form-check form-check-inline d-none" id="speed">
                                  <input class="form-check-input" required  type="radio" name="fuel" id="speed" value="speed">
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
                            <label for="name" class="col-md-4 col-form-label text-md-right text-info">Payment Method </label>
                            <label for="name" class="col-md-6 col-form-label text-md-right"></label>
                        </div>

                        <div class="form-group row">
                            <label for="paytm_" class="col-md-4 col-form-label text-md-right text-danger">PayTM</label>
                            <div class="col-md-3">
                                <input id="paytm_" type="text" required value="0" class="form-control @error('paytm') is-invalid @enderror" name="paytm">
                                @error('paytm')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="cash_" class="col-md-4 col-form-label text-md-right text-danger">Cash</label>
                            <div class="col-md-3">
                                <input id="cash_" type="text" required value="0" class="form-control @error('cash') is-invalid @enderror" name="cash">
                                @error('cash')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="checque_" class="col-md-4 col-form-label text-md-right text-danger">Checque</label>
                            <div class="col-md-3">
                                <input id="checque_" type="text" required value="0" class="form-control @error('checque') is-invalid @enderror" name="checque">
                                @error('checque')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="card_" class="col-md-4 col-form-label text-md-right text-danger">Card</label>
                            <div class="col-md-3">
                                <input id="card_" type="text" required value="0" class="form-control @error('card') is-invalid @enderror" name="card">
                                @error('card')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                    <div class="form-group row">
                        <label for="bal_amt" class="col-md-4 col-form-label text-md-right">Today Balance Amount</label>
                        <label id="total_amt_" class="col-md-6 col-form-label ">0</label>
                        <input id="total_bal_amt_" type="hidden" name="bal_amt" required class="form-control disabled">
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

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                  Add Payment
                                </button>
                            </div>
                        </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <div class="modal fade showpayment" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
 <div class="modal-dialog modal-lg" style="max-width:1220px">
   <div class="modal-content">
     <div class="modal-header">
       <h5 class="modal-title">Payment</h5>
       <button type="button" class="close" data-dismiss="modal" aria-label="Close">
         <span aria-hidden="true">&times;</span>
       </button>
     </div>
     <table class="table table-striped">
       <thead>
         <tr>
           <th scope="col">#</th>
           <th scope="col">MPD</th>
           <th> Shift </th>
           <th scope="col">Shift Time</th>
           <th scope="col">Fuel</th>
           <th scope="col">Cash</th>
           <th scope="col">Checque</th>
           <th scope="col">Card</th>
           <th scope="col">Paytm</th>
           <th scope="col">Total</th>
           <th scope="col">Comment</th>
           <th scope="col">Payment Date</th>
           <th scope="col">Updated At</th>
         </tr>
       </thead>
       <tbody>
         @forelse(optional(auth()->user())->payments ?? '' as $key => $payment)
          <tr>

           <th scope="row">{{ $key + 1 }}</th>
           <td>{{ ucfirst($payment->tank )}}</td>
           <td>{{ ucfirst(str_replace('_', ' ', $payment->shift)) }}</td>
           <td>{{ str_replace('_', ' ', $payment->shift_time) }}</td>
           <td>{{ ucfirst($payment->fuel)  }}</td>
           <td>{{ $payment->cash  }}</td>
           <td>{{ $payment->checque }}</td>
           <td>{{ $payment->card }}</td>
           <td>{{ $payment->paytm }}</td>
           <td>{{ $payment->bal_amt }}</td>
           <td>{{ $payment->comment }}</td>
           <td>{{ $payment->insert }}</td>
           <td>{{ $payment->created }}</td>
         </tr>
         @empty
         <tr>
           <td class="text-center" colspan="10"> No Data Available </td>
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

  $('[id^=cash_], [id^=paytm_], [id^=checque_], [id^=card_]').keyup(function(){
    var str = $(this).attr('id');
    var val = str.split('_').pop();
    var id = val == null ? '' : val;

    var cash = $('#cash_' + id).val();
    var paytm = $('#paytm_' + id).val();
    var checque = $('#checque_' + id).val();
    var card = $('#card_' + id).val();
    var sum = parseFloat(cash) + parseFloat(paytm) + parseFloat(checque) + parseFloat(card);
    var label = paytm + '+' + cash + '+' + checque + '+' + card  + '='  + sum;

    $('#total_amt_' + id).text(label);
    $('#total_bal_amt_' + id).val(sum);
  });

  $('#shift_time').change(function(){
    var time_value = $(this).val();
    if(time_value == 'custom_time') {
      $('#custom_time_show').removeClass('d-none');
      $('#from_hr, #from_format, #to_hr, #to_format').attr('required' , 'required');
    }
    else {
      $('#custom_time_show').addClass('d-none');
      $('#from_hr, #from_format, #to_hr, #to_format').removeAttr('required');
    }
  });

  $('#tank,#shift').change(function(){
    var tank = $('#tank').val();
    var shift = $('#shift').val();


     if(tank == 'a1' && (shift == 'shift_1' || shift == 'shift_3') || tank == 'b1' && (shift == 'shift_2' || shift == 'shift_4'))
     {
       $('#detailshow').removeClass('d-none');
       $('#petrol, #price_petrol').removeClass('d-none').find('input').attr('checked', 'checked');
       $('#diesel, #speed, #price_speed, #price_diesel').addClass('d-none').find('input').removeAttr('checked');
       $('#reading_value_,#total_bal_amt_').val('');
       $('#total_amt_').text(0);
       }

     if(tank == 'a2' && shift == 'shift_1' || tank == 'b2' && shift == 'shift_2')
     {
       $('#detailshow').removeClass('d-none');
       $('#diesel, #price_diesel').removeClass('d-none').find('input').attr('checked', 'checked');
       $('#petrol, #speed, #price_speed, #price_petrol').addClass('d-none').find('input').removeAttr('checked');
       $('#reading_value_,#total_bal_amt_').val('');
       $('#total_amt_').text(0);

     }

     if(tank == 'a2' && shift == 'shift_3' || tank == 'b2' && shift == 'shift_4')
     {
       $('#detailshow').removeClass('d-none');

       $('#speed, #price_speed').removeClass('d-none').find('input').attr('checked', 'checked');
       $('#diesel, #petrol, #price_diesel, #price_petrol').addClass('d-none').find('input').removeAttr('checked');
       $('#reading_value_,#total_bal_amt_').val('');
       $('#total_amt_').text(0);
     }

   });

  var grandTotal = 0;
  $('[data-total]').each(function(){
    var total = $(this).attr('data-total');
    grandTotal += Number(total);
  });
  $('#grandTotal').text(grandTotal);
});

</script>
@endpush
