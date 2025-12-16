<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user(); 
            $user = User::where('google_id', $googleUser->id)
                        ->orWhere('email', $googleUser->email)
                        ->first();

            if ($user) {
                if (!$user->google_id) {
                    $user->google_id = $googleUser->id;
                    $user->save();
                }
                
                Auth::login($user);
                if ($user->role === 'admin') {
                    return redirect()->route('admin.dashboard');
                }

                return redirect()->intended(route('home')); 

            } else {
                $newUser = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'google_id' => $googleUser->id,
                    'avatar' => $googleUser->avatar,
                    'password' => Hash::make(Str::random(16)),
                ]);

                Auth::login($newUser);
                if ($newUser->role === 'admin') {
                    return redirect()->route('admin.dashboard');
                }

                return redirect()->intended(route('home'));
            }

        } catch (\Exception $e) {
            Log::error('Lỗi đăng nhập Google: ' . $e->getMessage());
            
            return redirect()->route('login')->with('error', 'Đăng nhập Google thất bại. Vui lòng thử lại.');
        }
    }
}