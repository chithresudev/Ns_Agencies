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

        @if (session('updatestatus'))
        <div class="alert alert-success alert-dismissible hide show mt-3" role="alert">
          Hello! <strong>{{ ucfirst(auth()->user()->name) }}</strong> stock Detail has been updated...
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      @endif

        @if (session('removestatus'))
        <div class="alert alert-danger alert-dismissible hide show mt-3" role="alert">
          Hello! <strong>{{ ucfirst(auth()->user()->name) }}</strong> stock Detail has been removed...
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      @endif
          <div class="card">
              <div class="card-header">Stock Report</div>

              <div class="card-body">
                  <form method="get" action="{{ route('punk.stockview') }}">
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
                                <input class="form-check-input" required checked {{ $request->fuel == 'all' ? 'checked' : '' }}  type="radio" name="fuel" id="all" value="all">
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
              @if(!empty($stocks))
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Fuel</th>
                    <th scope="col">In Stock</th>
                    <th scope="col">Out Stock</th>
                    <th scope="col">Balance Stock</th>
                    <th scope="col">Comments</th>

                    <th scope="col">Updated By</th>
                    <th scope="col">Updated At</th>
                    <th scope="col">Stock At</th>
                    <th scope="col"></th>
                  </tr>
                </thead>
                <tbody>

                  @forelse($stocks as $key => $stock)
                   <tr>
                     @php
                     array_push($ids, $stock->id);
                     @endphp
                    <th scope="row">{{ $key + 1 }}</th>
                    <td>{{ ucfirst($stock->fuel) }}</td>
                    <td>{{ $stock->in_stock }}</td>
                    <td>{{ $stock->out_stock }}</td>
                    <td>{{ $stock->bal_stock }}</td>
                    <td>{{ ucfirst($stock->user->name ?? '') }}</td>
                    <td>{{ $stock->comment }}</td>
                    <td>{{ $stock->insert }}</td>
                    <td>{{ $stock->created }}</td>
                  <td>

                  <a href="#" data-toggle="modal" data-target=".editstock_{{ $stock->id }}" class="btn btn-sm btn-info"><i class="fa fa-pencil"></i> </a>
                  <a href="{{ route('punk.remove' , ['module' => 'stock', 'stock_id' => $stock->id ]) }}" class="btn btn-sm btn-danger"><i class="fa fa-close"></i> </a>
                </td>
                </tr>
                {{-- Edited Fules --}}
                <div class="modal fade editstock_{{ $stock->id }}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Edit Stocks</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>

                  <form method="POST" action="{{ route('punk.stockupdate', ['stock' => $stock]) }}">
                      @csrf

                      <div class="form-group row">
                          <label for="tank" class="col-md-4 col-form-label text-md-right text-info">Date</label>

                          <div class="col-md-6">
                            <input type="date" name="insert_date"  value="{{ $stock->insert_date }}" required class="form-control @error('insert_date') is-invalid @enderror">
                            @error('insert_date')
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
                                <input class="form-check-input" {{ $stock->fuel == 'petrol' ? 'checked' : '' }} required  type="radio" name="fuel" id="petrol_{{ $stock->id }}" value="petrol">
                                <label class="form-check-label" for="petrol_{{ $stock->id }}">Petrol</label>
                              </div>
                              <div class="form-check form-check-inline">
                                <input class="form-check-input" {{ $stock->fuel == 'diesel' ? 'checked' : '' }} required type="radio" name="fuel" id="diesel_{{ $stock->id }}" value="diesel">
                                <label class="form-check-label" for="diesel_{{ $stock->id }}">Diesel</label>
                              </div>
                              <div class="form-check form-check-inline">
                                <input class="form-check-input" {{ $stock->fuel == 'speed' ? 'checked' : '' }} required type="radio" name="fuel" id="speed_{{ $stock->id }}" value="speed">
                                <label class="form-check-label" for="speed_{{ $stock->id }}">Speed</label>
                              </div>

                          @error('fuel')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror

                          </div>
                      </div>

                      <div class="form-group row">
                          <label for="in_stock_{{ $stock->id }}" class="col-md-4 col-form-label text-md-right text-info">In Stock</label>
                          <div class="col-md-6">
                              <input id="in_stock_{{ $stock->id }}" type="text" value="{{ $stock->in_stock }}" required class="form-control @error('in_stock') is-invalid @enderror" name="in_stock">

                              @error('in_stock')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                          </div>
                      </div>
                      <div class="form-group row">
                          <label for="out_stock_{{ $stock->id }}" class="col-md-4 col-form-label text-md-right text-info">Out Stock</label>
                          <div class="col-md-6">
                              <input id="out_stock_{{ $stock->id }}" type="text" value="{{ $stock->out_stock }}" required class="form-control @error('out_stock') is-invalid @enderror" name="out_stock">

                              @error('out_stock')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                          </div>
                      </div>

                      <div class="form-group row">
                          <label for="comment" class="col-md-4 col-form-label text-md-right text-info">Any Comments</label>
                          <div class="col-md-6">
                              <textarea id="comment" type="text" placeholder="(Optional)..." class="form-control @error('comment') is-invalid @enderror" name="comment">
                                {{ $stock->comment }}
                              </textarea>

                              @error('comment')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                          </div>
                      </div>
                        <div class="form-group row">
                            <label for="total_amt_{{ $stock->id }}" class="col-md-4 col-form-label text-md-right text-info">Balance Stock</label>
                            <label id="total_bal_stock_{{ $stock->id }}" class="col-md-6 col-form-label ">{{ $stock->bal_stock }}</label>
                            <input id="bal_stock_{{ $stock->id }}" type="hidden" value="{{ $stock->bal_stock }}" name="bal_stock" required class="form-control">

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

              @if(!empty($stocks))

              <div class="text-center pb-3">
                  <a href="{{ route('punk.tcpdfstock', ['print' => $ids]) }}" class="btn btn-danger">
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
            Hello! <strong>{{ ucfirst(auth()->user()->name) }}</strong> Your Stock Detail has been updated...
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

        @endif
            <div class="card">
                <div class="card-header">Stock Details
                  <a href="#" data-target=".showstock" data-toggle="modal" class=" float-right btn btn-danger btn-sm">View Stock Details</a>

                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('punk.stockstore') }}">
                        @csrf
                        <div class="form-group row">
                            <label for="tank" class="col-md-4 col-form-label text-md-right text-info">Date</label>

                            <div class="col-md-6">
                              <input type="date" name="insert_date" id="date" value="{{ app('request')->date }}" class="form-control @error('insert_date') is-invalid @enderror">
                              @error('insert_date')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                           </div>

                        </div>
                        <div class="form-group row">
                            <label for="fuel" class="col-md-4 col-form-label text-md-right text-info">
                              FUEL
                            </label>
                            <div class="col-md-6 pt-3">

                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" {{ app('request')->fuel == 'petrol' ? 'checked' : '' }} required type="radio" name="fuel" id="petrol" value="petrol">
                                  <label class="form-check-label" for="petrol">Petrol</label>
                                </div>
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" {{ app('request')->fuel == 'diesel' ? 'checked' : '' }} required type="radio" name="fuel" id="diesel" value="diesel">
                                  <label class="form-check-label" for="diesel">Diesel</label>
                                </div>
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" {{ app('request')->fuel == 'speed' ? 'checked' : '' }} required type="radio" name="fuel" id="speed" value="speed">
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
                            <label for="old_stock_" class="col-md-4 col-form-label text-md-right text-info">Old Stock</label>
                            <div class="col-md-6">
                                <input type="text" id="old_stock" class="form-control" value="{{ $balance->bal_stock ?? 0 }}"  disabled>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="in_stock_" class="col-md-4 col-form-label text-md-right text-info">In Stock</label>
                            <div class="col-md-6">
                                <input id="in_stock_" type="text" required class="form-control @error('in_stock') is-invalid @enderror">

                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="bal_stock" class="col-md-4 col-form-label text-md-right text-info">Old + In Stock</label>

                              <label id="old_in_stock_show" class="col-md-6 col-form-label ">0</label>
                              <input id="old_in_stock" type="hidden" required class="form-control @error('in_stock') is-invalid @enderror" name="in_stock">
                        </div>


                        <div class="form-group row">
                            <label for="out_stock_" class="col-md-4 col-form-label text-md-right text-info">Out Stock</label>
                            <div class="col-md-6">
                                <input id="out_stock_" type="text" required class="form-control @error('out_stock') is-invalid @enderror" name="out_stock">

                                @error('out_stock')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="comment" class="col-md-4 col-form-label text-md-right text-info">Any Comments</label>
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
                            <label for="bal_stock" class="col-md-4 col-form-label text-md-right text-info">Balance Stock</label>
                              <label id="total_bal_stock_" class="col-md-6 col-form-label ">0</label>
                              <input id="bal_stock_" type="hidden" name="bal_stock" required class="form-control">
                          </div>


                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                  Save
                                </button>
                            </div>
                        </div>
                    </form>


                </div>
            </div>
        </div>
    </div>
    <div class="modal fade showstock" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
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
           <th scope="col">Fuel</th>
           <th scope="col">In Stock</th>
           <th scope="col">Out Stock</th>
           <th scope="col">Balance Stock</th>
           <th scope="col">Comments</th>
           <th scope="col">Stock At</th>
           <th scope="col">Updated At</th>
         </tr>
       </thead>
       <tbody>

         @forelse(optional(auth()->user())->stocks as $key => $stock)
          <tr>

           <th scope="row">{{ $key + 1 }}</th>
           <td>{{ ucfirst($stock->fuel) }}</td>
           <td>{{ $stock->in_stock }}</td>
           <td>{{ $stock->out_stock }}</td>
           <td>{{ $stock->bal_stock }}</td>
           <td>{{ $stock->comment }}</td>
           <td>{{ $stock->insert }}</td>
           <td>{{ $stock->created }}</td>
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
$(document).ready(function() {

  $('[id^=in_stock_]').keyup(function(key){
    var old = $('#old_stock').val();
    var inval = $(this).val();

    $('#old_in_stock_show').text(parseFloat(old) + parseFloat(inval));
    $('#old_in_stock').val(parseFloat(old) + parseFloat(inval));

  });

  $('[id^=out_stock_]').keyup(function(key){
    var str = $(this).attr('id');
    var id = str.split('_').pop();

    var price = $('#old_in_stock' + id).val();
    var value = $('#out_stock_' + id).val();
    $('#total_bal_stock_' + id).text(parseFloat(price) - parseFloat(value));
    $('#bal_stock_' + id).val(parseFloat(price) - parseFloat(value));
  });

  // $('[id^=in_stock_], [id^=out_stock_]').keyup(function(key){
  //   var str = $(this).attr('id');
  //   var id = str.split('_').pop();
  //
  //   var price = $('#in_stock_' + id).val();
  //   var value = $('#out_stock_' + id).val();
  //   $('#total_bal_stock_' + id).text(parseFloat(price) - parseFloat(value));
  //   $('#bal_stock_' + id).val(parseFloat(price) - parseFloat(value));
  // });

  $('#petrol,#diesel,#speed').change(function(){
    var date = $('#date').val();
    var fuel = $(this).val();
    window.location.href= '?fuel=' + fuel + '&date=' + date;
  });

});
</script>
@endpush
