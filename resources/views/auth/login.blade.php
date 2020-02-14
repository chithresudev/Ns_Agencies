@extends('layouts.punk')

@push('styles')
 <link href="{{ asset('css/login.css') }}" rel="stylesheet">
@endpush

@section('content')
  <div class="container">
    <div class="row padd-wrapper mx-auto box-shadow">
              <div class="col-md-6 d-flex align-items-center bg-info p-3 border-right">
                <img src="{{asset('images/user_2.png')}}" alt="User" class="d-lg-block d-md-block d-none mx-auto w-75">

              </div>
              <div class="col-md-6 d-flex align-items-center bg-white">
                <form class="sq1shield-form w-100" method="POST" action="{{ route('login') }}">
                @csrf
                {{-- <img src="{{asset('images/favicon.ico')}}" alt="User" class="d-block mx-auto mb-4"> --}}
                <h4 class="text-center pb-3 text-dark">Welcome to <span class="text-danger">Demo</span> </h4>
                <div class="card bg-transparent border-0">
                  <div class="card-body border-0">
                    <div class="form-group row sq1shield-form-group mb-3">
                      <div class="col-lg-9 col-md-12 mx-auto">
                        <div class="input-group">
                          <div class="input-group-prepend">
                              <span class="input-group-text rounded-0 border-bottom border-left-0 border-top-0 bg-white width-37">
                                <i class="fa fa-envelope"></i>
                              </span>
                            </div>
                          <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }} border-bottom border-top-0 border-right-0 border-left-0 rounded-0" name="email" value="{{ old('email') }}" placeholder="Email" required autofocus>
                          @if ($errors->has('email'))
                            <span class="invalid-feedback">
                              <strong>{{ $errors->first('email') }}</strong>
                            </span>
                          @endif
                        </div>
                      </div>
                    </div>
                    <div class="form-group row sq1shield-form-group mb-3">
                      <div class="col-lg-9 col-md-12 mx-auto">
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text rounded-0 border-bottom border-left-0 border-top-0 bg-white width-37">
                              <i class="fa fa-unlock-alt font-19"></i>
                            </span>
                          </div>
                          <input id="password" type="password"
                          class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }} border-bottom border-top-0 border-right-0 border-left-0 rounded-0"
                          name="password" placeholder="Password" required>
                          @if ($errors->has('password'))
                            <span class="invalid-feedback font-weight-normal">
                              <strong>{{ $errors->first('password') }}</strong>
                            </span>
                          @endif
                        </div>
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-lg-9 col-md-12 mx-auto">
                          <button type="submit" class="btn form-control text-capitalize text-white d-block mx-auto mt-3">Continue
                            <span>
                              {{-- <i class="fa fa-chevron-right float-right pr-2 pt-1 text-white" aria-hidden="true"></i> --}}
                            </span>
                          </button>
                      </div>
                    </div>
                  </div>
                  <div class="mx-auto">
                    <a class="" href="{{ route('register') }}">{{ __('  Create an new account') }}</a>
                  </div>
                </div>
              </form>
              </div>
            </div>
          </div>
@endsection
