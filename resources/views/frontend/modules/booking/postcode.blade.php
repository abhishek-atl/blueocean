@extends('frontend.layouts.default')

@section('content')
<section class="hero">
    <div class="hero-content">
        @include('frontend.modules.booking.partials.booking_block')
    </div>
</section>

@endsection

@push('pageScripts')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDWEvQU0xphr90Ijr21eYLHZ0-WWiLzKt8&libraries=places&callback=initAutocomplete" async defer></script>
<script src="{{ asset('assets/js/google_location.js') }}?v=1.9"></script>
@endpush