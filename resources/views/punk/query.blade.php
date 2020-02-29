@extends('layouts.punk')

@section('content')


<div class="container">
  @if(auth()->user()->role == 'admin')
  <div class="row justify-content-center">
      <div class="col-md-10">
          <div class="card">
              <div class="card-header">Rise a Query?</div>

              <div class="card-body">
                <form method="POST" action="{{ route('punk.risequery') }}">
                    @csrf

                <div class="form-group row">
                    <label for="module" class="col-md-4 col-form-label text-md-right text-info">MPD</label>
                    <div class="col-md-6">
                      <select class="custom-select" name="module" id="module" required>
                       <option selected disabled value="">Choose...</option>
                       <option value="fuel">Fuel</option>
                       <option value="payment">Payment</option>
                       <option value="stock">Stock</option>
                     </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="comment" class="col-md-4 col-form-label text-md-right">Comments</label>
                    <div class="col-md-6">
                        <textarea id="comment" type="text" placeholder="(Optional)..." class="form-control" name="comment"></textarea>
                    </div>
                </div>
              </form>

          </div>
        </div>
        </div>
        </div>

 @endif

@endsection
