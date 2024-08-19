<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller
{
    public function index()
    {
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
        ]);

        $employee = Auth::user()->employee;

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

        return redirect()->route('employee.profile.edit')->with('msg', 'Profile Updated Successfully!');
    }
}
