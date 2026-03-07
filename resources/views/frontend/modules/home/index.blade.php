@extends('frontend.layouts.default')

@section('content')
<!-- Hero Section -->

<section class="hero">
    <div class="hero-content">
        <form method="post" action="{{ route('bookingInfo') }}" id="postcode_form">
            @csrf
            <h1>Welcome to Blueocean</h1>
            <p class="lead">Relax: Our expert mobile massage service starts at just £59</p>
            <div class="search-box">
                <input type="text" name="input_postcode" id="input_postcode" class="form-control" placeholder="Enter your postcode..">
                <button class="btn btn-light postcode-button" disabled="disabled">Book Now</button>
            </div>
            <div id="postcode_error" class="hide-elem alert alert-danger mt-3"></div>
            <input type="hidden" name="postcode" id="postcode" />
            <input type="hidden" name="postcode_id" id="postcode_id" />
            <input type="hidden" name="travel_sup" id="travel_sup" />
            <input type="hidden" name="town" id="town" />
        </form>
    </div>
</section>


<!-- Featured Section with Text Left and Image Right -->
<section class="featured-section">
    <div class="container">
        <div class="featured-row row">
            <div class="col-lg-6">
                <h2>Why Choose Us?</h2>
                <h3>Exceptional Quality & Performance</h3>
                <p>We deliver premium solutions tailored to your unique needs. Our team of experts ensures every project meets the highest standards of quality and innovation.</p>
                <p>With years of industry experience, we understand what it takes to create meaningful digital experiences that drive results.</p>
                <ul class="list-unstyled">
                    <li class="mb-3"><strong>✓</strong> Professional & Experienced Team</li>
                    <li class="mb-3"><strong>✓</strong> Cutting-edge Technology</li>
                    <li class="mb-3"><strong>✓</strong> 24/7 Customer Support</li>
                    <li class="mb-3"><strong>✓</strong> Affordable Pricing</li>
                </ul>
                <a href="about.html" class="btn btn-primary mt-4">Learn More</a>
            </div>
            <div class="col-lg-6">
                <div class="featured-image">
                    <svg width="100%" height="400" xmlns="http://www.w3.org/2000/svg">
                        <defs>
                            <linearGradient id="grad1" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" style="stop-color:#667eea;stop-opacity:1" />
                                <stop offset="100%" style="stop-color:#764ba2;stop-opacity:1" />
                            </linearGradient>
                        </defs>
                        <rect width="100%" height="400" fill="url(#grad1)" />
                        <circle cx="100" cy="100" r="80" fill="rgba(255,255,255,0.2)" />
                        <circle cx="300" cy="350" r="100" fill="rgba(255,255,255,0.1)" />
                        <text x="50%" y="50%" font-size="24" fill="white" text-anchor="middle" dominant-baseline="middle">Featured Image</text>
                    </svg>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- <section class="services-section">
    <div class="container">
        <div class="services-title">
            <h2>Our Services</h2>
            <p>Comprehensive solutions for your business needs</p>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-6">
                <div class="service-card">
                    <div class="service-card-image">
                        <svg width="100%" height="200" xmlns="http://www.w3.org/2000/svg">
                            <defs>
                                <linearGradient id="svc1" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" style="stop-color:#667eea;stop-opacity:0.3;" />
                                    <stop offset="100%" style="stop-color:#764ba2;stop-opacity:0.3;" />
                                </linearGradient>
                            </defs>
                            <rect width="100%" height="200" fill="url(#svc1)" />
                            <circle cx="50%" cy="50%" r="40" fill="white" opacity="0.8" />
                            <text x="50%" y="55%" font-size="20" text-anchor="middle" dominant-baseline="middle" fill="#667eea">WEB</text>
                        </svg>
                    </div>
                    <h3>Web Development</h3>
                    <p>Create modern, responsive websites that engage your audience and drive conversions.</p>
                    <a href="services-details.html" class="btn btn-sm btn-primary mt-3">Learn More</a>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="service-card">
                    <div class="service-card-image">
                        <svg width="100%" height="200" xmlns="http://www.w3.org/2000/svg">
                            <defs>
                                <linearGradient id="svc2" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" style="stop-color:#667eea;stop-opacity:0.3;" />
                                    <stop offset="100%" style="stop-color:#764ba2;stop-opacity:0.3;" />
                                </linearGradient>
                            </defs>
                            <rect width="100%" height="200" fill="url(#svc2)" />
                            <circle cx="50%" cy="50%" r="40" fill="white" opacity="0.8" />
                            <text x="50%" y="55%" font-size="20" text-anchor="middle" dominant-baseline="middle" fill="#667eea">UI/UX</text>
                        </svg>
                    </div>
                    <h3>UI/UX Design</h3>
                    <p>Craft beautiful and intuitive interfaces that enhance user experience and brand identity.</p>
                    <a href="services-details.html" class="btn btn-sm btn-primary mt-3">Learn More</a>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="service-card">
                    <div class="service-card-image">
                        <svg width="100%" height="200" xmlns="http://www.w3.org/2000/svg">
                            <defs>
                                <linearGradient id="svc3" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" style="stop-color:#667eea;stop-opacity:0.3;" />
                                    <stop offset="100%" style="stop-color:#764ba2;stop-opacity:0.3;" />
                                </linearGradient>
                            </defs>
                            <rect width="100%" height="200" fill="url(#svc3)" />
                            <circle cx="50%" cy="50%" r="40" fill="white" opacity="0.8" />
                            <text x="50%" y="55%" font-size="20" text-anchor="middle" dominant-baseline="middle" fill="#667eea">APP</text>
                        </svg>
                    </div>
                    <h3>Mobile Apps</h3>
                    <p>Develop powerful mobile applications for iOS and Android platforms with cutting-edge technology.</p>
                    <a href="services-details.html" class="btn btn-sm btn-primary mt-3">Learn More</a>
                </div>
            </div>
        </div>
        <div class="text-center mt-5">
            <a href="services.html" class="btn btn-primary btn-lg">View All Services</a>
        </div>
    </div>
</section> -->

@endsection

@push('pageScripts')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDWEvQU0xphr90Ijr21eYLHZ0-WWiLzKt8&libraries=places&callback=initAutocomplete" async defer></script>
<script src="{{ asset('assets/js/google_location.js') }}?v=1.9"></script>
@endpush