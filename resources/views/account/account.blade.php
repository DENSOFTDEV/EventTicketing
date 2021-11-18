@extends('home')
@section('subsection')
    <div class="card">
        <div class="card-header">
            <p>Account</p>
        </div>
        <div class="card-body">
            <p>{{\Illuminate\Support\Facades\Auth::user()->name}}</p>
            <p>{{\Illuminate\Support\Facades\Auth::user()->email}}</p>
        </div>
    </div>
@endsection
