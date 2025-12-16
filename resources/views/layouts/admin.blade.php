<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', __('Admin Panel'))</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/partials.css') }}">
</head>

<body class="admin-layout">

    @include('partials.header')

    <span id="menuToggle" class="d-md-none material-symbols-outlined">menu</span>

    <div class="d-flex">

        <nav class="sidebar d-flex flex-column" id="sidebar">
            <h4 class="fw-bold mb-3 border-bottom pb-2">{{ __('Administration') }}</h4>

            <ul class="nav flex-column mb-auto">

                <li>
                    <a href="{{ route('admin.dashboard') }}"
                        class="nav-link @if(Request::routeIs('admin.dashboard')) active @endif">
                        <span class="material-symbols-outlined">dashboard</span>
                        {{ __('Dashboard') }}
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.users.index') }}"
                        class="nav-link @if(Request::routeIs('admin.users.*')) active @endif">
                        <span class="material-symbols-outlined">group</span>
                        {{ __('Users') }}
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.dondatlichs.index') }}" class="nav-link">
                        <span class="material-symbols-outlined">shopping_cart</span>
                        {{ __('Orders') }}
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.danh-mucs.index') }}" class="nav-link">
                        <span class="material-symbols-outlined">category</span>
                        {{ __('Categories') }}
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.dich-vus.index') }}" class="nav-link">
                        <span class="material-symbols-outlined">home_repair_service</span>
                        {{ __('Services') }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.tinh-trangs.index') }}" class="nav-link @if(Request::routeIs('admin.tinh-trangs.*')) active @endif">
                        <span class="material-symbols-outlined">label</span>
                        {{ __('Statuses') }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.ma-giam-gias.index') }}" class="nav-link">
                        <span class="material-symbols-outlined">sell</span>
                        {{ __('Coupons') }}
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.danhgias.index') }}" class="nav-link">
                        <span class="material-symbols-outlined">reviews</span>
                        {{ __('Reviews') }}
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.banners.index') }}" class="nav-link">
                        <span class="material-symbols-outlined">imagesmode</span>
                        {{ __('Banner Management') }}
                    </a>
                </li>
            </ul>

            <hr>

            <div class="user-box mt-auto">
                <strong>{{ auth()->user()->name }}</strong>
            </div>
        </nav>

    <main class="container-fluid admin-main">
            @yield('content')
        </main>
    </div>

    @include('partials.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Mở / đóng sidebar trên mobile
        document.getElementById("menuToggle").addEventListener("click", () => {
            document.getElementById("sidebar").classList.toggle("show");
        });
    </script>

</body>
</html>