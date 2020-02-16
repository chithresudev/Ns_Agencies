@extends('layouts.punk')

@section('content')
<div class="container">
    <div class="row">
      
        @if(auth()->user()->role == 'admin')
        <div class="col-md-12">
                <div class="row">
                  <div class="col-md-4">
                    <div class="card">
                      <div class="card-body">
                        <h5 class="card-title">Fuel</h5>
                        <p class="card-text">Total Petrol Reading Value : {{ $petrol_read }} </p>
                        <p class="card-text">Total Diesel Reading Value : {{ $diesel_read }}</p>
                        <a href="{{ route('punk.fuel') }}" class="btn btn-success">View Fuel Report</a>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="card">
                      <div class="card-body">
                        <h5 class="card-title">Payment</h5>
                        <p class="card-text">Total Petrol Balance Amt :  {{ $petrol_payment }}</p>
                        <p class="card-text">Total Diesel Balance Amt : {{ $diesel_payment }}</p>
                        <a href="{{ route('punk.payment') }}" class="btn btn-success">View Payment Report</a>

                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="card">
                      <div class="card-body">
                        <h5 class="card-title">Stock</h5>
                        <p class="card-text">In Petrol Stock : {{ $in_petrol_stock }}</p>
                        <p class="card-text">In Diesel  Stock : {{ $in_diesel_stock }}</p>
                        <a href="{{ route('punk.stock') }}" class="btn btn-success">View Stock Report</a>

                      </div>
                    </div>
                  </div>
                </div>
            </div>
            @else
            <div class="col-md-12">
                    <div class="row">
                      <div class="col-md-4">
                        <div class="card">
                          <div class="card-body">
                            <h5 class="card-title">Fuel</h5>
                            <p class="card-text">Your Total Petrol Reading Value : {{ auth()->user()->dieselread() }} </p>
                            <p class="card-text">Your Total Diesel Reading Value : {{ auth()->user()->petrolread() }}</p>
                            <a href="{{ route('punk.fuel') }}" class="btn btn-primary">Go Add Fuel</a>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="card">
                          <div class="card-body">
                            <h5 class="card-title">Payment</h5>
                            <p class="card-text">Your Total Petrol Payment : {{ auth()->user()->petrolpayment() }}</p>
                            <p class="card-text">Your Total Diesel Payment : {{ auth()->user()->dieselpayment() }}</p>
                            <a href="{{ route('punk.payment') }}" class="btn btn-primary">Go Add Payments</a>

                          </div>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="card">
                          <div class="card-body">
                            <h5 class="card-title">Stock</h5>
                            <p class="card-text">Your In Stock : {{ auth()->user()->petrolstock() }}</p>
                            <p class="card-text">Your Out Stock : {{ auth()->user()->dieselstock() }}</p>
                            <a href="{{ route('punk.stock') }}" class="btn btn-primary">Go Add Stock</a>

                          </div>
                        </div>
                      </div>
                    </div>
                </div>
                @endif
        </div>
    </div>
</div>
@endsection
