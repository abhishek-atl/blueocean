<div class="page-section">
    <div class="row justify-content-center text-center">
        <div class="col-12">
            <span class="section-eyebrow">Out at-home Treatments</span>
            <h2>Bring relaxation to your doorstep.</h2>
            <p>From booking to treatment, the experience is built to be clear, flexible, and reliable.</p>
        </div>
    </div>
</div>

<div class="row g-4 mt60">
    @foreach($treatments as $treatment)
    <div class="col-12 col-md-6 col-lg-4">
        <article class="custom-card h-100">

            @if($treatment->getRawOriginal('image'))
            <a href="{{ route('treatment_detail', $treatment->slug) }}" class="custom-card-image">
                <img
                    src="{{ $treatment->image }}"
                    alt="{{ $treatment->image_alt ?: $treatment->name }}"
                    title="{{ $treatment->image_title ?: $treatment->name }}"
                    class="img-fluid">
            </a>
            @endif

            <div class="custom-card-body">
                <h2>{{ $treatment->name }}</h2>

                @if($treatment->title)
                <p class="custom-card-title">{{ $treatment->title }}</p>
                @endif

                @if($treatment->summary)
                <div class="custom-card-summary">
                    {!! Str::limit(strip_tags($treatment->summary), 100) !!}
                </div>
                @endif

                <div class="custom-card-actions">
                    <div class="custom-card-price">
                        @if($treatment->price)
                        From <strong>£{{ number_format($treatment->price, 2) }}</strong>
                        @else
                        From <strong>£{{ number_format(59, 2) }}</strong>
                        @endif
                    </div>
                    <div class="custom-card-details-link">
                        <a href="{{ route('treatment_detail', $treatment->slug) }}" class="btn btn-primary">View Treatment</a>
                    </div>
                </div>
            </div>
        </article>
    </div>
    @endforeach

    <div class="row justify-content-center text-center mt-5">
        <div class="col-12">
            <a href="{{ route('bookingPostcode') }}" class="btn btn-secondary">Book a Treatment</a>
        </div>
    </div>

</div>