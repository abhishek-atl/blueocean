@extends('frontend.layouts.default')

@section('content')
<section class="hero home-hero">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-7">
                <div class="hero-content">
                    @include('frontend.modules.booking.partials.booking_block')
                </div>
            </div>

            <div class="col-lg-5">
                <div class="hero-card">
                    <div class="hero-card-header d-flex align-items-center gap-3">
                        <span class="hero-card-icon"><i class="fa-solid fa-spa"></i></span>
                        <div>
                            <p class="mb-0">Available today</p>
                            <strong>London mobile therapists</strong>
                        </div>
                    </div>

                    <div class="row g-3 mt-4">
                        <div class="col-6">
                            <div class="hero-stat">
                                <span>4.9/5</span>
                                <small>Client rating</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="hero-stat">
                                <span>60 min</span>
                                <small>Popular session</small>
                            </div>
                        </div>
                    </div>

                    <ul class="list-unstyled hero-checklist mb-0 mt-4">
                        <li><i class="fa-solid fa-check"></i> Qualified massage therapists</li>
                        <li><i class="fa-solid fa-check"></i> Home and hotel appointments</li>
                        <li><i class="fa-solid fa-check"></i> Simple postcode-based booking</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="featured-section">
    <div class="container">
        <div class="row justify-content-center text-center mb-5">
            <div class="col-lg-7">
                <span class="section-eyebrow">Why choose us</span>
                <h2>Designed around calm, convenient care.</h2>
                <p class="featured-intro">From booking to treatment, the experience is built to be clear, flexible, and reliable.</p>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-md-6 col-lg-4">
                <div class="feature-card h-100">
                    <div class="feature-icon"><i class="fa-solid fa-user-check"></i></div>
                    <h3>Vetted therapists</h3>
                    <p>Work with trained therapists who bring professional massage treatments to your preferred location.</p>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="feature-card h-100">
                    <div class="feature-icon"><i class="fa-solid fa-calendar-check"></i></div>
                    <h3>Easy scheduling</h3>
                    <p>Enter your postcode, choose a time, and continue through a focused booking flow that works on any device.</p>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="feature-card h-100">
                    <div class="feature-icon"><i class="fa-solid fa-house-chimney-medical"></i></div>
                    <h3>Comfort first</h3>
                    <p>Enjoy your treatment at home or in your hotel room without travel, waiting rooms, or extra hassle.</p>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="featured-panel h-100">
                    <div class="row align-items-center g-4">
                        <div class="col-md-7">
                            <span class="section-eyebrow">Treatments</span>
                            <h3>Choose the massage that fits your day.</h3>
                            <p>Browse classic, deep tissue, aromatherapy, and specialist treatments, then book the right therapist for your area.</p>
                            <a href="{{ route('treatments') }}" class="btn btn-primary">View Treatments</a>
                        </div>
                        <div class="col-md-5">
                            <div class="featured-panel-visual">
                                <i class="fa-solid fa-hands-holding-circle"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="feature-card feature-card-highlight h-100">
                    <div class="feature-icon"><i class="fa-solid fa-location-dot"></i></div>
                    <h3>Local availability</h3>
                    <p>Postcode checks help show appointments and therapists that fit your area.</p>
                    <a href="{{ route('bookingPostcode') }}" class="feature-link">Check your postcode</a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('pageScripts')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDWEvQU0xphr90Ijr21eYLHZ0-WWiLzKt8&libraries=places&callback=initAutocomplete" async defer></script>
<script src="{{ asset('assets/js/google_location.js') }}?v=1.9"></script>
@endpush
