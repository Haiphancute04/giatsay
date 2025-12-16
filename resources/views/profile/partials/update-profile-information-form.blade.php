<form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data"> @csrf
    @method('patch')

    @if (session('status') === 'profile-updated')
        <div class="alert alert-success">{{ __('Saved successfully') }}</div>
    @endif

    <div class="mb-3">
        <label for="avatar" class="form-label">{{ __('Avatar') }}</label>
        
        {{-- Custom File Input để hiển thị được ngôn ngữ mong muốn --}}
        <div class="input-group">
            <label class="input-group-text btn btn-outline-secondary" for="avatar" style="cursor: pointer;">
                {{ __('Choose File') }}
            </label>
            <input type="text" class="form-control bg-white text-muted" readonly id="file-name-display" 
                   placeholder="{{ __('No file chosen') }}" 
                   onclick="document.getElementById('avatar').click()" style="cursor: pointer;">
        </div>

        {{-- Input file gốc bị ẩn đi (d-none) nhưng vẫn hoạt động --}}
        <input class="d-none @error('avatar') is-invalid @enderror" type="file" id="avatar" name="avatar" accept="image/*"
               onchange="handleFileSelect(this)">
        
        @error('avatar')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
        
        <div class="mt-2 d-flex align-items-center">
            <img src="{{ $user->avatar_url }}" alt="Avatar" 
                style="width: 80px; height: 80px; object-fit: cover; border-radius: 50%;">
            
            <small class="ms-2 text-muted">
                {{ $user->avatar ? __('Current image') : __('Default image') }}
            </small>
        </div>
    </div>

    <div class="mb-3">
        <label for="name" class="form-label">{{ __('Full name') }}</label>
        <input id="name" name="name" type="text" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required autofocus>
        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    
    <div class="mb-3">
        <label for="email" class="form-label">{{ __('Email') }}</label>
        <input id="email" name="email" type="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required>
        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="phone" class="form-label">{{ __('Phone number') }}</label>
        <input id="phone" name="phone" type="text" 
               class="form-control @error('phone') is-invalid @enderror" 
               value="{{ old('phone', $user->phone) }}" 
               placeholder="{{ __('Enter contact phone number') }}">
        @error('phone')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="address" class="form-label">{{ __('Address') }}</label>
        <textarea id="address" name="address" rows="3"
                  class="form-control @error('address') is-invalid @enderror" 
                  placeholder="{{ __('Address Example') }}">{{ old('address', $user->address) }}</textarea>
        @error('address')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>

    {{-- Script nhỏ để cập nhật tên file khi người dùng chọn --}}
    <script>
        function handleFileSelect(input) {
            const display = document.getElementById('file-name-display');
            if (input.files && input.files.length > 0) {
                display.value = input.files[0].name;
                display.classList.remove('text-muted');
            } else {
                display.value = '';
                display.classList.add('text-muted');
            }
        }
    </script>
</form>