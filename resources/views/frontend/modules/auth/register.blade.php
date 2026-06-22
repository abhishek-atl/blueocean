@extends('frontend.layouts.default')

@section('title')
Customer Log In - Access Your Account | {{ config('app.name') }}
@endsection

@section('description')
Securely log in to your {{ config('app.name') }} customer account to view booking history,
access exclusive rewards and rate therapists. Don't have an account yet? Sign up now to
taking advantage of our loyalty benefits.
@endsection

@section('content')

<section class="page-section">

    <div class="container">

        <div class="row">
            <div class="col-12 col-md-6 offset-md-3">
                <h1>Register</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-md-6 offset-md-3">

                <div class="content-panel">

                    <form method="post" action="{{ route('post-register') }}" id="postRegisterForm">

                        @csrf
                        <input type="hidden" name="bookingId" value="{{ isset($bookingId) ? $bookingId : ''  }}" />

                        <div class="row g-4">

                            <div class="col-12">
                                <label class="form-label" for="register_name">Name</label>
                                <input type="text" class="form-control" id="register_name" name="name" placeholder="Your name" required value="{{ old('name') }}">
                                @error('name')
                                <span class="help-block error-help-block">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label" for="register_email">Email</label>
                                <input type="email" class="form-control" id="register_email" name="email" placeholder="you@example.com" required value="{{ old('email') }}">
                                @error('email')
                                <span class="help-block error-help-block">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label" for="register_password">Password</label>
                                <input type="password" class="form-control" id="register_password" name="password" placeholder="Choose a password" required>
                                @error('password')
                                <span class="help-block error-help-block">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label" for="password_confirmation">Confirm password</label>
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Re-enter your password" required>
                                @error('password_confirmation')
                                <span class="help-block error-help-block">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-12">
                                <button class="btn btn-primary btn-block submit" type="submit">Register</button>
                            </div>

                        </div>

                    </form>
                </div>

                <p class="mt-3">Already have an account? <a href="{{ route('auth.login') }}">Sign In</a></p>

            </div>

        </div>

    </div>

</section>
@endsection

@push('pageScripts')

{!! JsValidator::formRequest('App\Http\Requests\Auth\RegisterRequest', '#postRegisterForm') !!}
<script>
    $(document).ready(function() {
        $('#register_name').focus();
    })
</script>

@endpush