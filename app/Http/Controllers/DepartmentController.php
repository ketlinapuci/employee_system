<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            return response()->view('errors.403', [], 403);
        }
        $departments = Department::whereNull('parent_id')->with('children')->get();

        // Add departments data to the view
        return view('admin.department.index', compact('departments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departments = Department::all();
        return view('admin.department.create', compact('departments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'=>'required',
            'parent_id' => 'nullable|exists:departments,id'
        ]);

        $data=new Department();
        $data->name=$request->title;
        $data->parent_id = $request->parent_id;
        $data->save();

        return redirect('admin/department/create')->with('msg','Department Created Successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('admin.department.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = Department::find($id);
        $departments = Department::all();
        return view('admin.department.edit', compact('data', 'departments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $request->validate([
            'title'=>'required',
            'parent_id' => 'nullable|exists:departments,id'
        ]);

        $data=Department::find($id);
        $data->name=$request->title;
        $data->parent_id = $request->parent_id;
        $data->save();

        return redirect('admin/department/'.$id.'/edit')->with('msg','Department has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Department::where('id',$id)->delete();
        return redirect('admin/department');
    }

    public function employees($id)
    {
        // Get employees under the selected department
        $employees = Employee::where('department_id', $id)->get();

        return response()->json($employees);
    }
}
