<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
    }
    
    public function show(User $user)
    {
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'role' => ['required', Rule::in(['user', 'admin'])],
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($validated['password']);
        }
        
        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', __('User updated successfully!'));
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')->with('error', __('Cannot delete own account.'));
        }

        $user->delete();
        return redirect()->route('admin.users.index')->with('success', __('User deleted successfully!'));
    }
}