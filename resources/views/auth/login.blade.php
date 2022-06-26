@extends('layouts.auth')

@section('title')
Login
@endsection

@section('content')
<div class="row h-100">
    <div class="col-lg-5 col-12">
        <div id="auth-left">
            <div class="auth-logo">
                <a href="index.html"><img src="{{ asset(cache('app_setting')['app_logo']) }}" alt="Logo"></a>
            </div>
            <h1 class="auth-title">Log in.</h1>
            <p class="auth-subtitle mb-5">Log in dengan akun yang Anda miliki.</p>

            @if ($errors->any())
                <div class="alert alert-danger" role="alert">
                    {!! implode('', $errors->all('<li>:message</li>')) !!}
                </div>
            @endif

            <form action="{{ route('auth.login.post') }}" method="POST">
                @csrf
                <div class="form-group position-relative has-icon-left mb-4">
                    <input name="email" type="email" class="form-control form-control-xl" placeholder="Email" value="{{ old('email') }}" autofocus>
                    <div class="form-control-icon">
                        <i class="bi bi-envelope"></i>
                    </div>
                </div>
                <div class="form-group position-relative has-icon-left mb-4">
                    <input name="password" type="password" class="form-control form-control-xl" placeholder="Password">
                    <div class="form-control-icon">
                        <i class="bi bi-shield-lock"></i>
                    </div>
                </div>
                <button class="btn btn-primary btn-block btn-lg shadow-lg mt-5">Log in</button>
            </form>
            <div class="text-center mt-5 text-lg fs-4">
                <p class="text-gray-600">Belum Punya Akun? <a href="auth-register.html"
                        class="font-bold">Sign up</a>.</p>
                <p><a class="font-bold" href="auth-forgot-password.html">Lupa password?</a>.</p>
            </div>
        </div>
    </div>
    <div class="col-lg-7 d-none d-lg-block">
        <div id="auth-right">

        </div>
    </div>
</div>
@endsection
