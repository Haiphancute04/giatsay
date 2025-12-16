@extends('layouts.app')

@section('title', 'Quên mật khẩu')

@section('content')

<div class="row justify-content-center mt-5">
    <div class="col-md-5">
        <div class="card shadow-lg">
            <div class="card-header text-center bg-primary text-white">
                <h4 class="mb-0">
                    Khôi phục mật khẩu
                </h4>
            </div>

            <div class="card-body p-4">

                <p class="text-muted mb-4">
                    Nhập email của bạn và hệ thống sẽ gửi liên kết đặt lại mật khẩu.
                </p>

                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>

                        <div class="input-group">
                            <span class="input-group-text bg-light">
                                <span class="material-symbols-outlined"> mail </span>
                            </span>

                            <input id="email" class="form-control @error('email') is-invalid @enderror"
                                type="email" name="email" value="{{ old('email') }}"
                                placeholder="Nhập email của bạn" required autofocus>
                        </div>

                        @error('email')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit" class="btn btn-primary px-4 d-flex align-items-center">
                            <span class="material-symbols-outlined me-1"> mail </span>
                            Gửi liên kết đặt lại mật khẩu
                        </button>
                    </div>

                    <div class="mt-4 text-center">
                        <a href="{{ route('login') }}" class="text-decoration-none d-inline-flex align-items-center">
                            <span class="material-symbols-outlined me-1" style="font-size: 18px;"> arrow_back </span>
                            Quay về đăng nhập
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

@endsection
