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
                        <li>
                            {{ $department->name }}
                            @if ($department->children->isNotEmpty())
                                <ul>
                                    @foreach ($department->children as $child)
                                        <li>
                                            {{ $child->name }}
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