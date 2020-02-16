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

                    <th scope="col">updated By</th>
                    <th scope="col">Stock At</th>
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
                    <td>{{ $stock->comment }}</td>

                    <td>{{ ucfirst($stock->user->name) }}</td>
                    <td>{{ $stock->created }}</td>
                  </tr>
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
                <div class="card-header">Stock Details
                  <a href="#" data-target=".showstock" data-toggle="modal" class=" float-right btn btn-danger btn-sm">View Stock Details</a>

                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('punk.stockstore') }}">
                        @csrf

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
                            <label for="in_stock" class="col-md-4 col-form-label text-md-right">IN Stock</label>
                            <div class="col-md-6">
                                <input id="in_stock" type="text" required class="form-control @error('in_stock') is-invalid @enderror" name="in_stock">

                                @error('in_stock')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="out_stock" class="col-md-4 col-form-label text-md-right">Out Stock</label>
                            <div class="col-md-6">
                                <input id="out_stock" type="text" required class="form-control @error('out_stock') is-invalid @enderror" name="out_stock">

                                @error('out_stock')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="comment" class="col-md-4 col-form-label text-md-right">Any Comments</label>
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
                            <label for="bal_stock" class="col-md-4 col-form-label text-md-right">Balance Stock</label>
                              <label id="today_bal_stock" class="col-md-6 col-form-label ">0</label>
                              <input id="bal_stock" type="hidden" name="bal_stock" required class="form-control">
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
                      Hello! <strong>{{ ucfirst(auth()->user()->name) }}</strong> Your Stock Detail has been updated...
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>

                  @endif
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
$(document).ready(function(){

  $('#in_stock, #out_stock').keyup(function(){
    var price = $('#in_stock').val();
    var value = $('#out_stock').val();
    $('#today_bal_stock').text(parseInt(price) - parseInt(value));
    $('#bal_stock').val(parseInt(price) - parseInt(value));
  });
});

</script>
@endpush
