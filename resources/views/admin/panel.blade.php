<!DOCTYPE html>
<html>
<head>
    <title>My Admin</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/panel.css') }}">

</head>


<body>

<!-- Sidebar -->
<div class="sidebar" style="max-height:100%; overflow-y: auto;">


    <div class="logo-box">
        <img src="{{ asset('uploads/products/'.(\App\Models\Setting::first()->logo ?? 'default.png')) }}" class="logo-img" height="60">
    </div>
    <h4>Admin Panel</h4>

    <div class="menu-title">Dashboard</div>
    <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <i class="bi bi-speedometer2"></i> Dashboard
    </a>

    <div class="menu-title">Master</div>
    <a href="{{ route('products.index') }}" class="{{ request()->routeIs('products.*') ? 'active' : '' }}">
        <i class="bi bi-box"></i> Products
    </a>

    <a href="{{ route('catagory.catagoryindex') }}" class="{{ request()->routeIs('catagory.*') ? 'active' : '' }}">
        <i class="bi bi-tags"></i> Categories
    </a>

    <a href="{{ route('brand.brandindex') }}" class="{{ request()->routeIs('brand.*') ? 'active' : '' }}">
        <i class="bi bi-building"></i> Brands
    </a>

    <a href="{{ route('variants.index') }}" class="{{ request()->routeIs('variants.*') ? 'active' : '' }}">
        <i class="bi bi-sliders"></i> Variants
    </a>
    <a href="{{ route('admin.orders') }}" class="{{ request()->routeIs('admin.orders*') ? 'active' : '' }}">
        <i class="bi bi-bag-check"></i> Orders
    </a>
    <a href="{{ route('admin.customers') }}"
       class="nav-link {{ request()->routeIs('admin.customers') ? 'active' : '' }}">
        <i class="bi bi-people"></i> Customers
    </a>
    <a href="{{ route('admin.email-settings') }}"
       class="nav-link {{ request()->routeIs('admin.email-settings') ? 'active' : '' }}">
        <i class="bi bi-envelope-fill me-2"></i>email-settings
    </a>

    <div class="menu-title">Appearance</div>

    <a href="javascript:void(0);" onclick="toggleThemeMenu()" class="d-flex justify-content-between align-items-center">
        <span><i class="bi bi-sliders"></i> Themes</span>
        <i class="bi bi-chevron-down" id="themeArrow"></i>
    </a>


    <!-- SUB MENU -->
    <div id="themeMenu" style="display:none; padding-left: 25px;">

        <a href="{{ route('themes.settings') }}" class="d-block">
            <i class="bi bi-gear"></i> Settings
        </a>

        <a href="{{ route('menus.index') }}" class="d-block">
            <i class="bi bi-palette"></i> Frontend
        </a>

    </div>

    <!-- Logout Button -->
    <a href="javascript:void(0);" id="logoutBtn" class="nav-link">
        <i class="bi bi-box-arrow-right"></i> Logout
    </a>

    <!-- Hidden Logout Form -->
    <form id="logoutForm" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

</div>

<!-- Content -->
<div class="content">

    <!-- Topbar -->


    <!-- Page Content -->
    @yield('content')

</div>

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function toggleThemeMenu() {
        let menu = document.getElementById("themeMenu");
        let arrow = document.getElementById("themeArrow");

        if (menu.style.display === "none" || menu.style.display === "") {
            menu.style.display = "block";
            arrow.classList.remove("bi-chevron-down");
            arrow.classList.add("bi-chevron-up");
        } else {
            menu.style.display = "none";
            arrow.classList.remove("bi-chevron-up");
            arrow.classList.add("bi-chevron-down");
        }
    }
</script>
<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- SweetAlert2 Script -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.getElementById("logoutBtn").addEventListener("click", function() {
        Swal.fire({
            title: 'Logout?',
            text: "Are you sure you want to logout?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, Logout',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('logoutForm').submit();
            }
        });
    });
</script>
<!-- 🔥 VERY IMPORTANT -->
@stack('scripts')
</body>
</html>
