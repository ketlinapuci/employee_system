<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            return response()->view('errors.403', [], 403);
        }

        return view('admin.dashboard');
    }

    public function editProfile()
    {
        $admin = Auth::user()->admin;
        return view('admin.edit-profile', compact('admin'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'current_password' => 'nullable',
            'new_password' => 'nullable|min:8|confirmed',
        ]);

        $admin = Auth::user()->admin;
        $user = Auth::user();

        // Update admin fields
        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->save();

        // Update user fields
        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('new_password')) {
            // Check if the current password is correct
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Current password is incorrect.']);
            }
            $user->password = Hash::make($request->new_password);
        }
        $user->save();

        return back()->with('msg', 'Profile updated successfully.');
    }
}
