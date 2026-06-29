<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @yield('google_meta')

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    @if(Request::query())
    <link rel="canonical" href="{{ Request::url() }}" />
    @else
    <link rel="canonical" href="{{ Request::fullUrl() }}" />
    @endif
    <link rel="manifest" href="/manifest.json">

    <title>@yield('title')</title>
    <meta name="title" content="@yield('title')">
    <meta name="description" content="@yield('description')">
    <meta name="keywords" content="@yield('keywords')">

    @yield('extra_meta')

    <link rel="icon" href="/favicon.ico" type="image/ico" sizes="24x24">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/solid.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/brands.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/tempus-dominus.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/toastr.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/booking.css') }}">

    @stack('pageCss')

    @stack('headJs')

</head>

<body>

    <div class="loading">Loading</div>

    <header>
        @include('frontend.partials.navigation')

        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <div class="text-center">{!! session('success') !!}</div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

    </header>

    <main>
        @yield('content')
    </main>

    <footer>
        <div class="container">
            @include('frontend.partials.footer')
        </div>
    </footer>

    <script src="{{ asset('assets/js/jquery.min.3.6.3.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>
    <script src="{{ asset('assets/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('admin/js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/tempus-dominus.min.js') }}"></script>
    <script src="{{ asset('assets/js/moment.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.raty.js') }}"></script>
    <script src="{{ asset('assets/js/toastr.min.js') }}"></script>

    <script src="{{ asset('assets/js/app.js') }}"></script>

    @stack('pageScripts')

</body>

</html>