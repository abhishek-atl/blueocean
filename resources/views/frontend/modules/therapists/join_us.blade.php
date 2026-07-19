@extends('frontend.layouts.default')

@section('extra_meta')
@endsection

@section('title', 'Therapist Application Form | BlueOcean')
@section('description', 'Application form to apply to join our team of trusted massage therapists as a mobile massage therapist in London.')
@section('keywords', 'massage application form, massage therapist application form')

@section('content')
<section class="page-hero">
    <div class="container">
        <div class="row justify-content-center text-center">
            <div class="col-12">
                <h1>Massage Job Application Form</h1>
                <p>Apply to join our team of mobile massage therapists in London.</p>
            </div>
        </div>
    </div>
</section>

<section class="page-section">

    <div class="container">

        <div class="row g-4 align-items-start">

            <div class="col-lg-4">
                <aside class="content-panel">
                    <div class="feature-icon"><i class="fa-solid fa-spa"></i></div>
                    <h2>Who we are looking for</h2>
                    <p>Successful applicants are reliable, honest, happy to travel, and genuinely love giving massages.</p>

                    <ul class="check-list">
                        <li><i class="fa-solid fa-check"></i> Genuinely love to massage</li>
                        <li><i class="fa-solid fa-check"></i> Happy to travel around London</li>
                        <li><i class="fa-solid fa-check"></i> Reliable and honest</li>
                    </ul>
                </aside>
            </div>

            <div class="col-lg-8">

                <div class="content-panel">

                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <div class="text-center">{!! session('success') !!}</div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    <form id="frmApplication" method="post" action="{{ route('join_us_post') }}" enctype="multipart/form-data">
                        @csrf

                        <h2>Your details</h2>

                        <div class="row g-3 mb-5">

                            <div class="col-md-6">
                                <label class="form-label" for="first_name">First Name</label>
                                <input type="text" id="first_name" name="first_name" class="form-control" value="{{ old('first_name') }}">
                                @error('first_name')
                                <span class="help-block error-help-block">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="last_name">Last Name</label>
                                <input type="text" id="last_name" name="last_name" class="form-control" value="{{ old('last_name') }}">
                                @error('last_name')
                                <span class="help-block error-help-block">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label" for="email">Email</label>
                                <input type="text" id="email" name="email" class="form-control" value="{{ old('email') }}">
                                @error('email')
                                <span class="help-block error-help-block">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label" for="mobile">Mobile</label>
                                <input type="tel" id="mobile" name="mobile" class="form-control autosave" placeholder="07400123456" value="{{ old('mobile') }}">
                                @error('mobile')
                                <span class="help-block error-help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary btnConfirm">Submit Application</button>
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

{!! JsValidator::formRequest('App\Http\Requests\StoreTherapistApplication', '#frmApplication') !!}

<script>
    $(document).ready(function() {

        $("#cv").change(function() {
            $(this).parents('div').find('.alert').hide();
        });

        $("#photo").change(function() {
            $(this).parents('div').find('.alert').hide();
        });

        $(document).ready(function() {
            $('.btnConfirm').click(function(e) {
                e.preventDefault();
                if ($('#frmApplication').valid()) {
                    $('.btnConfirm').prop('disabled', true);
                    $('.btnConfirm').html('Please wait...');
                    $('#frmApplication').submit();
                }
            });
        });
    });
</script>

@endpush