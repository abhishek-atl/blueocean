    <div class="row justify-content-center text-center">
        <div class="col-12">
            <span class="section-eyebrow">Review</span>
            <h2>Exceptional Reviews, Exceptional Care.</h2>
            <p>Why Clients Keep Coming Back.</p>
        </div>
    </div>

    <div class="row g-4">
        <div class="owl-corousel-testimonial-container">
            <div class="owl-corousel-testimonial owl-carousel owl-theme">
                @foreach($reviews as $review)
                <div class="review-card position-relative p-4">
                    <p>{!! Str::limit(strip_tags($review->comment), 190) !!}</p>
                    <div class="review-author">{{ $review->first_name }} {{ $review->last_name }}, {{ $review->location }}</div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="d-flex justify-content-center text-center mb-4">
            <a href="{{ route('reviews') }}" class="btn btn-primary" title="Read More Reviews">
                Read More Reviews
            </a>
        </div>
    </div>

    @push('pageCss')
    <style>
        .owl-corousel-testimonial-container {
            padding: 12px 0 24px;
        }

        .owl-corousel-testimonial .review-card {
            height: 100%;
            background: #fff;
            border: 1px solid rgba(84, 107, 128, 0.12);
            border-radius: 12px;
            box-shadow: 0 10px 28px rgba(84, 107, 128, 0.1);
            width: 400px;
        }

        @media screen and (max-width: 768px) {
            .owl-corousel-testimonial .review-card {
                width: 100%;
            }
        }

        .owl-corousel-testimonial .review-card p {
            margin-bottom: 20px;
            line-height: 1.7;
        }

        .owl-corousel-testimonial .review-author {
            color: var(--bo-blue);
            font-size: 0.9rem;
            font-weight: 700;
        }

        .owl-corousel-testimonial .owl-stage {
            display: flex;
        }

        .owl-corousel-testimonial .owl-item {
            display: flex;
        }

        .owl-corousel-testimonial .owl-nav button.owl-prev,
        .owl-corousel-testimonial .owl-nav button.owl-next {
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
        $('.owl-corousel-testimonial').owlCarousel({
            nav: true,
            loop: true,
            items: 3,
            center: true,
            autoplay: true,
            autoplayTimeout: 5000,
            responsive: {
                0: {
                    items: 1,
                    dots: true,
                    mouseDrag: true,
                },
                768: {
                    items: 2,
                    dots: true,
                    mouseDrag: true,
                },
                992: {
                    items: 3,
                    dots: false,
                    mouseDrag: false,
                }
            },
            margin: 10,
            stagePadding: 0,
            navText: [
                '<i class="fa fa-arrow-left" aria-hidden="true"></i>',
                '<i class="fa fa-arrow-right" aria-hidden="true"></i>'
            ],
            autowidth: false,
        });
    </script>
    @endpush