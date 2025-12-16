@extends('layouts.app')

@section('title', __('Profile'))

@section('content')

<style>
    /* CSS bổ sung cho phần icon MXH */
    .social-btn-icon {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        color: white;
        font-weight: bold;
        font-size: 18px;
        margin-right: 15px;
    }
    .bg-google { background-color: #db4437; }
    .bg-facebook { background-color: #4267B2; }
</style>

<div class="container py-4">

    <div class="text-center mb-5">
        <img src="{{ Auth::user()->avatar_url }}" class="profile-avatar mb-3" style="width: 110px; height: 110px; object-fit: cover; border-radius: 50%;">

        <h2 class="fw-bold">{{ Auth::user()->name }}</h2>
        <p class="text-muted mb-1">{{ Auth::user()->email }}</p>

        @if (Auth::user()->role === 'admin')
            <span class="badge bg-danger role-badge">{{ __('Administrator') }}</span>
        @else
            <span class="badge bg-primary role-badge">{{ __('Member') }}</span>
        @endif
    </div>


    <div class="row justify-content-center">

        <div class="col-lg-8">

            <div class="card profile-card shadow mb-4">

                <div class="profile-card-header">
                    <h5 class="mb-1">
                        <span class="material-symbols-outlined align-middle me-1">person</span>
                        {{ __('Profile Information') }}
                    </h5>
                    <small>{{ __('Update your account profile') }}</small>
                </div>

                <div class="card-body p-4">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="card profile-card shadow mb-4">
                <div class="profile-card-header" style="background: linear-gradient(135deg, #4285F4, #3b5998);">
                    <h5 class="mb-1 text-white">
                        <span class="material-symbols-outlined align-middle me-1">link</span>
                        {{ __('Social Media Links') }}
                    </h5>
                    <small class="text-white-50">{{ __('Link accounts for faster login') }}</small>
                </div>

                <div class="card-body p-4">
                    
                    <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
                        <div class="d-flex align-items-center">
                            <div class="social-btn-icon bg-google">G</div>
                            <div>
                                <h6 class="mb-0 fw-bold">Google</h6>
                                @if(Auth::user()->google_id)
                                    <small class="text-success"><i class="bi bi-check-circle-fill"></i> {{ __('Linked') }}</small>
                                @else
                                    <small class="text-muted">{{ __('Not linked') }}</small>
                                @endif
                            </div>
                        </div>
                        <div>
                            @if(Auth::user()->google_id)
                                {{-- Nút hủy liên kết (cần route xử lý nếu muốn) --}}
                                <button class="btn btn-sm btn-outline-secondary" disabled>{{ __('Connected') }}</button>
                            @else
                                {{-- Thay route('auth.google') bằng route thực tế của bạn --}}
                                <a href="{{ route('login.google') }}" class="btn btn-sm btn-outline-danger">{{ __('Connect') }}</a>
                            @endif
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <div class="social-btn-icon bg-facebook">F</div>
                            <div>
                                <h6 class="mb-0 fw-bold">Facebook</h6>
                                @if(Auth::user()->facebook_id)
                                    <small class="text-success"><i class="bi bi-check-circle-fill"></i> {{ __('Linked') }}</small>
                                @else
                                    <small class="text-muted">{{ __('Not linked') }}</small>
                                @endif
                            </div>
                        </div>
                        <div>
                            @if(Auth::user()->facebook_id)
                                <button class="btn btn-sm btn-outline-secondary" disabled>{{ __('Connected') }}</button>
                            @else
                                {{-- Thay route('auth.facebook') bằng route thực tế của bạn --}}
                                <a href="{{ route('facebook.login') }}" class="btn btn-sm btn-outline-primary">{{ __('Connect') }}</a>
                            @endif
                        </div>
                    </div>

                </div>
            </div>


            <div class="card profile-card shadow mb-4">

                <div class="profile-card-header" style="background: linear-gradient(135deg, #6f42c1, #a77bff);">
                    <h5 class="mb-1">
                        <span class="material-symbols-outlined align-middle me-1">lock</span>
                        {{ __('Change Password') }}
                    </h5>
                    <small>{{ __('Secure password tip') }}</small>
                </div>

                <div class="card-body p-4">
                    @include('profile.partials.update-password-form')
                </div>
            </div>


            <div class="card profile-card shadow mb-4">

                <div class="profile-card-header" style="background: linear-gradient(135deg, #dc3545, #ff6b81);">
                    <h5 class="mb-0">
                        <span class="material-symbols-outlined align-middle me-1">warning</span>
                        {{ __('Delete Account') }}
                    </h5>
                </div>

                <div class="card-body p-4">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

        </div>
    </div>
</div>

@endsection