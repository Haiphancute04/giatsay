<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Twilio\Rest\Client;

class OtpLoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.otp-login');
    }

    public function sendOtp(Request $request)
    {
        $request->validate([
            'phone' => ['required', 'string', 'exists:users,phone'], 
        ], [
            'phone.exists' => 'Số điện thoại này chưa được đăng ký.',
            'phone.required' => 'Vui lòng nhập số điện thoại.',
        ]);

        $phone = $request->phone;

        $otp = rand(100000, 999999);

        Cache::put('otp_login_' . $phone, $otp, 300);
        try {
            $sid = env('TWILIO_SID');
            $token = env('TWILIO_TOKEN');
            $twilioNumber = env('TWILIO_FROM');
            if (!$sid || !$token || !$twilioNumber) {
                throw new \Exception('Chưa cấu hình Twilio trong file .env');
            }

            $client = new Client($sid, $token);
            $receiverNumber = $this->formatPhoneForSms($phone);

            $client->messages->create(
                $receiverNumber,
                [
                    'from' => $twilioNumber,
                    'body' => "Mã OTP của bạn là: $otp"
                ]
            );
            
            Log::info("Đã gửi SMS Twilio thành công đến $receiverNumber");

        } catch (\Exception $e) {
            Log::error("Lỗi Twilio: " . $e->getMessage());

            return back()->withErrors(['phone' => 'Lỗi gửi tin nhắn: ' . $e->getMessage()]);
        }

        return redirect()->route('otp.verify', ['phone' => $phone]);
    }

    public function showVerifyForm(Request $request)
    {
        $phone = $request->query('phone');
        
        if (!$phone) {
            return redirect()->route('otp.login');
        }

        return view('auth.otp-verify', compact('phone'));
    }

    public function loginWithOtp(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
            'otp' => 'required|numeric',
        ]);

        $phone = $request->phone;
        $enteredOtp = $request->otp;

        $cachedOtp = Cache::get('otp_login_' . $phone);

        if (!$cachedOtp || $cachedOtp != $enteredOtp) {
            throw ValidationException::withMessages([
                'otp' => ['Mã OTP không chính xác hoặc đã hết hạn.'],
            ]);
        }

        $user = User::where('phone', $phone)->first();

        if ($user) {
            Auth::login($user);
            Cache::forget('otp_login_' . $phone);
            $request->session()->regenerate();

            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors(['phone' => 'Không tìm thấy tài khoản.']);
    }

    private function formatPhoneForSms($phone)
    {
        if (substr($phone, 0, 1) === '0') {
            return '+84' . substr($phone, 1);
        }
        return $phone; 
    }
}