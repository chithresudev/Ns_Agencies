
@php
  $route = Route::currentRouteName();
@endphp

<div class="list-group panel list-group-flush">
    <ul class="nav nav-pills flex-column">
        <li class="nav-item">
            <a href="{{ route('punk.index') }}" class="nav-link {{ $route == 'punk.index' ? 'custom-active' : '' }} " data-parent="#sidebar">
                <i class="fa fa-tachometer"></i>
              Dashboard
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('punk.fuel') }}" class="nav-link {{ $route == 'punk.fuel' || $route == 'punk.fuelview' ? 'custom-active' : '' }} " data-parent="#sidebar">
                <i class="fa fa-shower "></i>
            Fuel
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('punk.payment') }}" class="nav-link {{ $route == 'punk.payment' || $route == 'punk.paymentview' ? 'custom-active' : '' }} " data-parent="#sidebar">
                <i class="fa  fa-money"></i>
                Payments
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('punk.stock') }}" class="nav-link {{ $route == 'punk.stock' || $route == 'punk.stockview' ? 'custom-active' : '' }} " data-parent="#sidebar">
                <i class="fa fa-plus-square-o"></i>
                Stock
            </a>
        </li>

      @if (auth()->user()->role == 'admin')
        <li class="nav-item">
            <a href="{{ route('punk.users') }}" class="nav-link {{ $route == 'punk.users' || $route == 'punk.register' ? 'custom-active' : '' }} " data-parent="#sidebar">
                <i class="fa fa-user"></i>
               Managers
            </a>
        </li>
      @endif

        <li class="nav-item">
            <a href="{{ route('punk.todayprice') }}" class="nav-link {{ $route == 'punk.todayprice'  ? 'custom-active' : '' }} " data-parent="#sidebar">
                <i class="fa fa-history"></i>
               Today Price
            </a>
        </li>

    </ul>
</div>
