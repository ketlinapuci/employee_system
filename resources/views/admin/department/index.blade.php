@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
    <div class="container-fluid px-4">
        <h3 class="mt-4">DEPARTMENTS</h3>
        <!-- Tree view for departments -->
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                All Departments
                <a href="{{url('admin/department/create')}}" class="float-end btn btn-sm btn-success">Add New</a>
            </div>
            <div class="card-body">
                <ul id="department-tree">
                    @foreach ($departments as $department)
                        <li style="margin-bottom: 10px;">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>{{ $department->name }}</div>
                                <div>
                                    <a href="{{ url('admin/department/' . $department->id . '/edit') }}" class="btn btn-info btn-sm">Update</a>
                                    <a onclick="return confirm('Are you sure to delete this data?')" href="{{ url('admin/department/' . $department->id . '/delete') }}" class="btn btn-danger btn-sm">Delete</a>
                                </div>
                            </div>
                            @if ($department->children->isNotEmpty())
                                <ul style="padding-left: 20px;">
                                    @foreach ($department->children as $child)
                                        <li style="margin-bottom: 10px;">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>{{ $child->name }}</div>
                                                <div>
                                                    <a href="{{ url('admin/department/' . $child->id . '/edit') }}" class="btn btn-info btn-sm" style="margin-top: 5px;">Update</a>
                                                    <a onclick="return confirm('Are you sure to delete this data?')" href="{{ url('admin/department/' . $child->id . '/delete') }}" class="btn btn-danger btn-sm" style="margin-top: 5px;">Delete</a>
                                                </div>
                                            </div>
                                            @if ($child->children->isNotEmpty())
                                                @include('admin.department.tree', ['children' => $child->children])
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection
