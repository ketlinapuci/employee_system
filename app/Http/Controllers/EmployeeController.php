<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    public function index()
    {
        if (!Auth::check() || !Auth::user()->isEmployee()) {
            return response()->view('errors.403', [], 403);
        }

        return view('employee.dashboard');
    }


    public function editProfile()
    {
        $employee = Auth::user()->employee;
        return view('employee.edit-profile', compact('employee'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'photo' => 'nullable|image|mimes:jpg,png,gif',
            'address' => 'required',
            'email' => 'required|email',
            'current_password' => 'nullable',
            'new_password' => 'nullable|min:8|confirmed',
        ]);

        $user = Auth::user();
        $employee = $user->employee;

        // Validate current password if a new password is provided
        if ($request->filled('new_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return redirect()->route('employee.profile.edit')
                                 ->withErrors(['current_password' => 'Current password is incorrect']);
            }

            $user->password = Hash::make($request->new_password);
        }

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $renamePhoto = time() . '.' . $photo->getClientOriginalExtension();
            $dest = public_path('/images');
            $photo->move($dest, $renamePhoto);

            if ($employee->photo && file_exists(public_path('/images/' . $employee->photo))) {
                unlink(public_path('/images/' . $employee->photo));
            }

            $employee->photo = $renamePhoto;
        }

        $employee->name = $request->name;
        $employee->address = $request->address;
        $employee->email = $request->email;
        $employee->save();

        // Update the user data
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        return redirect()->route('employee.profile.edit')->with('msg', 'Profile Updated Successfully!');
    }
}
