@extends('layouts.admin')

@section('title', 'Add Department')

@section('content')
<div class="card mb-4 mt-4">
    <div class="card-header">
        <i class="fas fa-table me-1"></i>
        Create Department
        <a href="{{url('admin/department')}}" class="float-end btn btn-sm btn-success">View All</a>
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
        <form method="post" action="{{url('admin/department')}}">
            @csrf
            <table class="table table-bordered">
                <tr>
                    <th>Name</th>
                    <td>
                        <input type="text" name="title" class="form-control" />
                    </td>
                </tr>
                <tr>
                    <th>Parent Department</th>
                    <td>
                        <select name="parent_id" class="form-control">
                            <option value="">-- Select Parent Department --</option>
                            @foreach($departments as $department)
                                <option value="{{ $department->id }}">{{ $department->name }}</option>
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