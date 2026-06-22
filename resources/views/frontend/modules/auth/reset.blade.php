@extends('frontend.layouts.default')

@section('title')Reset Password @endsection

@section('content')

<section class="page-section">

    <div class="container">

        <div class="row">
            <div class="col-12 col-md-6 offset-md-3">
                <h1>Reset Password</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-md-6 offset-md-3">

                <div class="content-panel">

                    <form method="post" action="{{ route('post-reset-password') }}" id="postResetPassword">

                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">
                        <input type="hidden" name="email" value="{{ $email }}">

                        <div class="row g-4">

                            <div class="col-12">
                                <label class="form-label" for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Choose a new Password">
                                @error('password')
                                <span class="help-block error-help-block">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label" for="password_confirmation">Confirm Password</label>
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password">
                                @error('password_confirmation')
                                <span class="help-block error-help-block">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-12">
                                <button class="btn btn-primary btn-block submit" type="submit">Reset Password</button>
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

{!! JsValidator::formRequest('App\Http\Requests\Auth\PasswordResetRequest', '#postResetPassword') !!}
<script>
    $(document).ready(function() {
        $('#password').focus();
    })
</script>

@endpush