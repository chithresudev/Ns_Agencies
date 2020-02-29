@extends('layouts.punk')

@php
$request = app('request');
@endphp

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">

              @if (session('status'))
              <div class="alert alert-success alert-dismissible hide show mt-3" role="alert">
                Hello! <strong>{{ ucfirst(auth()->user()->name) }}</strong> Today Price Detail has been updated...
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>

            @endif

            @if (session('removestatus'))
            <div class="alert alert-danger alert-dismissible hide show mt-3" role="alert">
              Hello! <strong>{{ ucfirst(auth()->user()->name) }}</strong> Todayprice Detail has been removed...
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
          @endif

            <div class="card">
                <div class="card-header">Today Price

                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('punk.todaypricestore') }}">
                        @csrf
                        <div class="form-group row">
                            <label for="tank" class="col-md-4 col-form-label text-md-right text-info">Date</label>

                            <div class="col-md-6">
                              <input type="date" name="date" class="form-control @error('date') is-invalid @enderror">
                              @error('date')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                           </div>

                        </div>
                        <div class="form-group row">
                            <label for="tank" class="col-md-4 col-form-label text-md-right text-info">Petrol Price</label>

                            <div class="col-md-6">
                              <input type="text" name="petrol" class="form-control @error('petrol') is-invalid @enderror">
                              @error('petrol')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                           </div>

                        </div>
                        <div class="form-group row">
                            <label for="diesel" class="col-md-4 col-form-label text-md-right text-info">Diesel Price</label>

                            <div class="col-md-6">
                              <input type="text" name="diesel" class="form-control @error('diesel') is-invalid @enderror">
                              @error('diesel')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                           </div>

                        </div>
                        <div class="form-group row">
                            <label for="speed" class="col-md-4 col-form-label text-md-right text-info">Speed Price</label>

                            <div class="col-md-6">
                              <input type="text" name="speed" class="form-control @error('speed') is-invalid @enderror">
                              @error('speed')
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
                    </form>

                    <table class="table table-striped mt-5">
                      <thead>
                        <tr>
                          <th scope="col">#</th>
                          <th scope="col">Petrol Price</th>
                          <th scope="col">Diesel Price</th>
                          <th scope="col">Speed Price</th>
                          <th scope="col">Date </th>
                          @if(auth()->user()->role == 'admin')
                          <th scope="col">Action</th>
                          @endif
                        </tr>
                      </thead>
                      <tbody>

                        @forelse($todayprices ?? '' as $key => $todayprice)
                         <tr>
                            <th scope="row">{{ $key + 1 }}</th>
                            <td>{{ $todayprice->petrol }} </td>
                            <td>{{ $todayprice->diesel }} </td>
                            <td>{{ $todayprice->speed }} </td>
                            <td>{{ $todayprice->date }} </td>

                            @if(auth()->user()->role == 'admin')
                            <td>
                              <a href="{{ route('punk.remove' , ['module' => 'todayprice', 'id' => $todayprice->id ]) }}" class="btn btn-sm btn-danger">
                                Remove
                              </a>
                            </td>
                            @endif

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
    </div>
    </div>

@endsection
