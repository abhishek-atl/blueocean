@extends('frontend.layouts.default')

@section('title') My Account @endsection

@section('content')
<section class="page-hero">
    <div class="container">
        <div class="row justify-content-center text-center">
            <div class="col-lg-8">
                <h1>{{ Auth::user()->first_name }}'s Account</h1>
            </div>
        </div>
    </div>
</section>

<section class="page-section">

    <div class="container">

        <div class="row g-4">

            <div class="col-md-12">
                <div class="content-panel">
                    <form method="post" action="{{ route('accountPost') }}" id="frmMyAccount">
                        @csrf
                        <input type="hidden" name="user_id" id="user_id" value="{{ $userDetail->id }}" />

                        @if(Session::has('error'))
                        <div class="alert alert-danger">{{Session::get('error') }}</div>
                        @endif

                        <h2>Your Contact Details</h2>

                        <div class="row g-4 mb-4">

                            <div class="col-md-6">
                                <label class="form-label">First Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control input-default" id="first_name" name="first_name" placeholder="Enter First name.." value="{{ $userDetail->first_name ?? '' }}">
                                @error('first_name')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="col-lg-3 form-label">Surname</label>
                                <input type="text" class="form-control input-default" id="last_name" name="last_name" placeholder="Enter Surname.." value="{{ $userDetail->last_name ?? '' }}">
                                @error('last_name')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="text" class="form-control input-default" id="email" name="email" placeholder="Enter Email.." value="{{ $userDetail->email ?? '' }}">
                                <small>You will need to verify your email address if you change your current email address</small>
                                @error('email')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Phone <span class="text-danger">*</span></label>
                                <input type="text" class="form-control input-default" id="mobile" name="mobile" placeholder="Enter Phone.." value="{{ $userDetail->user_profile->mobile ?? '' }}">
                                @error('mobile')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label" for="flat_no">Flat No</label>
                                <input type="text" class="form-control" id="flat_no" name="flat_no" placeholder="Enter Flat Number..." value="@if($isEdit){{ $userDetail->user_profile->flat_no ?? '' }}@endif">
                                @error('flat_no')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label" for="street_no">Street Number</label>
                                <input type="text" class="form-control" id="street_no" name="street_no" placeholder="Enter Street Number..." value="@if($isEdit){{ $userDetail->user_profile->street_no ?? '' }}@endif">
                                @error('street_no')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label" for="street_name">Street Name</label>
                                <input type="text" class="form-control" id="street_name" name="street_name" placeholder="Enter Street Name..." value="@if($isEdit){{ $userDetail->user_profile->street_name ?? '' }}@endif">
                                @error('street_name')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label" for="town">Town</label>
                                <input type="text" class="form-control" id="town" name="town" placeholder="Enter Town..." value="@if($isEdit){{ $userDetail->user_profile->town ?? '' }}@endif">
                                @error('town')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label" for="postcode">Postcode <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="postcode" name="postcode" placeholder="Enter Postcode..." value="@if($isEdit){{ $userDetail->user_profile->postcode ?? '' }}@endif">
                                @error('postcode')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <button class="btn btn-primary submit" type="submit">Save Updates</button>
                            </div>

                        </div>

                    </form>
                </div>
            </div>

            <div class="content-panel">
                <form method="post" action="{{ route('accountPasswordPost') }}" id="frmChangePassword">
                    @csrf
                    @if(Session::has('error'))
                    <div class="alert alert-danger">{{Session::get('error') }}</div>
                    @endif

                    <h2>Change Your Password</h2>
                    <div class="row g-4 mb-4">

                        <div class="col-md-6">
                            <label class="form-label" for="postcode">Password</label>
                            <input type="password" class="form-control" placeholder="Enter New Password" name="password" id="password">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="postcode">Confirm Password</label>
                            <input type="password" class="form-control" placeholder="Confirm Password" name="password_confirmation" id="password_confirmation">
                        </div>

                        <div class="col-12">
                            <button class="btn btn-primary submit" type="submit">Confirm Change</button>
                        </div>

                    </div>
                </form>
            </div>

            <div class="content-panel">
                <form method="post" action="{{ route('accountDataDownload') }}">
                    @csrf

                    <h2>Download Your Data</h2>
                    <p>You can download a copy of all the data on your account below. To view your data, first double click the downloaded file, then you can use a
                        spreadsheet application such as Microsoft Excel to open each file.</p>
                    <p>See our <a href="{{ route('terms_conditions') }}" target="_blank">Privacy Policy</a> for more information about how we store your data.</p>

                    <input class="btn btn-primary" type="submit" name="btnDownloadProfileData" value="Download Profile Data" />
                    <input class="btn btn-primary" type="submit" name="btnDownloadBookingData" value="Download Booking Data" />

                </form>
            </div>
        </div>
    </div>


</section>



@endsection

@push('pageScripts')
<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>
{!! JsValidator::formRequest('App\Http\Requests\Auth\AccountRequest', '#frmMyAccount') !!}
{!! JsValidator::formRequest('App\Http\Requests\Auth\ChangePasswordRequest', '#frmChangePassword') !!}
@endpush