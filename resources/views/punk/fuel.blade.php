@extends('layouts.punk')

@section('content')

@php
$request = app('request');
$ids = [];
@endphp
<div class="container">
  @if(auth()->user()->role == 'admin')
  <div class="row justify-content-center">
      <div class="col-md-12">

        @if (session('updatestatus'))
        <div class="alert alert-success alert-dismissible hide show mt-3" role="alert">
          Hello! <strong>{{ ucfirst(auth()->user()->name) }}</strong> Fuel Detail has been updated...
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      @endif

        @if (session('removestatus'))
        <div class="alert alert-danger alert-dismissible hide show mt-3" role="alert">
          Hello! <strong>{{ ucfirst(auth()->user()->name) }}</strong> Fuel Detail has been removed...
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      @endif

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

                      <div class="form-group row">
                          <label for="mpd" class="col-md-4 col-form-label text-md-right">MPD</label>
                          <div class="col-md-6">
                            <select class="custom-select @error('mpd') is-invalid @enderror" name="mpd" id="mpd" required>
                             <option selected disabled value="">Choose...</option>
                             <option {{ $request->mpd == 'mpd1' ? 'selected' : '' }} value="mpd1">MPD 1</option>
                             <option {{ $request->mpd == 'mpd2' ? 'selected' : '' }} value="mpd2">MPD 2</option>
                             <option {{ $request->mpd == 'mpd3' ? 'selected' : '' }} value="mpd3">MPD 3</option>
                             <option {{ $request->mpd == 'mpd4' ? 'selected' : '' }} value="mpd4">MPD 4</option>
                             <option {{ $request->mpd == 'all' ? 'selected' : '' }} value="all">MPD All</option>
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

              @if(!empty($fuels ?? '' ?? ''))
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">MPD</th>
                    <th scope="col">Filler</th>
                    <th scope="col">Fuel</th>
                    <th scope="col">Day Price</th>
                    <th scope="col">Reading Price</th>
                    <th scope="col">Total</th>
                    <th scope="col">updated By</th>
                    <th scope="col">Fuel At</th>
                    <th scope="col">Updated At</th>
                    <th scope="col"></th>
                  </tr>
                </thead>
                <tbody>

                  @forelse($fuels ?? '' ?? '' as $key => $fuel)
                   <tr>
                     @php
                     array_push($ids, $fuel->id);
                     @endphp
                    <th scope="row">{{ $key + 1 }}</th>
                    <td class="text-uppercase">{{ ucfirst($fuel->mpd) }}</td>
                    <td class="text-uppercase">{{ ucfirst($fuel->filler) }}</td>
                    <td>{{ ucfirst($fuel->fuel) }}</td>
                    <td>{{ $fuel->price }}</td>
                    <td>{{ $fuel->read_value }}</td>
                    <td>{{ $fuel->total_amt }}</td>
                    <td>{{ ucfirst($fuel->user->name ?? '') }}</td>
                    <td>{{ $fuel->insert }}</td>
                    <td>{{ $fuel->created }}</td>
                    <td>
                    <a href="#" data-toggle="modal" data-target=".editfuel_{{ $fuel->id }}" class="btn btn-sm btn-info"><i class="fa fa-pencil"></i> </a>
                    <a href="{{ route('punk.remove' , ['module' => 'fuel', 'fuel_id' => $fuel->id ]) }}" class="btn btn-sm btn-danger"><i class="fa fa-close"></i> </a>
                  </td>
                  </tr>
                  {{-- Edited Fules --}}
                  <div class="modal fade editfuel_{{ $fuel->id }}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title">Edit Fuels</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>

                    <form method="POST" action="{{ route('punk.fuelupdate', ['fuel' => $fuel]) }}">
                        @csrf

                        <div class="form-group row">
                            <label for="tank" class="col-md-4 col-form-label text-md-right text-info">Date</label>

                            <div class="col-md-6">
                              <input type="date" name="insert_date"  value="{{ $fuel->insert_date }}" required class="form-control @error('insert_date') is-invalid @enderror">
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
                              <select class="custom-select @error('mpd') is-invalid @enderror" name="mpd" id="mpd" required>
                               <option selected disabled value="">Choose...</option>
                               <option {{ $fuel->mpd == 'mpd1' ? 'selected' : '' }} value="mpd1">MPD 1</option>
                               <option {{ $fuel->mpd == 'mpd2' ? 'selected' : '' }} value="mpd2">MPD 2</option>
                               <option {{ $fuel->mpd == 'mpd3' ? 'selected' : '' }} value="mpd3">MPD 3</option>
                               <option {{ $fuel->mpd == 'mpd4' ? 'selected' : '' }} value="mpd4">MPD 4</option>
                             </select>
                             @error('mpd')
                                 <span class="invalid-feedback" role="alert">
                                     <strong>{{ $message }}</strong>
                                 </span>
                             @enderror
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="tank" class="col-md-4 col-form-label text-md-right text-info">Filler</label>
                            <div class="col-md-6">
                              <select class="custom-select @error('filler') is-invalid @enderror" name="filler" id="filler" required>
                               <option selected disabled value="">Choose...</option>
                               <option {{ $fuel->filler == 'a1' ? 'selected' : '' }} value="a1">A1</option>
                               <option {{ $fuel->filler == 'a2' ? 'selected' : '' }} value="a2">A2</option>
                               <option {{ $fuel->filler == 'b1' ? 'selected' : '' }} value="b1">B1</option>
                               <option {{ $fuel->filler == 'b2' ? 'selected' : '' }} value="b2">B2</option>
                             </select>
                             @error('filler')
                                 <span class="invalid-feedback" role="alert">
                                     <strong>{{ $message }}</strong>
                                 </span>
                             @enderror
                            </div>
                        </div>


                        <div class="form-group inline-block row">
                            <label for="fuel" class="col-md-4 col-form-label text-md-right text-info">
                              FUEL
                            </label>
                            <div class="col-md-6 p-3">

                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" {{ $fuel->fuel == 'petrol' ? 'checked' : '' }} required  type="radio" name="fuel" id="petrol" value="petrol">
                                  <label class="form-check-label" for="petrol">Petrol</label>
                                </div>
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" {{ $fuel->fuel == 'diesel' ? 'checked' : '' }} required type="radio" name="fuel" id="diesel" value="diesel">
                                  <label class="form-check-label" for="diesel">Diesel</label>
                                </div>
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" {{ $fuel->fuel == 'speed' ? 'checked' : '' }} required type="radio" name="fuel" id="speed" value="speed">
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
                            <label for="price" class="col-md-4 col-form-label text-md-right text-info">Today Price</label>
                            <div class="col-md-6">
                                <input id="editpriceval_{{ $key + 1 }}" type="text" value="{{ $fuel->price }}" required class="form-control @error('price') is-invalid @enderror" name="price">

                                @error('price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="reading_value" class="col-md-4 col-form-label text-md-right text-info">Today Reading Value</label>
                            <div class="col-md-6">
                                <input id="editreading_value_{{ $key + 1 }}" type="text" value="{{ $fuel->read_value }}" required class="form-control @error('reading_value') is-invalid @enderror" name="reading_value">

                                @error('reading_value')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                          <div class="form-group row">
                              <label for="total_amt" class="col-md-4 col-form-label text-md-right text-info">Today Balance Amount</label>
                              <label id="total_amt_{{ $key + 1 }}" class="col-md-6 col-form-label ">{{ $fuel->total_amt }}</label>
                              <input id="total_bal_amt_{{ $key + 1 }}" type="hidden" value="{{ $fuel->total_amt }}" name="total_amt" required class="form-control">

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
                    <td class="text-center" colspan="10"> No Data Available </td>
                  </tr>
                  @endforelse
                </tbody>
              </table>
              @endif

              @if(!empty($fuels ?? '' ?? ''))

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

            @if (session('status'))
            <div class="alert alert-success alert-dismissible hide show mt-3" role="alert">
              Hello! <strong>{{ ucfirst(auth()->user()->name) }}</strong> Your Fuel Detail has been updated...
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>

          @endif
             <div class="card">
                 <div class="card-header">FUEL
                   <a href="#" data-target=".showfuel" data-toggle="modal" class=" float-right btn btn-danger btn-sm">View Fuel Details</a>
                 </div>

                 <div class="card-body">
                     <form method="POST" action="{{ route('punk.fuelstore') }}">
                         @csrf

                         <div class="form-group row">
                             <label for="tank" class="col-md-4 col-form-label text-md-right text-info">Date</label>

                             <div class="col-md-6">
                               <input type="date" id="date" value="{{ app('request')->date }}" name="insert_date" class="form-control @error('insert_date') is-invalid @enderror">
                               @error('insert_date')
                                   <span class="invalid-feedback" role="alert">
                                       <strong>{{ $message }}</strong>
                                   </span>
                               @enderror
                            </div>

                         </div>

                         <div class="form-group row">
                             <label for="mpd" class="col-md-4 col-form-label text-md-right text-info">MPD</label>
                             <div class="col-md-6">
                               <select class="custom-select @error('mpd') is-invalid @enderror" name="mpd" id="mpd" required>
                                <option selected disabled value="">Choose...</option>
                                <option {{ $request->mpd == 'mpd1' ? 'selected' : '' }} value="mpd1">MPD 1</option>
                                <option {{ $request->mpd == 'mpd2' ? 'selected' : '' }} value="mpd2">MPD 2</option>
                                <option {{ $request->mpd == 'mpd3' ? 'selected' : '' }} value="mpd3">MPD 3</option>
                                <option {{ $request->mpd == 'mpd4' ? 'selected' : '' }} value="mpd4">MPD 4</option>
                            </select>

                             </div>
                         </div>

                         <div class="form-group row">
                             <label for="filler" class="col-md-4 col-form-label text-md-right text-info">Filler</label>
                             <div class="col-md-6">
                               <select class="custom-select @error('filler') is-invalid @enderror" name="filler" id="filler" required>
                                <option selected disabled value="">Choose...</option>
                                <option value="a1">A1</option>
                                <option value="a2">A2</option>
                                <option value="b1">B1</option>
                                <option value="b2">B2</option>
                              </select>
                              @error('filler')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
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


                         <div class="form-group row ">
                             <label for="price" class="col-md-4 col-form-label text-md-right text-info">Today Price</label>
                             <div class="col-md-6 d-none" id="price_petrol">
                                 <input  disabled type="text" required class="form-control @error('price') is-invalid @enderror" value="{{ $today_price->petrol ?? 0 }}">
                                 <input id="priceval_petrol"  type="hidden" required class="form-control @error('price') is-invalid @enderror" value="{{ $today_price->petrol ?? 0 }}" name="price">

                                 @error('price')
                                     <span class="invalid-feedback" role="alert">
                                         <strong>{{ $message }}</strong>
                                     </span>
                                 @enderror
                             </div>

                             <div class="col-md-6 d-none" id="price_diesel">
                                 <input  disabled type="text" required class="form-control @error('price') is-invalid @enderror" value="{{ $today_price->diesel ?? 0 }}">
                                 <input id="priceval_diesel"  type="hidden" required class="form-control @error('price') is-invalid @enderror" value="{{ $today_price->diesel ?? 0 }}" name="price">

                                 @error('price')
                                     <span class="invalid-feedback" role="alert">
                                         <strong>{{ $message }}</strong>
                                     </span>
                                 @enderror
                             </div>

                             <div class="col-md-6 d-none" id="price_speed">
                                 <input  disabled type="text" required class="form-control @error('price') is-invalid @enderror" value="{{ $today_price->speed ?? 0 }}">
                                 <input id="priceval_speed"  type="hidden" required class="form-control @error('price') is-invalid @enderror" value="{{ $today_price->speed ?? 0 }}" name="price">

                                 @error('price')
                                     <span class="invalid-feedback" role="alert">
                                         <strong>{{ $message }}</strong>
                                     </span>
                                 @enderror
                             </div>
                             @if(!$today_price)
                             <div class="col-md-2">
                                 <a href="{{ route('punk.todayprice') }}" class="btn btn-sm btn-success">Add Price</a>
                             </div>
                             @endif

                         </div>

                         <div class="form-group row">
                             <label for="reading_value" class="col-md-4 col-form-label text-md-right text-info">Today Reading Value</label>
                             <div class="col-md-6">
                                 <input id="reading_value_" type="text" required class="form-control @error('reading_value') is-invalid @enderror" name="reading_value">

                                 @error('reading_value')
                                     <span class="invalid-feedback" role="alert">
                                         <strong>{{ $message }}</strong>
                                     </span>
                                 @enderror
                             </div>
                         </div>

                           <div class="form-group row">
                               <label for="total_amt" class="col-md-4 col-form-label text-md-right text-info">Today Balance Amount</label>
                               <label id="total_amt_" class="col-md-6 col-form-label ">0</label>
                               <input id="total_bal_amt_" type="hidden" name="total_amt" required class="form-control">

                           </div>


                         <div class="form-group row mb-0">
                             <div class="col-md-6 offset-md-4">
                                 <button type="submit" class="btn btn-primary">
                                   Save
                                 </button>
                             </div>
                         </div>
                         </div>
                     </form>

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
            <th scope="col">MPD</th>
            <th scope="col">Filler</th>
            <th scope="col">Fuel</th>
            <th scope="col">Day Price</th>
            <th scope="col">Reading Price</th>
            <th scope="col">Total</th>
            <th scope="col">Fuel Date</th>
            <th scope="col">Updated At</th>
          </tr>
        </thead>
        <tbody>

          @forelse(optional(auth()->user())->fuels ?? '' as $key => $fuel)
           <tr>

            <th scope="row">{{ $key + 1 }}</th>
            <td class="text-uppercase">{{ $fuel->mpd }}</td>
            <td>{{ ucfirst($fuel->filler) }}</td>
            <td>{{ ucfirst($fuel->fuel) }}</td>
            <td>{{ $fuel->price }}</td>
            <td>{{ $fuel->read_value }}</td>
            <td>{{ $fuel->total_amt }}</td>
            <td>{{ $fuel->insert }}</td>
            <td>{{ $fuel->created }}</td>
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
$(document).ready(function() {

  $('#mpd,#filler').change(function() {
    var mpd = $('#mpd').val();
    var filler = $('#filler').val();
    $('#diesel, #petrol, #speed, #price_petrol, #price_speed, #price_diesel').addClass('d-none').find('input').removeAttr('checked');

     if((mpd == 'mpd1' || mpd == 'mpd2' || mpd == 'mpd3' || mpd == 'mpd4') && (filler == 'a1' || filler == 'b1'))
     {
       $('#detailshow').removeClass('d-none');
       $('#petrol, #price_petrol').removeClass('d-none').find('input[type=radio]').attr('checked', 'checked');
       $('#petrol, #price_petrol').find('input[type=hidden]').removeAttr('disabled');
       $('#diesel, #speed, #price_speed, #price_diesel').addClass('d-none').find('input').removeAttr('checked');
       $('#diesel, #speed, #price_speed, #price_diesel').find('input[type=hidden]').attr('disabled', 'disabled');
       $('#reading_value_,#total_bal_amt_').val('');
       $('#total_amt_').text(0);
       }

    if((mpd == 'mpd1' || mpd == 'mpd2') && (filler == 'a2' || filler == 'b2'))
       {
       $('#detailshow').removeClass('d-none');
       $('#diesel, #price_diesel').removeClass('d-none').find('input[type=radio]').attr('checked', 'checked');
       $('#diesel, #price_diesel').find('input[type=hidden]').removeAttr('disabled');
       $('#petrol, #speed, #price_speed, #price_petrol').addClass('d-none').find('input[type=radio]').removeAttr('checked');
       $('#petrol, #speed, #price_speed, #price_petrol').find('input[type=hidden]').attr('disabled', 'disabled');
       $('#reading_value_,#total_bal_amt_').val('');
       $('#total_amt_').text(0);

     }

    if((mpd == 'mpd3' || mpd == 'mpd4') && (filler == 'a2' || filler == 'b2'))
       {
         $('#detailshow').removeClass('d-none');

         $('#speed, #price_speed').removeClass('d-none').find('input[type=radio]').attr('checked', 'checked');
         $('#speed, #price_speed').find('input[type=hidden]').removeAttr('disabled');
         $('#diesel, #petrol, #price_diesel, #price_petrol').addClass('d-none').find('input').removeAttr('checked');
         $('#diesel, #petrol, #price_diesel, #price_petrol').find('input[type=hidden]').attr('disabled', 'disabled');
         $('#reading_value_,#total_bal_amt_').val('');
         $('#total_amt_').text(0);

     }

   });


     $('[id^=reading_value_],[id^=priceval_]').keyup(function(key) {

       var checkedId = $('input[type=radio]:checked').attr('id');
       var price = $('#priceval_' + checkedId).val();

       var str = $(this).attr('id');
       var id = str.split('_').pop();

       var value = $('#reading_value_').val();
       $('#total_amt_' + id).text(parseFloat(price) * parseFloat(value));
       $('#total_bal_amt_' + id).val(parseFloat(price) * parseFloat(value));
     });


     $('[id^=editpriceval_]').each(function(key) {

       var str = $(this).attr('id');
       var id = str.split('_').pop();
       $('#editreading_value_' + id + ',#editpriceval_' + id).keyup(function() {
         var price = $('#editpriceval_' + id).val();

         var value = $('#editreading_value_' + id).val();
         $('#total_amt_' + id).text(parseFloat(price) * parseFloat(value));
         $('#total_bal_amt_' + id).val(parseFloat(price) * parseFloat(value));
       });
     });

$('#date').change(function(){
  var date = $('#date').val();
  window.location.href= '?date=' + date;
});

});
</script>
@endpush
