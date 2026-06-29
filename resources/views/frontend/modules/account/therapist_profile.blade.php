@extends('frontend.layouts.default')

@inject('format', 'App\Services\FormatService')

@section('title', 'Therapist Dashboard | My Profile')

@section('content')

<section class="page-hero">
    <div class="container">
        <div class="row justify-content-center text-center">
            <div class="col-lg-8">
                <h1>Profile</h1>
            </div>
        </div>
    </div>
</section>

<section class="page-section">

    <div class="container">

        <div class="row mb-3">
            <div class="col-9 text-right">
                <a class="btn btn-primary" href="{{ route('profile') }}">Personal</a>
                <a class="btn btn-secondary" href="{{ route('postcodes') }}">Postcode</a>
                <a class="btn btn-secondary" href="{{ route('schedules') }}">Schedule</a>
                <a class="btn btn-secondary" href="{{ route('mandates') }}">Mandates</a>
            </div>
        </div>

        <div class="row g-4">

            <div class="col-md-12">

                <div class="content-panel">

                    <h2>Personal Information</h2>

                    <div class="row g-4">

                        <div class="col-md-6">
                            <label class="fw-bold">Your Name</label>
                            <div class="col-lg-9">{{ $therapist->first_name }} {{ $therapist->last_name }}</div>
                        </div>

                        <div class="col-md-6">
                            <label class="fw-bold">Address</label>
                            <div class="col-lg-9">{{ $therapist->user_profile->address }}</div>
                        </div>

                        <div class="col-md-6">
                            <label class="fw-bold">Mobile</label>
                            <div class="col-lg-9">{{ $therapist->user_profile->mobile }}</div>
                        </div>

                        <div class="col-md-6">
                            <label class="fw-bold">Email</label>
                            <div class="col-lg-9">{{ $therapist->email }}</div>
                        </div>

                        <div class="col-md-6">
                            <label class="fw-bold">Treatments</label>
                            <div class="col-lg-9">{{ implode(', ',$treatments->pluck('name')->toArray()) }}</div>
                        </div>

                        <p>If you need to update any of your details, please contact the office. </p>

                    </div>

                </div>
            </div>

            <div class="content-panel">
                <h2>Rating</h2>

                <div class="row g-4">

                    <div class="col-md-6">
                        <label class="fw-bold">Your Rating</label>
                        <div class="col-lg-9">
                            @if($therapist->avg_rating)
                            {{ $therapist->avg_rating }}
                            @if($therapist->avg_rating <= 1)
                            Oopsies Daisies! Need to do better.
                            @elseif($therapist->avg_rating <= 2)
                            Time to step up the game!
                            @elseif($therapist->avg_rating <= 3)
                            Not bad but let's aim higher!
                            @elseif($therapist->avg_rating <= 4)
                            Nice work, getting close to excellence!
                            @elseif($therapist->avg_rating <= 5)
                            Fantastic job!, You'are the cream of the crop!
                            @endif
                            @else
                            You have no ratings yet - please ask your customer to rate you!
                            @endif
                        </div>
                        @if($therapist->is_bonus_eligible)
                        <div class="col-md-6">
                            <label class="fw-bold">Bonus Eligible</label>
                            <div class="col-lg-9">Yes</div>
                        </div>
                        @endif

                    </div>
                </div>

            </div>

        </div>
    </div>
</section>


@endsection

@push('pageScripts')
<script>
</script>


@endpush