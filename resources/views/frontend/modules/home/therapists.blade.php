<div class="page-section-padding">
    <div class="row justify-content-center text-center">
        <div class="col-12">
            <span class="section-eyebrow">Our Professionals</span>
            <h2>Meet our Professionals.</h2>
            <p>Reliable, expert and vetted professionals.</p>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="owl-corousel-container">
        <div class="owl-corousel-therapists owl-carousel owl-theme">
            @foreach($therapists as $therapist)
            <div class="item">
                <article class="rounded-card h-100">
                    @if($therapist->user_profile?->getRawOriginal('image'))
                    <a href="{{ route('therapist_detail', $therapist->therapist_profile->slug) }}" class="custom-card-image">
                        <img
                            src="{{ $therapist->user_profile->image }}"
                            alt="{{ $therapist->first_name }} {{ $therapist->last_name }}"
                            class="img-fluid">
                    </a>
                    @endif

                    <div class="custom-card-body text-center">
                        <h2>{{ $therapist->first_name }} {{ $therapist->last_name }}</h2>

                        @if($therapist->therapist_profile->about)
                        <div class="custom-card-summary">
                            {{ Str::limit(strip_tags($therapist->therapist_profile->about), 40) }}
                        </div>
                        @endif

                        <div class="custom-card-actions justify-content-center">
                            <div class="custom-card-details-link">
                                <a href="{{ route('therapist_detail', $therapist->therapist_profile->slug) }}" class="btn btn-primary">View Therapist</a>
                            </div>
                        </div>
                    </div>
                </article>
            </div>
            @endforeach
        </div>
        <div class="owl-theme">
            <div class="owl-controls">
                <div class="custom-nav owl-nav"></div>
            </div>
        </div>
    </div>
</div>

@push('pageScripts')
<script>
    $(document).ready(function() {
        $('.owl-corousel-therapists').owlCarousel({
            navContainer: '.owl-corousel-container .custom-nav',
            nav: true,
            loop: true,
            items: 3,
            responsive: {
                0: {
                    items: 1,
                    stagePadding: 0,
                    dots: true,
                    mouseDrag: true,
                },
                768: {
                    items: 2,
                    stagePadding: 0,
                    dots: true,
                    mouseDrag: true,
                },
                992: {
                    items: 3,
                    stagePadding: 5,
                    dots: false,
                    mouseDrag: false,
                }
            },
            center: true,
            margin: 20,
            stagePadding: 40,
            navText: [
                '<i class="fa fa-arrow-left" aria-hidden="true"></i>',
                '<i class="fa fa-arrow-right" aria-hidden="true"></i>'
            ],
            autowidth: true,

        });
    });
</script>
@endpush