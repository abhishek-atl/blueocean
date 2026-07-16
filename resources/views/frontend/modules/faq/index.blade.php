@extends('frontend.layouts.default')

@section('title')
Frequently Asked Questions - {{ config('app.name') }}
@endsection

@section('description')
Frequently Asked Questions about our massage.
@endsection

@section('content')

<section class="page-hero">
    <div class="container">
        <div class="row justify-content-center text-center">
            <div class="col-lg-8">
                <h1>Frequently Asked Questions</h1>
            </div>
        </div>
    </div>
</section>

<div class="page-section">

    <div class="container">
        <div class="row">
            <div class="col-md-12 p-0">
                <div class="accordion" id="accordionFaq">
                    @foreach($faqs as $faq)
                    <div class="accordion-item">
                        <h3 class="accordion-header" id="heading_{{$faq->id}}">
                            <button class="accordion-button @if(!$loop->first) collapsed @endif" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_{{$faq->id}}" aria-expanded="{{ $loop->first ? 'true' : 'false' }}" aria-controls="collapse_{{$faq->id}}">
                                {!! $faq->question !!}
                            </button>
                        </h3>
                        <div id="collapse_{{$faq->id}}" class="accordion-collapse collapse @if($loop->first) show @endif" data-bs-parent="#accordionFaq">
                            <div class="accordion-body">
                                {!! $faq->answer !!}
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
