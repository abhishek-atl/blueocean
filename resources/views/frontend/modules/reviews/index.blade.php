@extends('frontend.layouts.default')

@section('title')
Reviews - {{ config('app.name') }}
@endsection

@section('description')
Read reviews from our satisfied customers.
@endsection

@section('content')

<section class="page-hero">
    <div class="container">
        <div class="row justify-content-center text-center">
            <div class="col-lg-8">
                <h1>Massage Reviews and Testimonials</h1>
            </div>
        </div>
    </div>
</section>

<div class="page-section reviews-page">
    <div class="container">

        <div class="row justify-content-center text-center card-style p-4 mb-5">
            <div class="card-body">
                <h2 class="mb-3">What Our Clients Say About Us</h2>
                <p>We take pride in providing exceptional massage services to our clients. Here are some of the reviews and testimonials from our satisfied customers.</p>
                <p class="text-center"><strong>Outstanding</strong> <br /><img src="{{ asset('assets/img/star.png') }}" alt="5-star-reviews-icon" title="alt=" 5-star-reviews-icon" width="124" /></p>
                <p class="text-center">Average rating {{ $averageRating }}/5.00 from {{ $totalReviews }} reviews</p>
                <p class="text-center">Best Rating 5/5</p>
                <a href="{{ route('add_review') }}" class="btn btn-primary">Submit Your Review</a>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 p-0 review-list">
                @foreach($reviews as $review)
                <blockquote class="blockquote blockquote-custom review-card bg-white p-3 mt-5 shadow rounded">
                    <div class="blockquote-custom-icon shadow-sm"><i class="fa fa-quote-left text-white"></i></div>
                    <p class="mb-0 mt-3 font-italic">{!! $review->comment !!}</p>
                    <footer class="text-muted d-flex align-items-center justify-content-between">
                        <span>Posted by {{ $review->first_name }} {{ $review->last_name }}</span>
                        @if($review->evaluation)
                        <span class="float-right review-rating">Rated:
                            @for($i=1; $i<= $review->evaluation; $i++)
                                <img src="{{ asset('assets/img/reviews/stars/star-on.png') }}" alt="Star Rating" />
                                @endfor
                        </span>
                        @endif
                    </footer>
                </blockquote>
                @endforeach
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 d-flex justify-content-center">
                {{ $reviews->onEachSide(0)->links() }}
            </div>
        </div>

    </div>
</div>
@endsection

@push('pageCss')
<style>
    .reviews-page .review-list {
        max-width: 900px;
        margin: 0 auto;
    }

    .reviews-page .review-card {
        position: relative;
        padding: 32px 28px 24px !important;
        border: 1px solid rgba(84, 107, 128, .14);
        border-radius: 12px !important;
        box-shadow: 0 12px 32px rgba(84, 107, 128, .1) !important;
    }

    .reviews-page .blockquote-custom-icon {
        position: absolute;
        top: -22px;
        left: 28px;
        display: flex;
        width: 44px;
        height: 44px;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: var(--bo-blue);
    }

    .reviews-page .review-card p {
        color: var(--text-color);
        font-size: 1rem;
        line-height: 1.75;
    }

    .reviews-page .blockquote-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        padding-top: 16px;
        color: var(--text-muted-color);
        font-size: .9rem;
    }

    .reviews-page .review-rating {
        display: inline-flex;
        align-items: center;
        gap: 3px;
        white-space: nowrap;
    }

    .reviews-page .review-rating img {
        width: 16px;
        height: 16px;
    }

    .review-list footer {
        margin-top: 16px;
        background-color: var(--bo-lightblue);
        padding: 8px 16px;
    }

    @media (max-width: 575.98px) {
        .reviews-page .review-card {
            padding: 30px 20px 20px !important;
        }

        .reviews-page .blockquote-footer {
            align-items: flex-start;
            flex-direction: column;
        }
    }
</style>
@endpush