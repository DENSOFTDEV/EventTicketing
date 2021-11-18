@extends('layouts.app')

@section('content')
    <section class="py-5">
        <div class="container px-5">
            <!-- Contact form-->
            <div class="bg-light card rounded-3 py-5 px-4 px-md-5 mb-5">
                <div class="text-center mb-5">
                    <h1 class="fw-bolder">Reset Password</h1>
                    <p class="lead fw-normal text-muted mb-0">Welcome Back</p>
                </div>
                <div class="row gx-5 justify-content-center">
                    <div class="col-lg-8 col-xl-6">
                        <form role="form" method="POST" action="{{ route('password.update') }}">
                            @csrf

                            <input type="hidden" name="token" value="{{ $token }}">

                            <div class="form-group">
                                <label for="email">E-mail Address</label>
                                <div class="input-group mb-3">
                                    <input id="email" name="email" type="email"
                                           class="form-control @error('email') is-invalid @enderror"
                                           value="{{ $email ?? old('email') }}"
                                           placeholder="E-mail Address">
                                    <div class="input-group-text">
                                        <span class="fa fa-envelope"></span>
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
                                    <input id="password" name="password" type="password"
                                           class="form-control @error('password') is-invalid @enderror"
                                           placeholder="Password">
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
                                <label for="password-confirm"
                                       class="col-form-label text-md-right">Confirm Password</label>
                                <div class="input-group mb-3">
                                    <input id="password_confirmation" name="password_confirmation" type="password"
                                           class="form-control"
                                           autocomplete="new-password"
                                           placeholder="Confirm Password">
                                    <div class="input-group-text" id="password_click_confirmation">
                                        <span id="visibility-confirmation" class="fa fa-eye"></span>
                                    </div>
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong class="text-danger">{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>


                            <button type="submit" class="btn btn-primary btn-block">Reset Password</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
