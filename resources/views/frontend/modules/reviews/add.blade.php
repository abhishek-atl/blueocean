@extends('frontend.layouts.default')

@section('title')
Add a Review - {{ config('app.name') }}
@endsection

@section('description')
Share your experience with us and help us improve our services.
@endsection

@section('content')

<section class="page-hero">
    <div class="container">
        <div class="row justify-content-center text-center">
            <div class="col-lg-8">
                <h1>Add a Review</h1>
            </div>
        </div>
    </div>
</section>

<div class="page-section reviews-page">
    <div class="container">

        <div class="row">

            <div class="col-md-6">
                <div class="content-panel">
                    <form id="frmReview" method="post" action="{{ route('post_review') }}">
                        @csrf

                        <div class="col-md-12">
                            <label class="form-label" for="first_name">First Name</label>
                            <input type="text" class="form-control" id="first_name" name="first_name" value="{{ old('first_name') }}">
                            @error('first_name')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-12">
                            <label class="form-label" for="last_name">Last Name</label>
                            <input type="text" class="form-control" id="last_name" name="last_name" value="{{ old('last_name') }}">
                            @error('last_name')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-12">
                            <label class="form-label" for="email">Email</label>
                            <input type="text" class="form-control" id="email" name="email" value="{{ old('email') }}">
                            @error('email')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-12">
                            <label class="form-label" for="location">Location</label>
                            <input type="text" class="form-control" id="location" name="location" value="{{ old('location') }}">
                            @error('location')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-12">
                            <label class="form-label" for="rating">Rating</label>
                            <div id="rating" class="rating"></div>
                            <input type="text" class="form-control" name="evaluation" id="evaluation" style="opacity: 0; height:0px !important;" />
                        </div>

                        <div class="col-md-12 mb-4">
                            <label class="form-label" for="comment">Comments</label>
                            <textarea class="form-control" name="comment" id="comment" rows="3"></textarea>
                            @error('comment')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <button type="submit" class="submit btn btn-primary">Post Comment</button>
                        </div>

                    </form>
                </div>
            </div>

            <div class="col-md-6 justify-content-center text-center card-style p-4 mb-5">
                <div class="card-body">
                    <h2 class="mb-3">What Our Clients Say About Us</h2>
                    <p>We take pride in providing exceptional massage services to our clients. Here are some of the reviews and testimonials from our satisfied customers.</p>
                    <p class="text-center"><strong>Outstanding</strong> <br /><img src="{{ asset('assets/img/star.png') }}" alt="5-star-reviews-icon" title="5-star-reviews-icon" width="124" /></p>
                    <p class="text-center">Average rating {{ $averageRating }}/5.00 from {{ $totalReviews }} reviews</p>
                    <p class="text-center">Best Rating 5/5</p>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@push('pageCss')
<style>
    .rating {
        font-size: 2rem;
    }

    #frmReview .fa-star {
        color: var(--bo-blue);
    }
</style>
@endpush

@push('pageScripts')
<script src="{{ asset('assets/js/jquery.raty.js') }}"></script>
<script type="text/javascript">
    $('document').ready(function() {

        $('.rating').raty({
            target: '#evaluation',
            targetType: 'score',
            targetKeep: true,
            starType: 'i',
            starOn: 'fa-solid fa-star',
            starOff: 'fa-regular fa-star',
        });
    });
</script>
{!! JsValidator::formRequest('App\Http\Requests\StoreReviewRequest', '#frmReview') !!}
@endpush