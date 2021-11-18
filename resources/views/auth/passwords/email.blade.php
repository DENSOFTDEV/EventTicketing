@extends('layouts.app')

@section('content')
    <section class="py-5">
        <div class="container px-5">
            <!-- Contact form-->
            <div class="bg-light card rounded-3 py-5 px-4 px-md-5 mb-5">
                <div class="text-center mb-5">
                    <h1 class="fw-bolder">Forgot Password</h1>
                    <p class="lead fw-normal text-muted mb-0">Please enter a registered email address</p>
                </div>
                <div class="row gx-5 justify-content-center">
                    <div class="col-lg-8 col-xl-6">

                        @if (session('status'))
                            <div class="text-center">
                                <p class="text-success">{{ session('status') }}</p>
                            </div>
                        @endif


                        <form role="form" method="POST" action="{{  route('password.email') }}">
                            @csrf
                            <div class="form-group">
                                <label for="email">E-mail Address</label>
                                <div class="input-group mb-3">
                                    <input id="email" name="email"
                                           type="email" class="form-control @error('email') is-invalid @enderror"
                                           value="{{ old('email') }}"
                                           placeholder="E-mail Address">
                                    <div class="input-group-text" id="basic-addon1">
                                        <span class="fa fa-envelope"></span>
                                    </div>
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong class="text-danger">{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>


                            <button type="submit" class="btn btn-primary btn-block">Send Reset Password Link</button>
                        </form>

                        <div class="mt-3">
                            <a style="text-decoration: none" href="{{route('login')}}" class="text-success">Login</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
