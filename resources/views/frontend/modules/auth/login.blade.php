@extends('frontend.layouts.default')

@section('title')
Customer Log In - Access Your Account | {{ config("app.name") }}
@endsection

@section('description')
Securely log in to your {{ config("app.name") }} customer account to view booking history,
access exclusive rewards and rate therapists. Don't have an account yet? Sign up now to
taking advantage of our loyalty benefits
@endsection

@section('content')

<section class="page-section">

    <div class="container">

        <div class="row">
            <div class="col-12 col-md-6 offset-md-3">
                @if (session('booking'))
                <h1>Log In Or Checkout As Guest</h1>
                @else
                <h1>Log In</h1>
                @endif
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-md-6 offset-md-3">

                <div class="content-panel">

                    <form method="post" action="{{ route('auth.login') }}" id="postLoginForm">
                        @csrf

                        @if(Session::has('error'))
                        <div class="alert alert-danger">{!! Session::get('error') !!}</div>
                        @endif

                        <div class="row g-4">

                            <div class="col-12">
                                <label class="form-label" for="login_email">Email</label>
                                <input type="email" class="form-control" id="login_email" name="email" placeholder="you@example.com" required value="{{ old('email') }}">
                                @error('email')
                                <span class="help-block error-help-block">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label" for="login_password">Password</label>
                                <input type="password" class="form-control" id="login_password" name="password" placeholder="Enter your password" required>
                                @error('password')
                                <span class="help-block error-help-block">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-12">
                                <div class="d-flex justify-content-between">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="1" name="remember" id="remember">
                                        <label class="form-check-label" for="remember">Remember me</label>
                                    </div>
                                    <a href="{{ route('forgot-password') }}">Forgot Password?</a>
                                </div>
                            </div>

                            <div class="col-12">
                                <button class="btn btn-primary btn-block submit" type="submit">Sign in</button>
                            </div>
                        </div>

                        @if(session('booking'))
                        <div class="auth-guest-link">
                            <p>or</p>
                            <a href="{{ route('bookingCheckout') }}">Checkout As Guest</a>
                        </div>
                        @endif
                    </form>

                </div>

                <p class="mt-3">Don't have an account? <a href="{{ route('auth.register') }}">Sign Up</a></p>

            </div>
        </div>

    </div>

</section>
@endsection

@push('pageScripts')

{!! JsValidator::formRequest('App\Http\Requests\Auth\LoginRequest', '#postLoginForm') !!}
<script>
    $(document).ready(function() {
        $('#login_email').focus();
    })
</script>

@endpush