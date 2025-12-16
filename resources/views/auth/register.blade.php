@extends('layouts.app')

@section('title', 'Đăng ký')

@section('content')
<div class="row justify-content-center mt-5">
    <div class="col-md-6">
        <div class="card shadow-lg">
            <div class="card-header text-center bg-success text-white">
                <h4 class="mb-0">
                    {{ __('Register') }}
                </h4>
            </div>

            <div class="card-body p-4">
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Name -->
                    <div class="mb-3">
                        <label for="name" class="form-label">{{ __('Full name') }}</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light">
                                <span class="material-symbols-outlined"> badge </span>
                            </span>
                            <input id="name" 
                                   type="text"
                                   class="form-control @error('name') is-invalid @enderror"
                                   name="name" 
                                   value="{{ old('name') }}" 
                                   placeholder="{{ __('Please enter your full name') }}" 
                                   required 
                                   autofocus>
                        </div>
                        @error('name')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light">
                                <span class="material-symbols-outlined"> mail </span>
                            </span>
                            <input id="email" 
                                   type="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   placeholder="{{ __('Please enter email') }}" 
                                   required>
                        </div>
                        @error('email')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <label for="password" class="form-label">{{ __('password') }}</label> 
                        <div class="input-group">
                            <span class="input-group-text bg-light">
                                <span class="material-symbols-outlined"> lock </span>
                            </span>
                            <input id="password" 
                                   type="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   name="password" 
                                   placeholder="{{ __('Create a password') }}" 
                                   required>
                            <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                <span class="material-symbols-outlined"> visibility_off </span>
                            </button>
                        </div>
                        @error('password')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">{{ __('Confirm password') }}</label> 
                        <div class="input-group">
                            <span class="input-group-text bg-light">
                                <span class="material-symbols-outlined"> lock_reset </span>
                            </span>
                            <input id="password_confirmation" 
                                   type="password"
                                   class="form-control @error('password_confirmation') is-invalid @enderror"
                                   name="password_confirmation" 
                                   placeholder="{{ __('Re-enter the password') }}" 
                                   required>
                        </div>
                        @error('password_confirmation')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <a href="{{ route('login') }}" class="text-decoration-none d-flex align-items-center">
                           <span class="material-symbols-outlined me-1" style="font-size: 18px;"> login </span>
                           {{ __('You already have an account') }}  
                        </a>

                        <button type="submit" class="btn btn-success px-4 d-flex align-items-center">
                            <span class="material-symbols-outlined me-1"> person_add </span>
                            {{ __('Register') }}
                        </button>
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
