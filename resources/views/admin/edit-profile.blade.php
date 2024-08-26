@extends('layouts.admin')

@section('title', 'Edit Profile')

@section('content')
<div class="card mb-4 mt-4">
    <div class="card-header">
        <i class="fas fa-user me-1"></i>
        Edit Profile
    </div>
    <div class="card-body">

        @if($errors->any())
            @foreach($errors->all() as $error)
                <p class="text-danger">{{ $error }}</p>
            @endforeach
        @endif

        @if(Session::has('msg'))
            <p class="text-success">{{ session('msg') }}</p>
        @endif

        <form method="post" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" value="{{ $admin->name }}" class="form-control" />
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="{{ $admin->email }}" class="form-control" />
            </div>

            <div class="form-group">
                <label for="current_password">Current Password</label>
                <input type="password" id="current_password" name="current_password" class="form-control" />
            </div>

            <div class="form-group">
                <label for="new_password">New Password</label>
                <input type="password" id="new_password" name="new_password" class="form-control" />
            </div>

            <div class="form-group">
                <label for="new_password_confirmation">Confirm New Password</label>
                <input type="password" id="new_password_confirmation" name="new_password_confirmation" class="form-control" />
            </div>

            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Update Profile" />
            </div>
        </form>
    </div>
</div>
@endsection
