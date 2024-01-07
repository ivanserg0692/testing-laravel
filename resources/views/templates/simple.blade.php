<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        @vite('resources/sass/app.scss')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    </head>
    <body>

    <!-- Navigation Menu with Login Block and Icons-->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Navbar</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                @auth()
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Link</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Dropdown
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="#">Action</a></li>
                            <li><a class="dropdown-item" href="#">Another action</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#">Something else here</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
                    </li>
                </ul>
                @else

                    <ul class="navbar-nav me-auto mb-2 mb-lg-0"></ul>
                @endauth
                <form class="d-flex">
                    @if (Route::has('login'))
                        <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right z-10 ">
                            @auth
                                <div class="login-block btn-group">
                                    <a class="username btn btn-link">John Doe</a>
                                    <a href="#" class="btn btn-link"><i class="fas fa-sign-out-alt"></i> Logout</a>
                                </div>
                            @else
                                <div class="login-block btn-group">
                                    <a href="{{route('login')}}" class="btn btn-link"><i class="fas fa-sign-out-alt"></i> Login</a>
                                    <a href="{{route('login')}}" class="btn btn-link"><i class="fas fa-sign-out-alt"></i> Register</a>
                                </div>
                            @endauth
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </nav>

    @section('messages')
        <x-messages :messages="session('header.messages')"></x-messages>
    @show
    @section('body')default body
    @show
    </body>
</html>
