<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title'){{ ' - '.cache('sys_setting')['sys_name'] }}</title>

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/perfect-scrollbar/perfect-scrollbar.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/bootstrap-icons/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css?t='.time()) }}">
    <link rel="shortcut icon" href="{{ asset('favicon.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('vendors/toastify/toastify.css') }}">
    @yield('extra-css')
</head>

<body>
    <div id="app">
        <div id="sidebar" class="active">
            <div class="sidebar-wrapper active">
                <div class="sidebar-header">
                    <div class="d-flex justify-content-between">
                        <div class="logo">
                            <a href="index.html"><img src="{{ asset(cache('app_setting')['app_logo']) }}" alt="Logo" srcset=""></a>
                        </div>
                        <div class="toggler">
                            <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                        </div>
                    </div>
                </div>
                <div class="sidebar-menu">
                    <ul class="menu">
                        <li class="sidebar-item groupmodule-dashboard">
                            <a href="{{ route('dashboard.read') }}" class='sidebar-link'>
                                <i class="bi bi-grid-fill"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        @foreach ((new \BAuth)->getModules()[1] as $nm_group_menu => $modul_group)
                            <li class="sidebar-title">{{ $nm_group_menu }}</li>

                            @foreach ($modul_group as $nm_modul_group => $modul)
                                @if (sizeof($modul) == 1)
                                    <li class="sidebar-item groupmodule-{{ $modul[0]->route_prefix }}">
                                        <a href="{{ route($modul[0]->route_prefix.'.read') }}" class='sidebar-link'>
                                            <i class="{{ $modul[0]->icon_modul_group }}"></i>
                                            <span>{{ $modul[0]->nm_modul }}</span>
                                        </a>
                                    </li>
                                @else
                                    @php
                                        $menuClasses = collect($modul)->pluck('route_prefix')->toArray();
                                    @endphp
                                    <li class="sidebar-item has-sub groupmodule-{{ implode(' groupmodule-', $menuClasses) }}">
                                        <a href="#" class='sidebar-link'>
                                            <i class="{{ $modul[0]->icon_modul_group }}"></i>
                                            <span>{{ $nm_modul_group }}</span>
                                        </a>
                                        <ul class="submenu submodule-{{ implode(' submodule-', $menuClasses) }}">
                                            @foreach ($modul as $nm_modul => $m)
                                                <li class="submenu-item module-{{ $m->route_prefix.'.read' }}">
                                                    <a href="{{ route($m->route_prefix.'.read') }}">{{ $m->nm_modul }}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </li>
                                @endif
                            @endforeach
                        @endforeach
                    </ul>
                </div>
                <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
            </div>
        </div>
        <div id="main" class='layout-navbar'>
            <header>
                <nav class="navbar navbar-expand navbar-light ">
                    <div class="container-fluid">
                        <a href="#" class="burger-btn d-block">
                            <i class="bi bi-justify fs-3"></i>
                        </a>

                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                                <li class="nav-item dropdown me-1">
                                    <a class="nav-link active dropdown-toggle" href="#" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        <i class='bi bi-bell bi-sub fs-4 text-gray-600'></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                                        <li>
                                            <h6 class="dropdown-header">Notifications</h6>
                                        </li>
                                        <li><a class="dropdown-item">No notification available</a></li>
                                    </ul>
                                </li>
                                <li class="nav-item dropdown me-3">
                                    <a class="nav-link active dropdown-toggle" href="#" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        <i class='bi bi-gear bi-sub fs-4 text-gray-600'></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                                        <li>
                                            <h6 class="dropdown-header">Role User</h6>
                                        </li>
                                        @php
                                            $a_role = (new \BAuth)->getUserRole(true,true);
                                        @endphp
                                        @foreach ((new \BAuth)->getUserRole() as $role)
                                            <li><a class="dropdown-item" href="{{ route('change_role.read', ['role' => $role->id_role]) }}">{{ $role->nm_role }} {!! ($role->id_role == $a_role[0] ? '<span class="bi bi-check-circle pull-right"></span>' : '') !!}</a></li>
                                        @endforeach
                                    </ul>
                                </li>
                            </ul>
                            <div class="dropdown">
                                <a href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                    <div class="user-menu d-flex">
                                        <div class="user-name text-end me-3">
                                            <h6 class="mb-0 text-gray-600">{{ Auth::user()->nm_user }}</h6>
                                            <p class="mb-0 text-sm text-gray-600">{{ (new \BAuth)->getUserRole()->where('id_role', $a_role[0])->first()->nm_role }}</p>
                                        </div>
                                        <div class="user-img d-flex align-items-center">
                                            <div class="avatar avatar-md">
                                                <img src="{{ asset('images/faces/1.jpg') }}">
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                                    <li>
                                        <h6 class="dropdown-header">Hello, {{ Auth::user()->nm_user }}</h6>
                                    </li>
                                    {{-- <li><a class="dropdown-item" href="#"><i class="icon-mid bi bi-person me-2"></i> My
                                            Profile</a></li>
                                    <li><a class="dropdown-item" href="#"><i class="icon-mid bi bi-gear me-2"></i>
                                            Settings</a></li>
                                    <li><a class="dropdown-item" href="#"><i class="icon-mid bi bi-wallet me-2"></i>
                                            Wallet</a></li> --}}
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item" href="{{ route('logout') }}"><i class="icon-mid bi bi-box-arrow-left me-2"></i> Logout</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </nav>
            </header>
            <div id="main-content">
                <div class="page-heading">
                    <div class="page-title">
                        <div class="row">
                            <div class="col-12 col-md-6 order-md-1 order-last">
                                <h3>@yield('header-title')</h3>
                                <p class="text-subtitle text-muted">@yield('header-desc')</p>
                            </div>
                            <div class="col-12 col-md-6 order-md-2 order-first">
                                @yield('content-header-right')
                                {{-- <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Layout Vertical Navbar
                                        </li>
                                    </ol>
                                </nav> --}}
                            </div>
                        </div>
                    </div>
                    <section class="section">
                        @include('layouts.parts.notification.alert')
                        @yield('content')
                        {{-- <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Example Content</h4>
                            </div>
                            <div class="card-body">
                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Consectetur quas omnis
                                laudantium tempore
                                exercitationem, expedita aspernatur sed officia asperiores unde tempora maxime odio
                                reprehenderit
                                distinctio incidunt! Vel aspernatur dicta consequatur!
                            </div>
                        </div> --}}
                    </section>
                </div>
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
        </div>
    </div>
    @if (config('bobb.akses.a_delete'))
        @include('layouts.parts.notification.swal')
    @endif
    <script>
        // Tandai menu aktif dengan class active
        var groupModulAktif = document.getElementsByClassName("groupmodule-{{ explode('.', request()->route()->getName())[0] }}")[0];
        if(groupModulAktif != null)
        {
            groupModulAktif.className += " active";
        }

        var subModulAktif = document.getElementsByClassName("submodule-{{ explode('.', request()->route()->getName())[0] }}")[0];
        if(subModulAktif != null)
        {
            subModulAktif.className += " active";
        }

        var modulAktif = document.getElementsByClassName("module-{{ explode('.', request()->route()->getName())[0].'.read' }}")[0];
        if(modulAktif != null)
        {
            modulAktif.className += " active";
        }
    </script>
    <script src="{{ asset('vendors/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    <script src="{{ asset('vendors/toastify/toastify.js') }}"></script>

    {{-- Non Mandatory Here --}}
    @yield('extra-js')

    <script src="{{ asset('js/bapp.js?=1') }}"></script>

    {{-- SSO --}}
    @if(session()->get('is_sso'))
    {{-- <script src="{{ asset('vendors/xcomponent/xcomponent.frame.min.js') }}" ></script> --}}
    <script src="https://apps.unnes.ac.id/js/58/1" ></script>
    <script>
        (function() {
            window.xprops.reloadFrame(document.body.scrollHeight);
        })();

    </script>
    @endif
</body>

</html>
