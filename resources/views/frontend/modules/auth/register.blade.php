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

                    @include('frontend.modules.auth.register-form')
                    
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