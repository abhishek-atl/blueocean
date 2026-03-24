@extends('admin.layouts.empty')

@section('content')


@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="container-fluid p-0">
    <div class="row">

        <div class="col-12">

            <div class="d-flex justify-content-center align-items-center vh-100">

                <div class="form-wrapper p-4 shadow-lg col-4">
                    <div class="form-title text-center">
                        <h5 class="title">Log in</h5>
                    </div>
                    <div class="form-body">
                        <form method="post" action="{{ route('auth.login') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label">Email address</label>
                                <input id="email" name="email" type="text" class="form-control" placeholder="Enter your email">
                                @error('email')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input id="password" name="password" type="password" class="form-control" placeholder="Password">
                            </div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                                <label class="form-check-label" for="remember">Remember Me</label>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>
@endsection