@php
    $setting = \App\Models\Setting::first();
    $cart = session('cart', []);
    $count = array_sum(array_column($cart, 'qty'));
//$orderCount = \App\Models\Order::count();

     $customer = \App\Models\Customer::find(session('customer_id'));

@endphp
    {{--<nav class="navbar navbar-expand-lg sticky-top"
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
                             <a class=" btn btn-light ms-3 position-relative" href="{{ url($menu->link) }}">

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
                         @if(session()->has('customer_id'))

                             <li class="nav-item ms-3 position-relative">
                                 <a href="{{ route('user.orders') }}" class="btn btn-light">
                                     <i class="bi bi-bag"></i> Orders
                                 </a>

                                 @if(isset($orderCount) && $orderCount > 0)
                                     <span class="position-absolute top-0 start-100 translate-middle badge bg-danger">
                {{ $orderCount }}
            </span>
                                 @endif
                             </li>

                         @endif



                         @if($customer)
                             --}}{{-- ✅ Show user name + logout --}}{{--


                             <li class="nav-item ms-3">
                                 <a href="{{ route('logout') }}" class="btn btn-danger">
                                     Logout
                                 </a>
                             </li>

                         @else
                             --}}{{-- ❌ Show login only if NOT logged in --}}{{--
                             <li class="nav-item ms-3">
                                 <a href="{{ route('user.login') }}" class="btn btn-light px-4 rounded-pill">
                                     Login
                                 </a>
                             </li>
                         @endif

                </ul>
            </div>
        </div>
    </nav>--}}
<nav class="navbar navbar-expand-lg sticky-top"
     style="background: {{ $setting->theme_color ?? '#0d6efd' }}; box-shadow:0 4px 15px rgba(0,0,0,0.1);">
    <div class="container">

        <!-- Logo -->
        <a class="navbar-brand text-white fw-bold d-flex align-items-center" href="{{ url('/') }}">
            <img src="{{ asset('uploads/products/' . ($setting->logo ?? 'default.png')) }}"  height="40" class="me-2">
            MyShop
        </a>

        <!-- Toggle for Mobile -->
        <button class="navbar-toggler bg-white" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar Items -->
        <div class="collapse navbar-collapse" id="navMenu">
            <ul class="navbar-nav ms-auto align-items-center">

                @php
                    $menus = getHeaderMenus()->unique('name');
                    $cart = session('cart', []);
                    $count = count($cart);
                @endphp

                @foreach($menus as $menu)
                    @php
                        $submenus = $menu->subMenus ?? collect();
                    @endphp

                    @if($submenus->isNotEmpty())
                        <!-- Hover Mega Menu Dropdown -->
                        <li class="nav-item dropdown ms-3 position-static">
                            <a class="btn btn-light dropdown-toggle" href="{{ url($menu->link) }}">
                                {{ $menu->name }}
                            </a>

                            <div class="dropdown-menu w-100 p-4 shadow mega-menu">

                                <div class="row">
                                    @foreach($submenus->unique('name')->chunk(4) as $chunk)
                                        <div class="col-md-3">
                                            <ul class="list-unstyled">
                                                @foreach($chunk as $submenu)
                                                    <li class="mb-2 d-flex align-items-center">
                                                        @if(isset($submenu->icon))
                                                            <img src="{{ asset('uploads/icons/'.$submenu->icon) }}" height="24" class="me-2">
                                                        @endif
                                                        <a class="dropdown-item p-0" href="{{ url($submenu->link) }}">
                                                            {{ $submenu->name }}
                                                            @if(isset($submenu->badge))
                                                                <span class="badge bg-success ms-1">{{ $submenu->badge }}</span>
                                                            @endif
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </li>
                    @else
                        <li class="nav-item ms-3">
                            <a class="btn btn-light" href="{{ url($menu->link) }}">
                                {{ $menu->name }}
                            </a>
                        </li>
                    @endif
                @endforeach

                <!-- Cart -->
                <li class="nav-item ms-3 position-relative">
                    <a href="{{ route('cart.index') }}" class="btn btn-light position-relative">
                        <i class="bi bi-cart3"></i> Cart
                        @if($count > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge bg-danger">
                                {{ $count }}
                            </span>
                        @endif
                    </a>
                </li>

                <!-- Orders -->
                @if(session()->has('customer_id') && isset($orderCount))
                    <li class="nav-item ms-3 position-relative">
                        <a href="{{ route('user.orders') }}" class="btn btn-light">
                            <i class="bi bi-bag"></i> Orders
                        </a>
                        @if($orderCount > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge bg-danger">
                                {{ $orderCount }}
                            </span>
                        @endif
                    </li>
                @endif

                <!-- Login / Logout -->
                @if($customer)
                    <li class="nav-item ms-3">
                        <a href="{{ route('logout') }}" class="btn btn-danger">
                            Logout
                        </a>
                    </li>
                @else
                    <li class="nav-item ms-3">
                        <a href="{{ route('user.login') }}" class="btn btn-light px-4 rounded-pill">
                            Login
                        </a>
                    </li>
                @endif

            </ul>
        </div>
    </div>
</nav>

<!-- Custom CSS for Smooth Hover Mega Menu -->
<style>
    /* Hide dropdown by default */
    .navbar-nav .dropdown .mega-menu {
        display: block;
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.3s ease, visibility 0.3s ease;
        margin-top: 0;
    }

    /* Show dropdown on hover with fade effect */
    .navbar-nav .dropdown:hover .mega-menu {
        opacity: 1;
        visibility: visible;
    }

    /* Optional styling */
    .dropdown-item:hover {
        background-color: #f0f0f0;
    }

    .nav-item .dropdown-toggle::after {
        display: inline-block;
        margin-left: .255em;
    }

    .mega-menu {
        position: absolute;
        top: 100%;
        left: 0;
        width: 100%;
        background: #fff;
        z-index: 1000;
        border-top: 3px solid #0d6efd;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        padding: 1rem;
    }
</style>
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
