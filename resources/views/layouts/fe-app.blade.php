<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title'){{ ' - '.cache('sys_setting')['sys_name'] }}</title>

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/bootstrap-icons/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    @yield('extra-css')
</head>

<body>
    <nav class="navbar navbar-expand-sm navbar-light rounded">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('slash') }}">
                {{ cache('sys_setting')['sys_name'] }} |
                <img src="{{ asset(cache('app_setting')['app_logo']) }}">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
                aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-end" id="navbarContent">
                <ul class="navbar-nav mb-2 mb-sm-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Product</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="dropdown03" data-bs-toggle="dropdown" aria-expanded="false">Categories</a>
                        <ul class="dropdown-menu" aria-labelledby="dropdown03">
                            <li><a class="dropdown-item" href="#">Shirts</a></li>
                            <li><a class="dropdown-item" href="#">Bags</a></li>
                            <li><a class="dropdown-item" href="#">Shoes</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Tentang Kami</a>
                    </li>
                    <li class="nav-item">
                        @guest
                        <a class="nav-link" href="{{ route('auth.login.view') }}">Login</a>
                        @else
                        <a class="nav-link" href="{{ route('auth.login.view') }}">Dashboard</a>
                        @endguest
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    @yield('content')

    <div class="container mt-5">
        <footer>
            <div class="footer clearfix mb-0 text-muted">
                <div class="float-start">
                    <p>2021 &copy; {{ cache('sys_setting')['sys_name'] }}</p>
                </div>
                <div class="float-end">
                    <p>Crafted with <span class="text-danger"><i class="bi bi-heart-fill icon-mid"></i></span>
                        by <a href="{{ cache('sys_setting')['sys_author_link'] }}">{{ cache('sys_setting')['sys_author_name'] }}</a></p>
                </div>
            </div>
        </footer>
    </div>

    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/bapp.js?='.time()) }}"></script>
    @yield('extra-js')
</body>

</html>
