@extends('layouts.app')

@section('content')
    <header class="banner"
            style="background-image: url({{$event->large_poster_url}}); background-repeat: no-repeat; background-size: cover">
        <div class="content py-5">
            <div class="container px-4 px-lg-5 my-5">
                <div class="text-center text-white">
                    <h1 class="display-4 fw-bolder">{{$event->name}}</h1>
                    <p class="lead font-weight-bold mb-0" style="font-size: 30px">{{$event->hashTag}}</p>
                    <p><span class="mr-2"
                             style="font-size: 20px">Date:</span>{{\Carbon\Carbon::parse($event->happening_date.' '.$event->happening_time)->isoFormat("MMM Do YYYY, h:mm:ss a")}}
                    </p>
                    <span
                        class="badge bg-success p-3"><h4>{{\Carbon\Carbon::parse($event->happening_date.' '.$event->happening_time)->diffForHumans()}}</h4></span>
                </div>
            </div>
        </div>
    </header>
    <!-- Section-->
    <section class="py-5">
        <div class="container px-4  mt-2">
            <div class="row ">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body text-center">
                            <span class="mr-2" style="font-size: 20px"><span
                                    class="font-weight-bold text-success">Location:</span> {{\App\Models\Location::find($event->location)->name}}</span>
                            <span class="mr-2" style="font-size: 20px"><span class="font-weight-bold text-success">Venue:</span> {{$event->venue}}</span>
                            <span class="mr-2" style="font-size: 20px"><span class="font-weight-bold text-success">Duration:</span> {{$event->duration}} hrs</span>
                        </div>
                    </div>
                </div>
            </div>
            <customer-ticket-pricing :event="{{$event}}"></customer-ticket-pricing>
            @auth()
                <ticket-reservation :event="{{$event}}"></ticket-reservation>
            @else
               <div style="margin-top: 20px">
                   <a class="btn btn-success btn-block my-5" href="{{route('login')}}">Login to make a reservation</a>
               </div>
            @endauth
        </div>
    </section>
@endsection
