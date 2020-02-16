@extends('layouts.punk')

@section('content')

@php
$request = app('request');
$ids = [];
@endphp
<div class="container">
  @if(auth()->user()->role == 'admin')
  <div class="row justify-content-center">
      <div class="col-md-10">
          <div class="card">
              <div class="card-header">FUEL REPORT</div>

              <div class="card-body">
                  <form method="get" action="{{ route('punk.fuelview') }}">
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
                                <label class="form-check-label" for="petrol">Petrol</label>
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

                        <div class="form-group row mb-0">
                          <div class="col-md-6 offset-md-4">
                              <button type="submit" class="btn btn-primary">
                                View
                              </button>
                            </div>
                      </div>

                  </form>

              </div>
              @if(!empty($fuels))
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Tank</th>
                    <th scope="col">Shift</th>
                    <th scope="col">Fuel</th>
                    <th scope="col">Day Price</th>
                    <th scope="col">Reading Price</th>
                    <th scope="col">Total</th>
                    <th scope="col">updated By</th>
                    <th scope="col">Fuels At</th>
                  </tr>
                </thead>
                <tbody>

                  @forelse($fuels as $key => $fuel)
                   <tr>
                     @php
                     array_push($ids, $fuel->id);
                     @endphp
                    <th scope="row">{{ $key + 1 }}</th>
                    <td>{{ ucfirst($fuel->tank) }}</td>
                    <td>{{ ucfirst(str_replace('_', ' ', $fuel->shift)) }}</td>
                    <td>{{ ucfirst($fuel->fuel) }}</td>
                    <td>{{ $fuel->price }}</td>
                    <td>{{ $fuel->read_value }}</td>
                    <td>{{ $fuel->total_amt }}</td>
                    <td>{{ ucfirst($fuel->user->name) }}</td>
                    <td>{{ $fuel->created }}</td>
                  </tr>
                  @empty
                  <tr>
                    <td class="text-center" colspan="8"> No Data Available </td>
                  </tr>
                  @endforelse
                </tbody>
              </table>
              @endif

              @if(!empty($fuels))

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
                 <div class="card-header">FUEL
<a href="#" data-target=".showfuel" data-toggle="modal" class=" float-right btn btn-danger btn-sm">View Fuel Details</a>
                 </div>

                 <div class="card-body">
                     <form method="POST" action="{{ route('punk.fuelstore') }}">
                         @csrf

                         <div class="form-group row">
                             <label for="tank" class="col-md-4 col-form-label text-md-right">Tank</label>

                             <div class="col-md-6">
                               <select class="custom-select" name="tank" id="tank" required>
                                <option selected disabled value="">Choose...</option>
                                <option value="a1">Tank A1</option>
                                <option value="a2">Tank A2</option>
                                <option value="b1">Tank B1</option>
                                <option value="b2">Tank B2</option>
                              </select>
                             </div>
                         </div>

                         <div class="form-group row">
                             <label for="shift" class="col-md-4 col-form-label text-md-right">Shift</label>

                             <div class="col-md-6">
                               <select class="custom-select" name="shift" id="shift" required>
                                <option selected disabled value="">Choose...</option>
                                <option value="shift_1">Shift 1</option>
                                <option value="shift_2">Shift 2</option>
                                <option value="shift_3">Shift 3</option>
                                <option value="shift_4">Shift 4</option>
                              </select>
                             </div>
                         </div>

                         <div class="form-group row">
                             <label for="shit_time" class="col-md-4 col-form-label text-md-right">Shift Timing</label>

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
                             <label for="from_hr" class="col-md-4 col-form-label text-md-right">Custom Timing</label>

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

                         <div class="form-group inline-block row">
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
                             <label for="price" class="col-md-4 col-form-label text-md-right">Today Price</label>
                             <div class="col-md-6">
                                 <input id="price" type="text" required class="form-control @error('price') is-invalid @enderror" name="price">

                                 @error('price')
                                     <span class="invalid-feedback" role="alert">
                                         <strong>{{ $message }}</strong>
                                     </span>
                                 @enderror
                             </div>
                         </div>

                         <div class="form-group row">
                             <label for="reading_value" class="col-md-4 col-form-label text-md-right">Today Reading Value</label>
                             <div class="col-md-6">
                                 <input id="reading_value" type="text" required class="form-control @error('reading_value') is-invalid @enderror" name="reading_value">

                                 @error('reading_value')
                                     <span class="invalid-feedback" role="alert">
                                         <strong>{{ $message }}</strong>
                                     </span>
                                 @enderror
                             </div>
                         </div>

                           <div class="form-group row">
                               <label for="total_amt" class="col-md-4 col-form-label text-md-right">Today Balance Amount</label>
                               <label id="total_amt" class="col-md-6 col-form-label ">0</label>
                               <input id="total_bal_amt" type="hidden" name="total_amt" required class="form-control">

                           </div>


                         <div class="form-group row mb-0">
                             <div class="col-md-6 offset-md-4">
                                 <button type="submit" class="btn btn-primary">
                                   Save
                                 </button>
                             </div>
                         </div>
                     </form>

                     @if (session('status'))
                     <div class="alert alert-success alert-dismissible hide show mt-3" role="alert">
                       Hello! <strong>{{ ucfirst(auth()->user()->name) }}</strong> Your Fuel Detail has been updated...
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                         <span aria-hidden="true">&times;</span>
                       </button>
                     </div>

                   @endif
                 </div>
             </div>
         </div>
     </div>
     <div class="modal fade showfuel" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
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
            <th scope="col">Tank</th>
            <th scope="col">Shift</th>
            <th scope="col">Fuel</th>
            <th scope="col">Day Price</th>
            <th scope="col">Reading Price</th>
            <th scope="col">Total</th>
            <th scope="col">Fuels At</th>
          </tr>
        </thead>
        <tbody>

          @forelse(optional(auth()->user())->fuels() as $key => $fuel)
           <tr>

            <th scope="row">{{ $key + 1 }}</th>
            <td>{{ ucfirst($fuel->tank) }}</td>
            <td>{{ ucfirst($fuel->shift) }}</td>
            <td>{{ ucfirst($fuel->fuel) }}</td>
            <td>{{ $fuel->price }}</td>
            <td>{{ $fuel->read_value }}</td>
            <td>{{ $fuel->total_amt }}</td>
            <td>{{ $fuel->created }}</td>
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

  $('#reading_value, #price').keyup(function(){
    var price = $('#price').val();
    var value = $('#reading_value').val();
    $('#total_amt').text(parseFloat(price) * parseFloat(value));
    $('#total_bal_amt').val(parseFloat(price) * parseFloat(value));
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
});

</script>
@endpush
