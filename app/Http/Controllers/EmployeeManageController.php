<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeManageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Employee::orderBy('id','desc')->get();

        // Add departments data to the view
        return view('admin.employeemanage.index', compact('data'));    }

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
        // var_dump($request->name, $request->file('photo'));
        // die;
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
