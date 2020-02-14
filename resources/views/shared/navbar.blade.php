
@php
$logo = config('app.client_logo');
@endphp

<nav class="navbar fixed-top navbar-expand-lg navbar-light bg-light sq1dashboard-navbar">

  <a class="navbar-brand sidebar-toggle d-none"  href="#">
    <i class="material-icons">menu</i>
  </a>

  <a class="navbar-brand" href="#">
     <img src="{{ asset('images/logo.png') }}" width="45" height="45"
      alt="SQ1Shield">
  </a>


  <button class="navbar-toggler" type="button" data-toggle="collapse"
   data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
   aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">

      @yield('navbar-items')

    </ul>

    <!-- Right Side Of Navbar -->
    <ul class="navbar-nav ml-auto align-items-lg-center align-items-end">
        <!-- Client Logo -->
         @if ($logo)
           <img src="{{ asset('images/' . $logo) }}"
           alt="client logo" class="client_logo pr-3">
         @endif
        <!-- Authentication Links -->
        @guest
        <li>
          <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
        </li>
        {{-- @if (Route::has('register'))
            <li class="nav-item">
                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
            </li>
        @endif --}}
        @else
        <li class="nav-item dropdown pt-1">
            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#"
              role="button" data-toggle="dropdown" aria-haspopup="true"
              aria-expanded="false" v-pre>
              <i class="fa fa-user-o" aria-hidden="true"></i>
              <span class="caret"></span>
            </a>

            <div class="dropdown-menu logoutMenu" aria-labelledby="navbarDropdown">
                <a class="dropdown-header header-nav-current-user css-truncate">
                  Signed in as :
                </a>
                <p class="dropdown-item" href="">
                    <strong class="css-truncate-target">
                        {{ auth()->user()->name }}
                    </strong>
                </p>

                {{-- <div class="dropdown-divider"></div> --}}
                {{-- <label class="switch">
                    <input type="checkbox" id="active_mode" value="{{ $mode }}" {{ ($mode == 'true' || $mode == '') ? 'checked' : '' }}>
                    <span class="slider"></span>
                </label> --}}

                {{--<div class="dropdown-divider"></div>
                   <a class="dropdown-item" href="{{ route('profile') }}">
                    Change Profile
                  </a> --}}

                <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="{{ route('logout') }}"
                     onclick="event.preventDefault();
                                   document.getElementById('logout-form').submit();">
                      {{ __('Logout') }}
                  </a>

                  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                      @csrf
                  </form>
            </div>
        </li>
        @endguest
    </ul>
  </div>

  <!-- mobile menu -->
  {{-- <ul class="navbar-nav logout">
    <li class="nav-item dropdown">
      <img src="{{ asset('images/client/shield/' . $client_logo) }}"
      alt="{{ config('sq1shield.client_name') }} " class="client_logo pr-3">

    </li>
  </ul> --}}
</nav>
