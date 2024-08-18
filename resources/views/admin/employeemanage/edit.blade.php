@extends('layouts.admin')

@section('title', 'Update Employee')

@section('content')
<div class="card mb-4 mt-4">
    <div class="card-header">
        <i class="fas fa-table me-1"></i>
        Update Employee
        <a href="{{url('admin/employeemanage')}}" class="float-end btn btn-sm btn-success">View All</a>
    </div>
    <div class="card-body">

        @if($errors->any())
            @foreach($errors->all() as $error)
                <p class="text-danger">{{$error}}</p>
            @endforeach
        @endif

        @if(Session::has('msg'))
        <p class="text-success">{{session('msg')}}</p>
        @endif
        <form method="post" action="{{url('admin/employeemanage/'.$data->id)}}" enctype="multipart/form-data">
            @method('put')
            @csrf
            <table class="table table-bordered">
                <tr>
                    <th>Name</th>
                    <td>
                        <input type="text" value="{{$data->name}}" name="name" class="form-control" />
                    </td>
                </tr>
                <tr>
                    <th>Photo</th>
                    <td>
                        <input type="file" value="{{$data->photo}}" name="photo" class="form-control" />
                        <p>
                            <img src="{{asset('images/'.$data->photo)}}" width="200" />
                            <input type="hidden" name="prev_photo" value="{{$data->photo}}" />
                        </p>
                    </td>
                </tr>
                <tr>
                    <th>Address</th>
                    <td>
                        <input type="text" value="{{$data->address}}" name="address" class="form-control" />
                    </td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>
                        <input type="email" value="{{$data->email}}" name="email" class="form-control" />
                    </td>
                </tr>
                <tr>
                    <th>Department</th>
                    <td>
                        <select name="department" class="form-control">
                            <option value="">-- Select Department --</option>
                            @foreach($departments as $department)
                                <option @if($department->id==$data->department_id) selected @endif value="{{$department->id}}">{{$department->name}}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" class="btn btn-primary" value="Submit" />
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>

@endsection