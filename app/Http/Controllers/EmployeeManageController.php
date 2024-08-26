<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class EmployeeManageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            return response()->view('errors.403', [], 403);
        }

        $data = Employee::orderBy('id','desc')->get();

        // Add departments data to the view
        return view('admin.employeemanage.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departments = Department::all();
        return view('admin.employeemanage.create', compact('departments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'photo'=>'required|image|mimes:jpg,png,gif',
            'address'=>'required',
            'email'=>'required',

        ]);

        $photo=$request->file('photo');
        $renamePhoto=time().'.'.$photo->getClientOriginalExtension();
        $dest=public_path('/images');
        $photo->move($dest,$renamePhoto);

        $data=new Employee();
        $data->name=$request->name;
        $data->photo = $renamePhoto;
        $data->address=$request->address;
        $data->email=$request->email;
        $data->department_id=$request->department;

        $data->save();

        // Create a user for the employee
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make('password'),
            'role' => 'employee',
        ]);

        // Associate the user with the employee
        $data->user_id = $user->id;
        $data->save();

        return redirect('admin/employeemanage/create')->with('msg','Employee Created Successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        $departments = Department::all();
        $data = Employee::find($id);
        return view('admin.employeemanage.edit', compact('departments', 'data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name'=>'required',
            'address'=>'required',
            'email'=>'required',

        ]);

        if($request->hasFile('photo')){
            $photo=$request->file('photo');
            $renamePhoto=time().'.'.$photo->getClientOriginalExtension();
            $dest=public_path('/images');
            $photo->move($dest,$renamePhoto);
        }else{
            $renamePhoto=$request->prev_photo;
        }

        $data=Employee::find($id);
        $data->name=$request->name;
        $data->photo = $renamePhoto;
        $data->address=$request->address;
        $data->email=$request->email;
        $data->department_id=$request->department;

        $data->save();

        // Update the associated user data
        $user = User::find($data->user_id);
        if ($user) {
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();
    }

        return redirect('admin/employeemanage/'.$id.'/edit')->with('msg','Employee Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Employee::where('id',$id)->delete();
        return redirect('admin/employeemanage');
    }
}
