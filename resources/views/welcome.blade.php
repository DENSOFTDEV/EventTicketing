@extends('layouts.app')

@section('content')
    <!-- Header-->
    <header class="banner"
            style="background-image: url({{asset('/frontend/assets/banner.jpg')}}); background-repeat: no-repeat; background-size: cover">
        <div class="content py-5">
            <div class="container px-4 px-lg-5 my-5">
                <div class="text-center text-white">
                    <h1 class="display-4 fw-bolder">Laugh Show</h1>
                    <p class="lead font-weight-bold mb-0" style="font-size: 30px">Alluring comedy experience</p>
                </div>
            </div>
        </div>
    </header>
    <!-- Section-->
    <customer-events></customer-events>
@endsection
