@extends('frontend.layouts.default')

@section('title', 'Treatments')

@section('content')
<section class="treatments-hero">
    <div class="container">
        <div class="row justify-content-center text-center">
            <div class="col-lg-8">
                <h1>Massage Treatments</h1>
                <p>Choose from our available treatments and book a therapist at your home or hotel.</p>
            </div>
        </div>
    </div>
</section>

<div class="container">

    <section class="treatments-categories">
        <div class="row py-4">
            <div class="col">
                <ul class="nav nav-pills">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{ route('treatments') }}">All</a>
                    </li>
                    @foreach($categories as $category)
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="{{ route('treatments', ['category' => $category['slug']]) }}">{{ $category['name'] }}</a>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </section>


    <section class="treatments-section">
        @if($treatments->isEmpty())
        <div class="alert alert-info mb-0" role="alert">
            No treatments are available at the moment.
        </div>
        @else
        <div class="row g-4">
            @foreach($treatments as $treatment)
            <div class="col-12 col-md-6 col-lg-4">
                <article class="treatment-card h-100">

                    @if($treatment->getRawOriginal('image'))
                    <a href="{{ route('treatment_detail', $treatment->slug) }}" class="treatment-card-image">
                        <img
                            src="{{ $treatment->image }}"
                            alt="{{ $treatment->image_alt ?: $treatment->name }}"
                            title="{{ $treatment->image_title ?: $treatment->name }}"
                            class="img-fluid">
                    </a>
                    @endif

                    <div class="treatment-card-body">
                        <h2>{{ $treatment->name }}</h2>

                        @if($treatment->title)
                        <p class="treatment-card-title">{{ $treatment->title }}</p>
                        @endif

                        @if($treatment->summary)
                        <div class="treatment-card-summary">
                            {!! Str::limit(strip_tags($treatment->summary), 100) !!}
                        </div>
                        @endif

                        <div class="treatment-card-actions">
                            <div class="treatment-card-price">
                                @if($treatment->price)
                                From <strong>£{{ number_format($treatment->price, 2) }}</strong>
                                @else
                                From <strong>£{{ number_format(59, 2) }}</strong>
                                @endif
                            </div>
                            <div class="treatment-card-details-link">
                                <a href="{{ route('treatment_detail', $treatment->slug) }}" class="btn btn-primary">View Treatment</a>
                            </div>
                        </div>
                    </div>
                </article>
            </div>
            @endforeach
        </div>
        @endif
    </section>
</div>
@endsection

@push('pageCss')
<link rel="stylesheet" href="{{ asset('assets/css/treatments.css') }}">
@endpush