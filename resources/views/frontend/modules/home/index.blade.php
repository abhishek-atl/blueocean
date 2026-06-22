@extends('frontend.layouts.default')

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
    @include('frontend.modules.home.home-treatments')
</div>

<div class="container">
    @include('frontend.modules.home.cta')
</div>



@endsection