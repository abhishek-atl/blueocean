@extends('frontend.layouts.default')

@section('title', $treatment->page_meta_title ?: $treatment->name)

@push('meta')
@if($treatment->page_meta_tag)
<meta name="description" content="{{ $treatment->page_meta_tag }}">
@endif
@if($treatment->extra_meta_tags)
{!! $treatment->extra_meta_tags !!}
@endif
@endpush

@section('content')
<section class="page-detail-hero">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <h1>{{ $treatment->title }}</h1>

                @if($treatment->summary)
                {!! $treatment->summary !!}
                @endif

                @if($treatment->cta_button_visible && $treatment->cta_button_text && $treatment->cta_button_url)
                <a href="{{ $treatment->cta_button_url }}" class="btn btn-primary mt-3">{{ $treatment->cta_button_text }}</a>
                @else
                <a href="{{ route('bookingPostcode') }}" class="btn btn-primary mt-3">Book Now</a>
                @endif
            </div>

            @if($treatment->getRawOriginal('image'))
            <div class="col-lg-6">
                <img
                    class="treatment-detail-image img-fluid"
                    src="{{ $treatment->image }}"
                    alt="{{ $treatment->image_alt ?: $treatment->name }}"
                    title="{{ $treatment->image_title ?: $treatment->name }}">
            </div>
            @endif
        </div>
    </div>
</section>

<section class="page-section">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col">
                {!! $treatment->description !!}
            </div>
        </div>
    </div>

</section>
@endsection