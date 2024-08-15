@extends('layouts.employee')

@section('title', 'Employee Dashboard')

@section('content')
    <h3>Welcome, {{ Auth::user()->name }}</h3>
    <!-- Employee dashboard content -->
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>
@endsection
