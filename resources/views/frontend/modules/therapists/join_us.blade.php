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

<section class="content-section">
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
                <div class="content-panel form-panel">
                    @if (session('status'))
                    <div class="alert alert-success">{!! session('status') !!}</div>
                    @endif

                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form id="frmApplication" method="post" action="{{ route('join_us_post') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-section-heading form-section-heading-first">
                            <span>Application Form</span>
                            <h2>Your details</h2>
                        </div>

                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="form-field">
                                    <label class="form-label" for="name">Name</label>
                                    <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}">
                                    @error('name')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-field">
                                    <label class="form-label" for="email">Email</label>
                                    <input type="text" id="email" name="email" class="form-control" value="{{ old('email') }}">
                                    @error('email')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-field">
                                    <label class="form-label" for="mobile">Mobile</label>
                                    <input type="tel" id="mobile" name="mobile" class="form-control autosave" placeholder="07400123456" value="{{ old('mobile') }}">
                                    @error('mobile')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-field">
                                    <label class="form-label" for="address">Address</label>
                                    <textarea name="address" id="address" rows="1" class="form-control">{{ old('address') }}</textarea>
                                    @error('address')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-section-heading">
                            <span>Work Preferences</span>
                            <h2>Availability and travel</h2>
                        </div>

                        <div class="row g-4">
                            <div class="col-md-6">
                                <fieldset class="form-field option-group">
                                    <legend>Are you happy to travel to client homes and hotels in London?</legend>
                                    <div class="option-stack">
                                        <div class="form-check">
                                            <input class="form-check-input" name="travel" type="radio" value="yes" id="travel_yes" @checked(old('travel')=='yes' )>
                                            <label class="form-check-label" for="travel_yes">Yes</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" name="travel" type="radio" value="no" id="travel_no" @checked(old('travel')=='no' )>
                                            <label class="form-check-label" for="travel_no">No</label>
                                        </div>
                                    </div>
                                    @error('travel')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </fieldset>
                            </div>
                            <div class="col-md-6">
                                <fieldset class="form-field option-group">
                                    <legend>Would you like to work?</legend>
                                    <div class="option-stack">
                                        <div class="form-check">
                                            <input class="form-check-input" name="fulltime" type="radio" value="fulltime" id="fulltime_yes" @checked(old('fulltime')=='fulltime' )>
                                            <label class="form-check-label" for="fulltime_yes">Full-Time</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" name="fulltime" type="radio" value="parttime" id="fulltime_no" @checked(old('fulltime')=='parttime' )>
                                            <label class="form-check-label" for="fulltime_no">Part-Time</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" name="fulltime" type="radio" value="flexitime" id="fulltime_flexitime" @checked(old('fulltime')=='flexitime' )>
                                            <label class="form-check-label" for="fulltime_flexitime">Flexi-Time</label>
                                        </div>
                                    </div>
                                    @error('fulltime')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </fieldset>
                            </div>
                        </div>

                        <div class="form-section-heading">
                            <span>Experience & Skills</span>
                            <h2>Your massage background</h2>
                        </div>

                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="form-field">
                                    <label class="form-label" for="favourite_massage_style">Which massage styles do you like the most?</label>
                                    <textarea name="favourite_massage_style" id="favourite_massage_style" rows="4" class="form-control">{{ old('favourite_massage_style') }}</textarea>
                                    @error('favourite_massage_style')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-field">
                                    <label class="form-label" for="massage_love_reason">Share what you love about giving massages and your experience</label>
                                    <textarea name="massage_love_reason" id="massage_love_reason" rows="4" class="form-control">{{ old('massage_love_reason') }}</textarea>
                                    @error('massage_love_reason')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-section-heading">
                            <span>Uploads</span>
                            <h2>Documents</h2>
                        </div>

                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="form-field upload-field">
                                    <label class="form-label" for="cv">Please attach your CV</label>
                                    <input type="file" class="form-control" id="cv" name="cv">
                                    @error('cv')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-field upload-field">
                                    <label class="form-label" for="photo">Please attach a recent photograph</label>
                                    <input type="file" class="form-control" id="photo" name="photo">
                                    @error('photo')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary btnConfirm">Confirm</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('pageScripts')
<script>
    $(document).ready(function() {
        $('#frmApplication').on('submit', function() {
            $('.btnConfirm').prop('disabled', true);
            $('.btnConfirm').html('Please wait...');
        });
    });
</script>
@endpush