@extends('frontend.layouts.default')

@section('title')
Reset Password | {{ config('app.name') }}
@endsection

@section('content')

<section class="page-section">

    <div class="container">

        <div class="row">
            <div class="col-12 col-md-6 offset-md-3">
                <h1>Reset Your Password</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-md-6 offset-md-3">

                <div class="content-panel">

                    <form method="post" action="{{ route('post-forgot-password') }}" id="postForgotPassword">
                        @csrf

                        <div class="row g-4">
                            <div class="col-12">
                                <label class="form-label" for="login_email">Email</label>
                                <input type="email" class="form-control" id="login_email" name="email" placeholder="you@example.com" value="{{ old('email') }}">
                                @error('email')
                                <span class="help-block error-help-block">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-12">
                                <button class="btn btn-primary btn-block submit" type="submit">Request Password Reset</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>

    </div>

</section>

@endsection

@push('pageScripts')

{!! JsValidator::formRequest('App\Http\Requests\Auth\ForgotPasswordRequest', '#postForgotPassword') !!}
<script>
    $(document).ready(function() {
        $('#login_email').focus();
    })
</script>

@endpush