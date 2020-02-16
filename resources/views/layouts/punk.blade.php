<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ asset('images/favicon.ico') }}" rel="icon" type="image/x-icon"/>

    <title>Welcome NS agencies | @yield('title')</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Exo+2&display=swap" rel="stylesheet">

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/punk.css') }}" rel="stylesheet">
    <link href="{{ asset('css/font-awesome.css') }}" rel="stylesheet">

   @stack('styles')
</head>

<body>
  @auth
    <!-- Header Section -->
    <header>
      @include('shared.navbar')
    </header>

    <!-- Desktop Side Panel Section -->
    <aside id="desktop_panel">
      @include('shared.sidebar')
    </aside>
  @endauth

<main class="pt-4">
      @yield('content')
 </main>
<!-- Scripts -->
<script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/punk.js') }}"></script>
@stack('scripts')

</body>
</html>
