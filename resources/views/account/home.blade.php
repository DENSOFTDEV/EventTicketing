@extends('home')
@section('subsection')
    <div class="card">
        <div class="card-header">
            <p>Dashboard</p>
        </div>
        <div class="card-body">
            <p>Welcome {{ucwords(\Illuminate\Support\Facades\Auth::user()->name)}}</p>
        </div>
    </div>
@endsection
