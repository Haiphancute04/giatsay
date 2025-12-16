<form method="post" action="{{ route('password.update') }}">
    @csrf
    @method('put')

    @if (session('status') === 'password-updated')
        <div class="alert alert-success">{{ __('Password updated') }}</div>
    @endif

    <div class="mb-3">
        <label for="update_password_current_password" class="form-label">{{ __('Current Password') }}</label>
        <input id="update_password_current_password" name="current_password" type="password" class="form-control @error('current_password', 'updatePassword') is-invalid @enderror" required>
        @error('current_password', 'updatePassword')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="update_password_password" class="form-label">{{ __('New Password') }}</label>
        <input id="update_password_password" name="password" type="password" class="form-control @error('password', 'updatePassword') is-invalid @enderror" required>
        @error('password', 'updatePassword')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="update_password_password_confirmation" class="form-label">{{ __('Confirm New Password') }}</label>
        <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
</form>