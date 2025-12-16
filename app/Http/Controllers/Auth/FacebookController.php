<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class FacebookController extends Controller
{
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function handleFacebookCallback()
    {
        try {
            $facebookUser = Socialite::driver('facebook')->user();

            $findUser = User::where('facebook_id', $facebookUser->id)->first();

            if ($findUser) {
                Auth::login($findUser);
                return redirect()->intended(route('admin.dashboard', absolute: false));
            }

            $existingUser = User::where('email', $facebookUser->email)->first();

            if ($existingUser) {
                $existingUser->update([
                    'facebook_id' => $facebookUser->id,
                ]);
                Auth::login($existingUser);
            } else {
                $newUser = User::create([
                    'name' => $facebookUser->name,
                    'email' => $facebookUser->email,
                    'facebook_id' => $facebookUser->id,
                    'avatar' => $facebookUser->avatar, 
                    'password' => Hash::make(Str::random(16)), 
                    'email_verified_at' => now(), 
                ]);
                Auth::login($newUser);
            }
  
            return redirect()->intended(route('home', absolute: false));

        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Đăng nhập Facebook thất bại.');
        }
    }
}