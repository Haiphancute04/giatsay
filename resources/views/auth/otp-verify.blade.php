<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Mã xác thực đã được gửi đến số điện thoại') }} <strong>{{ $phone }}</strong>.
        <br>
        {{ __('Vui lòng kiểm tra console/log (nếu đang test) hoặc điện thoại của bạn.') }}
    </div>

    <form method="POST" action="{{ route('otp.confirm') }}">
        @csrf
        
        <input type="hidden" name="phone" value="{{ $phone }}">

        <div>
            <x-input-label for="otp" :value="__('Nhập mã OTP (6 số)')" />
            <x-text-input id="otp" class="block mt-1 w-full text-center text-xl tracking-widest font-bold" 
                          type="text" name="otp" required autofocus maxlength="6" />
            <x-input-error :messages="$errors->get('otp')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
             <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('otp.login') }}">
                {{ __('Gửi lại mã?') }}
            </a>

            <x-primary-button class="ms-3">
                {{ __('Xác nhận') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>