@extends('layouts.admin')

@section('title', 'Employee Management')

@section('content')
    <div class="container-fluid px-4">
        <h3 class="mt-4">Employees</h3>
        <!-- Tree view for departments -->
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                All Employees
                <a href="{{url('admin/employeemanage/create')}}" class="float-end btn btn-sm btn-success">Add New</a>
            </div>
            <div class="card-body">
                <table id="datatablesSimple" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Department</th>
                            <th>Name</th>
                            <th>Photo</th>
                            <th>Address</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Department</th>
                            <th>Name</th>
                            <th>Photo</th>
                            <th>Address</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @if($data)
                            @foreach($data as $d)
                            <tr>
                                <td>{{$d->id}}</td>
                                <td>{{$d->name}}</td>
                                <td>{{$d->name}}</td>
                                <td><img src="{{asset('images/'.$d->photo)}}" width="80" /></td>
                                <td>{{$d->address}}</td>
                                <td>
                                    <a href="{{url('admin/employeemanage/'.$d->id.'/edit')}}" class="btn btn-info btn-sm">Update</a>
                                    <a onclick="return confirm('Are you sure to delete this data?')" href="{{url('admin/employeemanage/'.$d->id.'/delete')}}" class="btn btn-danger btn-sm">Delete</a>
                                </td>
                            </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        </div>
    </div>
@endsection
