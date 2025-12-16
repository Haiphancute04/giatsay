<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Nhập số điện thoại đã đăng ký để đăng nhập bằng mã OTP.') }}
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('otp.send') }}">
        @csrf

        <div>
            <x-input-label for="phone" :value="__('Số điện thoại')" />
            <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone')" required autofocus />
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                {{ __('Quay lại Login thường') }}
            </a>

            <x-primary-button class="ms-3">
                {{ __('Gửi mã OTP') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>