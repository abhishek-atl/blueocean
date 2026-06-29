@extends('frontend.layouts.default')

@section('title')
Book a Massage in London - Mobile Therapists | {{ config('app.name') }}
@endsection

@section('description')
Book a relaxing, professional massage at home in London. Our trusted mobile therapists deliver expert
treatments with genuine care, from just £59
@endsection

@if($banner)
@section('banner')
<div class="alert alert-info alert-dismissible fade show m-0" role="alert">
    <div class="text-center">{!! $banner->text !!}</div>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endsection
@endif

@section('content')

<section class="jumbotron">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="content">
                    <h1>Massage at home. Effortless.</h1>
                    <p>Your space, Your time, Your terms.</p>
                    <a href="{{ route('bookingPostcode') }}" class="btn btn-secondary">Book Now</a>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="container">
    @include('frontend.modules.home.how-it-works')
</div>

<div class="container">
    @include('frontend.modules.home.therapists')
</div>

<div class="container">
    @include('frontend.modules.home.home-treatments')
</div>

<div class="container">
    @include('frontend.modules.home.cta')
</div>



@endsection