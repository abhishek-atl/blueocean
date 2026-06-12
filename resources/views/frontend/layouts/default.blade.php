<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Home Page')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    @stack('meta')

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/solid.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/tempus-dominus.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    @stack('pageCss')

</head>

<body>

    @include('frontend.partials.navigation')

    @yield('content')

    <div class="footer">
        <div class="container">
            @include('frontend.partials.footer')
        </div>
    </div>

    <script src="{{ asset('assets/js/jquery.min.3.6.3.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>
    <script src="{{ asset('assets/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('admin/js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/tempus-dominus.min.js') }}"></script>
    <script src="{{ asset('assets/js/moment.min.js') }}"></script>


    <script src="{{ asset('assets/js/app.js') }}"></script>

    @stack('pageScripts')

</body>

</html>