@extends('layouts.admin')

@section('title', __('Edit User') . ': ' . $user->name)

@section('content')

<div class="card-wrapper col-md-8 mx-auto">

    <h3 class="fw-bold mb-4">✏️ {{ __('Edit User') }}: {{ $user->name }}</h3>

    {{-- ALERTS --}}
    @if (session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
    @if (session('error')) <div class="alert alert-danger">{{ session('error') }}</div> @endif

    {{-- FORM --}}
    <form action="{{ route('admin.users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Avatar Section with Custom Input --}}
        <div class="mb-4">
            <label for="avatar" class="form-label fw-bold">{{ __('Avatar') }}</label>
            
            <div class="input-group">
                <label class="input-group-text btn btn-outline-secondary" for="avatar" style="cursor: pointer;">
                    {{ __('Choose File') }}
                </label>
                <input type="text" class="form-control bg-white text-muted" readonly id="file-name-display-avatar" 
                       placeholder="{{ __('No file chosen') }}" 
                       onclick="document.getElementById('avatar').click()" style="cursor: pointer;">
            </div>
            
            <input class="d-none @error('avatar') is-invalid @enderror" type="file" id="avatar" name="avatar" accept="image/*"
                   onchange="document.getElementById('file-name-display-avatar').value = this.files[0] ? this.files[0].name : ''">
                   
            @error('avatar') <div class="text-danger small mt-1">{{ $message }}</div> @enderror

            {{-- Logic hiển thị ảnh preview --}}
            @php
                $avatarSrc = asset('assets/img/default-user.png');
                if ($user->avatar) {
                    if (Str::startsWith($user->avatar, ['http://', 'https://'])) {
                        $avatarSrc = $user->avatar;
                    } else {
                        $avatarSrc = asset('storage/' . $user->avatar);
                    }
                }
            @endphp

            <div class="mt-3 d-flex align-items-center gap-3">
                <img src="{{ $avatarSrc }}" 
                     alt="Avatar Preview" 
                     class="avatar-preview shadow-sm"
                     style="width: 80px; height: 80px; object-fit: cover; border-radius: 50%;">
                
                <div>
                    <small class="text-muted d-block">{{ __('Current Image') }}</small>
                    @if($user->google_id || $user->facebook_id)
                        <span class="badge bg-secondary mt-1">MXH</span>
                    @endif
                </div>
            </div>
        </div>

        <hr>

        {{-- Group 1: Thông tin tài khoản --}}
        <h5 class="mb-3 text-primary">{{ __('Account Information') }}</h5>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="name" class="form-label">{{ __('Display Name') }} <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            
            <div class="col-md-6 mb-3">
                <label for="username" class="form-label">{{ __('Username') }}</label>
                <div class="input-group">
                    <span class="input-group-text bg-light">@</span>
                    <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" value="{{ old('username', $user->username) }}">
                </div>
                @error('username')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>

        {{-- Group 2: Thông tin liên lạc --}}
        <h5 class="mb-3 text-primary mt-2">{{ __('contact') }}</h5>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="email" class="form-label">{{ __('Email') }} <span class="text-danger">*</span></label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="col-md-6 mb-3">
                <label for="phone" class="form-label">{{ __('Phone number') }}</label>
                <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone', $user->phone) }}">
                @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="mb-3">
            <label for="address" class="form-label">{{ __('Address') }}</label>
            <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="2">{{ old('address', $user->address) }}</textarea>
            @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        {{-- Group 3: Quyền hạn --}}
        <div class="mb-3">
            <label for="role" class="form-label fw-bold">{{ __('Role') }}</label>
            <select class="form-select @error('role') is-invalid @enderror" id="role" name="role" {{ $user->id === auth()->id() ? 'disabled' : '' }}>
                <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>User ({{ __('Member') }})</option>
                <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin ({{ __('Administrator') }})</option>
            </select>
            @if ($user->id === auth()->id())
                <small class="text-danger">{{ __('Cannot change own role') }}</small>
            @endif
            @error('role')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <hr>
        
        {{-- Group 4: Đổi mật khẩu --}}
        <h5 class="text-danger">{{ __('Change Password Optional') }}</h5>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="password" class="form-label">{{ __('New Password') }}</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" autocomplete="new-password">
                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="col-md-6 mb-3">
                <label for="password_confirmation" class="form-label">{{ __('Confirm New Password') }}</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" autocomplete="new-password">
            </div>
        </div>

        {{-- Buttons --}}
        <div class="d-flex gap-2 mt-4">
            <button type="submit" class="btn btn-primary btn-action px-4">
                <span class="material-symbols-outlined">save</span>
                {{ __('Update') }}
            </button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-action px-4">
                <span class="material-symbols-outlined">arrow_back</span>
                {{ __('Cancel') }}
            </a>
        </div>
    </form>
</div>
@endsection