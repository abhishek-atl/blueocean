<div class="pt60">
    <div class="row justify-content-center text-center">
        <div class="col-12">
            <span class="section-eyebrow">Our Professionals</span>
            <h2>Meet our Professionals.</h2>
            <p>Reliable, expert and vetted professionals.</p>
        </div>
    </div>
</div>

<div class="row g-4 pb60">
    <div class="owl-corousel-therapists-container">
        <div class="owl-corousel-therapists owl-carousel owl-theme">
            @foreach($therapists as $therapist)
            <div class="item">
                <article class="h-100">
                    @if($therapist->user_profile?->getRawOriginal('image'))
                    <a href="{{ route('therapist_detail', $therapist->therapist_profile->slug) }}" class="custom-card-image">
                        <img
                            src="{{ $therapist->user_profile->image }}"
                            alt="{{ $therapist->first_name }} {{ $therapist->last_name }}"
                            class="rounded-circle">
                    </a>
                    @endif

                    <div class="text-center">
                        <h2>{{ $therapist->first_name }}</h2>

                        <div class="justify-content-center">
                            <a href="{{ route('therapist_detail', $therapist->therapist_profile->slug) }}" class="link-primary">View Profile</a>
                        </div>
                    </div>
                </article>
            </div>
            @endforeach
        </div>

    </div>
</div>

@push('pageCss')
<style>
    .owl-corousel-therapists-container {
        padding: 20px 0;
    }

    .owl-corousel-therapists-container .item:hover img {
        transform: scale(1.04);
    }

    .owl-corousel-therapists h2 {
        color: var(--bo-blue);
        font-size: 1.5em;
        margin: 20px 0;
    }

    @media (max-width: 767.98px) {
        .owl-corousel-therapists h2 {
            font-size: 1.2em;
            font-weight: bold;
        }

    }

    .owl-corousel-therapists .link-primary {
        color: var(--bo-blue) !important;
        font-size: 1em;
    }

    .owl-corousel-therapists .link-primary:hover {
        font-weight: bold;
    }

    .owl-corousel-therapists .owl-nav button.owl-prev,
    .owl-corousel-therapists .owl-nav button.owl-next {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: var(--bo-blue);
        color: #fff;
    }
</style>
@endpush

@push('pageScripts')
<script>
    $(document).ready(function() {
        $('.owl-corousel-therapists').owlCarousel({
            nav: true,
            dots: false,
            loop: true,
            margin: 10,
            center: true,
            autowidth: true,
            stagePadding: 40,
            responsive: {
                0: {
                    items: 3,
                    mouseDrag: true,
                    stagePadding: 20,
                },
                992: {
                    items: 5,
                    mouseDrag: false,
                }
            },
            navText: [
                '<i class="fa fa-arrow-left" aria-hidden="true"></i>',
                '<i class="fa fa-arrow-right" aria-hidden="true"></i>'
            ]
        });
    });
</script>
@endpush