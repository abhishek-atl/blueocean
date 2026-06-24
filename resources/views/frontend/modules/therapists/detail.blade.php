@extends('frontend.layouts.default')

@section('title', $therapist->therapist_profile->page_meta_title ?: $therapist->first_name . ' ' . $therapist->last_name)

@push('meta')
@if($therapist->therapist_profile->page_meta_tag)
<meta name="description" content="{{ $therapist->therapist_profile->page_meta_tag }}">
@endif
@if($therapist->therapist_profile->extra_meta_tags)
{!! $therapist->therapist_profile->extra_meta_tags !!}
@endif
@endpush

@section('content')
<section class="page-hero">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-md-12">
                <h1>{{ $therapist->first_name }} {{ $therapist->last_name }}</h1>
            </div>
        </div>
    </div>
</section>


<section class="page-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">

                @if($therapist->user_profile?->getRawOriginal('image'))
                <img
                    class="treatment-detail-image img-fluid"
                    src="{{ $therapist->user_profile->image }}"
                    alt="{{ $therapist->first_name }} {{ $therapist->last_name }}">
                @endif
            </div>

            <div class="col-md-8">

                <div class="">
                    {!! $therapist->therapist_profile->about !!}
                </div>

                @if($therapist->treatments->isNotEmpty())
                <div class="mt-3">
                    <h5>Treatments</h5>
                    <ul>
                        @foreach($therapist->treatments as $treatment)
                        <li><a href="{{ route('treatment_detail', $treatment->slug) }}">{{ $treatment->name }}</a></li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <div class="mt-3">
                    <a href="{{ route('bookingPostcode') }}" class="btn btn-primary">Book Now</a>
                </div>

            </div>

        </div>
    </div>
</section>

@endsection