@php
    $setting = \App\Models\Setting::first();
    $cart = session('cart', []);
    $count = array_sum(array_column($cart, 'qty'));
    $orderCount = \App\Models\Order::count();
@endphp
<nav class="navbar navbar-expand-lg sticky-top"
     style="background: {{ $setting->theme_color ?? '#0d6efd' }}; box-shadow:0 4px 15px rgba(0,0,0,0.1);">

    <div class="container">

        <!-- Logo -->
        <a class="navbar-brand text-white fw-bold d-flex align-items-center" href="#">
            <img src="{{ asset('uploads/products/'.($setting->logo ?? 'default.png')) }}" height="40" class="me-2">
            MyShop
        </a>

        <!-- Toggle -->
        <button class="navbar-toggler bg-white" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Dynamic Header Menu -->
        <div class="collapse navbar-collapse" id="navMenu">
            <ul class="navbar-nav ms-auto align-items-center">

                 @foreach(getHeaderMenus() as $menu)
                     <li class="nav-item">
                         <a class="nav-link text-white" href="{{ url($menu->link) }}">
                             {{ $menu->name }}
                         </a>
                     </li>
                 @endforeach

                  @php
                      $cart = session('cart', []);
                      $count = count($cart);
                  @endphp

                  <a href="{{ route('cart.index') }}" class="btn btn-light ms-3 position-relative">
                      Cart
                      <span class="position-absolute top-0 start-100 translate-middle badge bg-danger">
                     {{ $count }}
                     </span>
                  </a>
                  <li class="nav-item ms-3 position-relative">
                      <a href="{{ route('user.orders') }}" class="btn btn-light">
                          <i class="bi bi-bag"></i> Orders
                      </a>

                      <span class="position-absolute top-0 start-100 translate-middle badge bg-danger">
                    {{ $orderCount }}
                     </span>
                  </li>
              <!-- Login Button -->
              <li class="nav-item ms-3">
                  <a href="/login" class="btn btn-light px-4 rounded-pill">
                      Login
                  </a>
              </li>

            </ul>
        </div>
    </div>
</nav>
{{--
@php
    $setting = \App\Models\Setting::first();
$cart = session('cart', []);
    $count = array_sum(array_column($cart, 'qty'));
    $orderCount = \App\Models\Order::count();
@endphp

<nav class="navbar navbar-expand-lg sticky-top"
     style="background: {{ $setting->theme_color ?? '#0d6efd' }};">

    <div class="container">

        <a class="navbar-brand text-white fw-bold" href="/">MyShop</a>

        <ul class="navbar-nav ms-auto align-items-center">

            @foreach(getHeaderMenus() as $menu)
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ url($menu->link) }}">
                        {{ $menu->name }}
                    </a>
                </li>
            @endforeach

            <!-- Cart -->
            <li class="nav-item ms-3 position-relative">
                <a href="{{ route('cart.index') }}" class="btn btn-light">
                    Cart
                </a>
                <span class="badge bg-danger position-absolute top-0 start-100 translate-middle">
                    {{ $count }}
                </span>
            </li>

            <!-- Orders -->
            <li class="nav-item ms-3 position-relative">
                <a href="{{ route('user.orders') }}" class="btn btn-light">
                    Orders
                </a>
                <span class="badge bg-success position-absolute top-0 start-100 translate-middle">
                    {{ $orderCount }}
                </span>
            </li>

        </ul>
    </div>
</nav>
--}}
