<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="{{ asset('admin/images/favicon.svg') }}" type="image/x-icon" />
    <title>{{ env('APP_NAME') }} - @yield('title')</title>

    <link rel="stylesheet" href="{{ asset('admin/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/css/fontawesome.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/css/solid.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/tempus-dominus.min.css') }}">

    <link rel="stylesheet" href="{{ asset('admin/css/main.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/css/custom.css') }}" />

    @stack('pageCss')

</head>

<body>

    <div id="preloader">
        <div class="spinner"></div>
    </div>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif


    @include('admin.partials.sidebar')

    <main class="main-wrapper">

        @yield('content')

        @include('admin.partials.footer')

    </main>

    <script src="{{ asset('admin/js/jquery.min.js') }}"></script>
    <script src="{{ asset('admin/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('admin/js/popper.min.js') }}"></script>
    <script src="{{ asset('admin/js/select2.min.js') }}"></script>
    <script src="{{ asset('admin/js/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('admin/js/toastr.min.js') }}"></script>
    <script src="{{ asset('admin/js/tempus-dominus.min.js') }}"></script>
    <script src="{{ asset('admin/js/moment.min.js') }}"></script>

    <script src="{{ asset('admin/js/app.js') }}"></script>

    @stack('pageScripts')

</body>

</html>