@extends('layouts.app')

@section('title', 'Đăng nhập')

@section('content')

<div class="row justify-content-center mt-5">
    <div class="col-md-5">
        <div class="card shadow-lg">
            <div class="card-header text-center bg-primary text-white">
                <h4 class="mb-0">
                    {{ __('Log in') }}
                </h4>
            </div>

            <div class="card-body p-4">

                @if (session('status'))
                    <div class="alert alert-success">{{ session('status') }}</div>
                @endif
                
                @if (session('error'))
                     <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label">
                            Email
                        </label>

                        <div class="input-group">
                            <span class="input-group-text bg-light">
                                <span class="material-symbols-outlined"> mail </span>
                            </span>

                            <input id="email" class="form-control @error('email') is-invalid @enderror"
                                type="email" name="email"
                                value="{{ old('email') }}" placeholder="{{ __('Please enter email') }}" required autofocus>
                        </div>

                        @error('email')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">
                            Mật khẩu
                        </label>

                        <div class="input-group">
                            <span class="input-group-text bg-light">
                                <span class="material-symbols-outlined"> lock </span>
                            </span>

                            <input id="password" class="form-control @error('password') is-invalid @enderror"
                                type="password" name="password" placeholder="{{ __('Please enter the password') }}" required> 

                            <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                <span class="material-symbols-outlined"> visibility_off </span>
                            </button>
                        </div>

                        @error('password')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 form-check">
                        <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                        <label class="form-check-label" for="remember_me">
                            {{ __('Remember to log in') }}
                        </label>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-4">
                        @if (Route::has('password.request'))
                            <a class="text-sm text-decoration-none d-flex align-items-center" href="{{ route('password.request') }}">
                                <span class="material-symbols-outlined me-1" style="font-size: 18px;"> help </span>
                                {{ __('Forgot password') }}?
                            </a>
                        @endif

                        <button type="submit" class="btn btn-primary px-4 d-flex align-items-center">
                            <span class="material-symbols-outlined me-1"> login </span>
                            {{ __('Log in') }}
                        </button>
                    </div>

                    <div class="mt-4">
                        <div class="d-flex align-items-center mb-3">
                            <hr class="flex-grow-1 my-0 text-secondary">
                            <span class="px-3 text-muted">{{ __('Or') }}</span>
                            <hr class="flex-grow-1 my-0 text-secondary">
                        </div>

                        <div class="row g-2">
                            <div class="col-6">
                                <a href="{{ route('login.google') }}" class="btn btn-light border shadow-sm w-100 d-flex align-items-center justify-content-center py-2">
                                    <img class="me-2" src="https://www.svgrepo.com/show/475656/google-color.svg" alt="Google logo" style="width: 20px; height: 20px;">
                                    <span class="fw-medium text-dark">Google</span>
                                </a>
                            </div>

                            <div class="col-6">
                                <a href="{{ route('facebook.login') }}" class="btn w-100 d-flex align-items-center justify-content-center py-2 shadow-sm text-white" style="background-color: #1877F2; border: 1px solid #1877F2;">
                                    <svg class="me-2 fill-current" width="20" height="20" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.791-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                    </svg>
                                    <span class="fw-medium">Facebook</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 text-center">
                        <a href="{{ route('register') }}" class="d-inline-flex align-items-center text-decoration-none text-primary">
                            <span class="material-symbols-outlined me-1" style="font-size: 20px; line-height: 1;"> 
                                person_add 
                            </span>
                            <span>{{ __('Create new account') }}</span> 
                        </a>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('javascript')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const togglePassword = document.querySelector('#togglePassword');
    const passwordInput = document.querySelector('#password');

    togglePassword.addEventListener('click', function () {
        const type = passwordInput.type === 'password' ? 'text' : 'password';
        passwordInput.type = type;

        const icon = togglePassword.querySelector('.material-symbols-outlined');
        icon.textContent = type === 'password' ? 'visibility_off' : 'visibility';
    });
});
</script>
@endsection