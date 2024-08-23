@extends('layouts.admin')

@section('title', 'Chat Dashboard')

@section('content')
    <div class="container-fluid px-4">
        <h3 class="mt-4">Chat</h3>
        <div class="row">
            <div class="col-lg-6">
                <div class="list-group">
                    @foreach($users as $user)
                        <a href="{{ url('chat/' . $user->id) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            <span>{{ $user->name }}</span>
                            <span class="badge bg-primary rounded-pill">Chat</span>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
