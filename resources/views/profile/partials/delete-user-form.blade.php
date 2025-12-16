<p class="text-muted">
    {{ __('Delete Account Warning') }}
</p>

{{-- Hiển thị lỗi xác thực (validation errors) --}}
@if ($errors->userDeletion->has('password'))
    <div class="alert alert-danger" role="alert">
        {{ $errors->userDeletion->first('password') }}
    </div>
@endif

<form method="post" action="{{ route('profile.destroy') }}" onsubmit="return confirm('{{ __('Delete Confirmation Question') }}');">
    @csrf
    @method('delete')

    {{-- TRƯỜNG NHẬP MẬT KHẨU HIỆN TẠI (ĐÃ THÊM) --}}
    <div class="mb-3">
        <label for="password_confirmation" class="form-label">{{ __('Current Password') }}</label>
        <input 
            id="password_confirmation" 
            name="password" 
            type="password" 
            class="form-control" 
            placeholder="{{ __('Enter your password to confirm') }}"
            required>
    </div>
    {{-- KẾT THÚC TRƯỜNG NHẬP MẬT KHẨU --}}

    <button type="submit" class="btn btn-danger">{{ __('Delete Account') }}</button>
</form>