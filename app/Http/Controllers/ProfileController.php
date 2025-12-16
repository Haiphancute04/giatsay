<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage; 
use Illuminate\Support\Facades\Hash; 

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        
        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $user->avatar = $request->file('avatar')->store('avatars', 'public');
        }

        $validatedData = $request->validated();
        if (isset($validatedData['avatar'])) {
            unset($validatedData['avatar']);
        }

        $user->fill($validatedData);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required'], 
        ], [
            'password.required' => 'Vui lòng nhập mật khẩu hiện tại của bạn để xác nhận.',
        ]);

        $user = $request->user();

        if (!Hash::check($request->password, $user->password)) {
            return Redirect::back()->withErrors([
                'password' => 'Mật khẩu bạn nhập không đúng. Vui lòng kiểm tra lại.'
            ], 'userDeletion');
        }
        
        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }

        Auth::logout();
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}