<div class="page-section">
    <div class="row justify-content-center text-center">
        <div class="col-12">
            <span class="section-eyebrow">Our Professionals</span>
            <h2>Meet out Professionals.</h2>
            <p>Reliable, expert and vetted professionals.</p>
        </div>
    </div>
</div>

<div class="row g-4">
    @forelse($therapists as $therapist)
    <div class="col-12 col-md-6 col-lg-4">
        <article class="custom-card rounded-card h-100">
            @if($therapist->user_profile?->getRawOriginal('image'))
            <a href="{{ route('therapist_detail', $therapist->therapist_profile->slug) }}" class="custom-card-image">
                <img
                    src="{{ $therapist->user_profile->image }}"
                    alt="{{ $therapist->first_name }} {{ $therapist->last_name }}"
                    class="img-fluid">
            </a>
            @endif

            <div class="custom-card-body">
                <h2>{{ $therapist->first_name }} {{ $therapist->last_name }}</h2>

                @if($therapist->therapist_profile->about)
                <div class="custom-card-summary">
                    {{ Str::limit(strip_tags($therapist->therapist_profile->about), 100) }}
                </div>
                @endif

                <div class="custom-card-actions">
                    <div class="custom-card-details-link ms-auto">
                        <a href="{{ route('therapist_detail', $therapist->therapist_profile->slug) }}" class="btn btn-primary">View Therapist</a>
                    </div>
                </div>
            </div>
        </article>
    </div>
    @empty
    <div class="col text-center">
        <p>No therapists are currently available.</p>
    </div>
    @endforelse
</div>