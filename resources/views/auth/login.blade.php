@extends('layouts.app')

@section('content')
    <section class="py-5">
        <div class="container px-5">
            <!-- Contact form-->
            <div class="bg-light card rounded-3 py-5 px-4 px-md-5 mb-5">
                <div class="text-center mb-5">
                    <h1 class="fw-bolder">Login</h1>
                    <p class="lead fw-normal text-muted mb-0">Welcome Back</p>
                </div>
                <div class="row gx-5 justify-content-center">
                    <div class="col-lg-8 col-xl-6">
                        <form role="form" method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="form-group">
                                <label for="email">E-mail Address</label>
                                <div class="input-group mb-3">
                                    <input id="email" name="email" type="email" class="form-control @error('email') is-invalid @enderror" placeholder="E-mail Address">
                                    <div class="input-group-text" id="basic-addon1">
                                        <span  class="fa fa-envelope"></span>
                                    </div>
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong class="text-danger">{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="password">Password</label>
                                <div class="input-group mb-3">
                                    <input id="password" name="password" type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password">
                                    <div class="input-group-text" id="passwordClick">
                                        <span id="visibility" class="fa fa-eye"></span>
                                    </div>
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong class="text-danger">{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember"
                                           id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary btn-block">Login</button>
                        </form>

                        <div class="mt-3">
                            <a style="text-decoration: none" href="{{route('password.request')}}" class="text-success">Forgot Password?</a>
                            <span style="float: right; text-decoration: none">
                                        <a href="{{route('register')}}" class="text-success mb-2">Create Account</a>
                                    </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
