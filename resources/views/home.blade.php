@extends('layouts.app')

@section('content')
    <section class="py5">
        <div class="container my-5">
            <div class="row">
                <div class="col-md-2">
                    <div class="card">
                        <div class="card-header">
                            <p>Menu</p>
                        </div>
                        <div class="card-body">
                            <ul class="nav nav-pills flex-column">
                                <li class="nav-item">
                                    <a class="nav-link {{ (request()->is('home')) ? 'active' : '' }}" aria-current="page"
                                       href="{{route('home')}}">Dashboard</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ (request()->is('tickets')) ? 'active' : '' }}" href="{{route('tickets')}}">Tickets</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ (request()->is('payments')) ? 'active' : '' }}" href="{{route('payments')}}">Payments</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ (request()->is('account')) ? 'active' : '' }}" href="{{route('account')}}">Account</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">Logout</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-10">
                    @yield('subsection')
                </div>
            </div>
        </div>
    </section>
@endsection
