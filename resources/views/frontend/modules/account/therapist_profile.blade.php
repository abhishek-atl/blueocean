@extends('frontend.layouts.default')

@inject('format', 'App\Services\FormatService')

@section('title', 'Therapist Dashboard | My Profile')

@section('content')

<div class="container pt50 mb40">

    <div class="row">
        <div class="col-3">
            <h1 class="text-primary mb-4">Profile</h1>
        </div>
        <div class="col-9 text-right">
            <a class="btn btn-primary" href="{{ route('profile') }}">Personal</a>
            <a class="btn btn-secondary" href="{{ route('postcodes') }}">Postcode</a>
            <a class="btn btn-secondary" href="{{ route('schedules') }}">Schedule</a>
            <a class="btn btn-secondary" href="{{ route('mandates') }}">Mandates</a>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card mb-3">
                <div class="card-body">
                    <h2 class="mb-3">Personal Information</h2>
                    <div class="form-group row">
                        <label class="col-lg-3">Your Name</label>
                        <div class="col-lg-9">{{ $therapist->first_name }} {{ $therapist->last_name }}</div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3">Address</label>
                        <div class="col-lg-9">{{ $therapist->address }}</div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3">Mobile</label>
                        <div class="col-lg-9">{{ $therapist->mobile }}</div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3">Email</label>
                        <div class="col-lg-9">{{ $therapist->email }}</div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3">Treatments</label>
                        <div class="col-lg-9">{{ implode(', ',$treatments->pluck('name')->toArray()) }}</div>
                    </div>
                    <p>If you need to update any of your details, please contact the office. </p>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <label class="col-lg-3">Your Rating</label>
                        <div class="col-lg-9">
                            @if($therapist->avg_rating)
                            {{ $therapist->avg_rating }}
                            @if($therapist->avg_rating <= 1) Oopsies Daisies! Need to do better. @elseif($therapist->avg_rating <= 2) Time to step up the game! @elseif($therapist->avg_rating <= 3) Not bad but let's aim higher! @elseif($therapist->avg_rating <= 4) Nice work, getting close to excellence! @elseif($therapist->avg_rating <= 5) Fantastic job!, You'are the cream of the crop! @endif @else You have no ratings yet - please ask your customer to rate you! @endif </div>
                        </div>
                        @if($therapist->is_bonus_eligible)
                        <div class="row">
                            <label class="col-lg-3">Bonus Eligible</label>
                            <div class="col-lg-9">Yes</div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>


    @endsection

    @push('footerJs')
    <script>
    </script>


    @endpush