<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lipis/flag-icons@7.0.0/css/flag-icons.min.css"/>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top" style="z-index: 1030;">
    <div class="container">
        <a class="navbar-brand fw-bold d-flex align-items-center" href="{{ route('home') }}" style="color: #6EC6FF;">
            <img src="{{ asset('images/logo.png') }}" alt="Logo Giặt Sấy 89" height="40" class="me-2">
            {{ __('LAUNDRY') }} 89
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar"
            aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="dropdown"> 
            <button class="btn btn-light dropdown-toggle d-flex align-items-center gap-2 shadow-sm border" type="button"
                data-bs-toggle="dropdown" aria-expanded="false">
                @if(App::getLocale() == 'vi')
                <span class="fi fi-vn"></span> <span>Tiếng Việt</span>
                @else
                <span class="fi fi-us"></span> <span>English</span>
                @endif
            </button>
            
            <ul class="dropdown-menu shadow animate slideIn"> 
                <li>
                    <a class="dropdown-item d-flex align-items-center gap-2 {{ App::getLocale() == 'vi' ? 'active' : '' }}" href="{{ route('change-language', ['locale' => 'vi']) }}">
                        <span class="fi fi-vn"></span> Tiếng Việt
                    </a>
                </li>
                <li>
                    <a class="dropdown-item d-flex align-items-center gap-2 {{ App::getLocale() == 'en' ? 'active' : '' }}" href="{{ route('change-language', ['locale' => 'en']) }}">
                        <span class="fi fi-us"></span> English
                    </a>
                </li>
            </ul>
        </div>

        <div class="collapse navbar-collapse" id="mainNavbar">
            <ul class="navbar-nav ms-auto align-items-center">
                @if (!Auth::check() || (Auth::check() && Auth::user()->role !== 'admin'))
                    <li class="nav-item me-3">
                        <a class="nav-link fw-bold text-primary" href="{{ route('vouchers.my') }}">
                            <i class="bi bi-wallet2 me-1"></i>{{ __('My Voucher Wallet') }}
                        </a>
                    </li>
                    <li class="nav-item me-3">
                        <a class="nav-link fw-bold text-danger" href="{{ route('vouchers.index') }}">
                            <i class="bi bi-gift-fill me-1"></i>{{ __('Hunt for Vouchers') }}
                        </a>
                    </li>
                    <li class="nav-item me-3">
                        <a class="btn btn-outline-primary position-relative" href="{{ route('cart.index') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart3 me-1" viewBox="0 0 16 16">
                                <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .49.598l-1 5a.5.5 0 0 1-.465.401l-9.397.472L4.77 9.5H13.5a.5.5 0 0 1 0 1H4.21l-.45 1.803A.5.5 0 0 1 3.25 13H.5a.5.5 0 0 1-.5-.5zM3.14 4l.79 3.263l8.06 1.612l.71-3.567H3.14zM5 13a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0zM12 13a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0z"/>
                            </svg>
                            {{ __('Laundry bag') }} ({{ \Gloudemans\Shoppingcart\Facades\Cart::count() }})
                        </a>
                    </li>
                @endif
                @guest
                    <li class="nav-item me-2">
                        <a class="btn btn-outline-primary btn-sm" href="{{ route('login') }}">{{ __('Log in') }}</a> 
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-primary btn-sm" href="{{ route('register') }}">{{ __('Register') }}</a>
                    </li>
                @else
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center text-dark" href="#" id="navbarUserDropdown"
                            role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            
                            <img src="{{ Auth::user()->avatar_url }}" 
                                alt="{{ Auth::user()->name }}" 
                                class="rounded-circle shadow-sm me-2" 
                                style="width:32px; height:32px; object-fit:cover;">
                            {{ __('Hello') }} {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm user-dropdown"
                            aria-labelledby="navbarUserDropdown">

                            @if (Auth::user()->role === 'admin')
                                <li>
                                    <a class="dropdown-item d-flex align-items-center gap-2"
                                    href="{{ route('admin.dashboard') }}">
                                        <i class="bi bi-speedometer2"></i>
                                        {{ __('dashboard') }}
                                    </a>
                                </li>
                            @else
                                <li>
                                    <a class="dropdown-item d-flex align-items-center gap-2"
                                    href="{{ route('dashboard') }}">
                                        <i class="bi bi-speedometer2"></i>
                                        {{ __('dashboard') }}
                                    </a>
                                </li>
                            @endif

                            <li>
                                <a class="dropdown-item d-flex align-items-center gap-2"
                                href="{{ route('profile.edit') }}">
                                    <i class="bi bi-person-circle"></i>
                                    {{ __('Profile') }}
                                </a>
                            </li>

                            <li><hr class="dropdown-divider"></li>

                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <a class="dropdown-item d-flex align-items-center gap-2 text-danger"
                                    href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                        <i class="bi bi-box-arrow-right"></i>
                                        {{ __('logout') }}
                                    </a>
                                </form>
                            </li>
                        </ul>

                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>

<!-- header styles moved to public/css/partials.css -->
