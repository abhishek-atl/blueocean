@extends('frontend.layouts.default')

@inject('format', 'App\Services\FormatService')

@section('title',$page->page_meta_title)
@section('description', $page->page_meta_tag)

@section('content')


<section class="page-hero">
    <div class="container">
        <div class="row justify-content-center text-center">
            <div class="col-lg-8">
                <h1>{{ $page->title }}</h1>
            </div>
        </div>
    </div>
</section>

<div class="page-section">

    <div class="container">
        <div class="row">

            <div class="col-md-12">
                <img class="img-fluid float-end m-3" src="{{ $page->image}}" alt="{{ $page->image_alt }}" title="{{ $page->image_title }}">
                {!! Str::replace('[[BOOKING]]', $bookingBlockHtml, $page->content) !!}
            </div>
        </div>

    </div>
</div>

@endsection