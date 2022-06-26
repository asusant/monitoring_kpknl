<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SSO Login</title>
</head>
<body>
    <form name='formsso' method='post' action='{{ route('auth.sso-login.post') }}'>
        <!-- jangan lupa sertakan CSRF token jika framework Anda mewajibkan -->
        @csrf
        <input type="hidden" name="sso_token" id="sso_token">
    </form>

    <script src="{{ asset('vendors/jquery/jquery.min.js') }}" ></script>
    <script src="{{ asset('vendors/xcomponent/xcomponent.frame.min.js') }}" ></script>
    <script src="https://apps.unnes.ac.id/js/58/1" ></script>

</body>
</html>
