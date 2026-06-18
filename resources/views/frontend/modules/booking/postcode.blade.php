@extends('frontend.layouts.default')

@section('content')

<section class="page-hero">
    <div class="container">
        <div class="row justify-content-center text-center">
            <div class="col-lg-8">
                <h1>Book a Massage</h1>
                <p>Find a massage therapist near you and book an appointment.</p>
            </div>
        </div>
    </div>
</section>

<section class="custom-section booking-section">
    @include('frontend.modules.booking.partials.booking_block')
</section>

<section class="custom-section booking-how-it-works">
    <div class="container">
        <div class="row justify-content-center text-center">
            <div class="col-lg-8">
                <span class="section-eyebrow">How it works</span>
                <h2>Book trusted massage at home in three simple steps.</h2>
            </div>
        </div>

        <div class="row g-4 how-it-works-row">
            <div class="col-lg-4">
                <article class="how-it-works-card h-100">
                    <span class="how-it-works-icon">01</span>
                    <h3>Choose your treatment</h3>
                    <p>Enter your postcode and select the massage experience that fits your needs.</p>
                </article>
            </div>
            <div class="col-lg-4">
                <article class="how-it-works-card h-100">
                    <span class="how-it-works-icon">02</span>
                    <h3>Select a vetted therapist</h3>
                    <p>Pick from available professionals serving your area at a time that works for you.</p>
                </article>
            </div>
            <div class="col-lg-4">
                <article class="how-it-works-card h-100">
                    <span class="how-it-works-icon">03</span>
                    <h3>Relax at home</h3>
                    <p>Your therapist comes to your door, so there is no travel, waiting room, or extra stress.</p>
                </article>
            </div>
        </div>
    </div>
</section>


@endsection

@push('pageScripts')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDWEvQU0xphr90Ijr21eYLHZ0-WWiLzKt8&libraries=places&callback=initAutocomplete" async defer></script>
<script src="{{ asset('assets/js/google_location.js') }}?v=1.9"></script>
@endpush