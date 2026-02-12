<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>

    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body>
    <div class="container">
        <h1>Welcome to the Home Page</h1>
        <p>This is the main landing page of the application.</p>
        <a href="{{ route('auth.login')}}">Admin</a>
    </div>

    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/jquery-4.0.0.min.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>


</html>