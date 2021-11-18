<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <meta name="description" content=""/>
    <meta name="author" content=""/>
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="{{asset('/frontend/assets/favicon.ico')}}}"/>

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet"/>
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="{{asset('/frontend/css/styles.css')}}" rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
    <style>
        #page-container {
            position: relative;
            min-height: 100vh;
        }

        #content-wrap {
            padding-bottom: 100px;    /* Footer height */
        }

        #footer {
            position: absolute;
            bottom: 0;
            width: 100%;
        }
    </style>

</head>
<body id="page-container">
<div id="app">
    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container px-4 px-lg-5">
            <a class="navbar-brand" href="{{route('welcome')}}">
                <img src="{{asset('frontend/assets/logo.png')}}" style="width: 200px" class="img-fluid" alt="">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span
                    class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                    <li class="nav-item"><a class="nav-link {{ (request()->is('/')) ? 'active' : '' }}"
                                            aria-current="page" href="{{route('welcome')}}">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#!">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="#!">Contact Us</a></li>
                </ul>
                <form class="d-flex">
                    @guest
                        <a href="{{route('register')}}" class="btn btn-outline-success mr-2">
                            Sign Up
                        </a>

                        <a class="btn btn-success" href="{{route('login')}}">
                            Sign In
                        </a>
                    @else
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button"
                                   data-bs-toggle="dropdown"
                                   aria-expanded="false">{{ucwords(\Illuminate\Support\Facades\Auth::user()->name)}}</a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <li><a class="dropdown-item" href="{{route('home')}}">Account</a></li>
                                    <li>
                                        <hr class="dropdown-divider"/>
                                    </li>
                                    <li><a class="dropdown-item" href="{{route('logout')}}"
                                           onclick="event.preventDefault(); document.getElementById('logout-form-one').submit();">
                                            Logout
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    @endguest
                </form>
                <form id="logout-form-one" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </div>
    </nav>
<div id="content-wrap">
    @yield('content')
</div>
<!-- Footer-->
    <footer id="footer" class="footer mt-auto py-5 bg-dark">
        <div class="container"><p class="m-0 text-center text-white">Copyright &copy; {{config('app.name')}} 2021</p>
        </div>
    </footer>
</div>
<script src="{{ asset('js/app.js') }}"></script>
<!-- Bootstrap core JS-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Core theme JS-->
<script src="{{asset('/frontend/js/scripts.js')}}"></script>
<script type="text/javascript">
    $(document).ready(function () {
        let passInput = document.getElementById("password");
        let passIcon = $("#visibility");
        $("#passwordClick").click(function () {
            if (passInput.type === "password") {
                passInput.type = "text"

                passIcon.removeClass("fa fa-eye")
                passIcon.addClass("fas fa-eye-slash")
            } else {
                passInput.type = "password"
                passIcon.removeClass("fas fa-eye-slash")
                passIcon.addClass("fa fa-eye")
            }
        });

        let passInput2 = document.getElementById("password_confirmation");
        let passIcon2 = $("#visibility-confirmation");
        $("#password_click_confirmation").click(function () {
            if (passInput2.type === "password") {
                passInput2.type = "text"

                passIcon2.removeClass("fa fa-eye")
                passIcon2.addClass("fas fa-eye-slash")
            } else {
                passInput2.type = "password"
                passIcon2.removeClass("fas fa-eye-slash")
                passIcon2.addClass("fa fa-eye")
            }
        });
    })
</script>
</body>
</html>
