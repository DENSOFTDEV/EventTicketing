@extends('admin.layouts.admin_auth_layout')

@section('content')
    <div class="card-body">
        <p class="login-box-msg">Sign in to start your session</p>

        <form action="{{route('admin.login')}}" method="post">
            @csrf
            <div class="input-group mb-3">
                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                       placeholder="Email">
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-envelope"></span>
                    </div>
                </div>
                @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="input-group mb-3">
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="passInput"
                       name="password" placeholder="Password">
                <div class="input-group-append">
                    <div class="input-group-text" id="passwordClick">
                        <span id="visibility" class="fas fa-eye"></span>
                    </div>
                </div>
                @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="input-group mb-3">
                <div class="icheck-primary">
                    <input type="checkbox" id="remember">
                    <label for="remember">
                        Remember Me
                    </label>
                </div>
            </div>
            <div class="input-group mb-3">
                <button type="submit" class="btn btn-primary btn-block">Sign In</button>
            </div>
        </form>
        <p class="mb-1">
            <a href="{{route('admin.password.request')}}">Forgot my password ?</a>
        </p>
    </div>
@endsection
