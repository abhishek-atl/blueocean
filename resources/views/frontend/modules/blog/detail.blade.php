@extends('frontend.layouts.default')

@inject('format', 'App\Services\FormatService')

@section('title',$post->page_meta_title)
@section('description', $post->page_meta_tag)

@section('content')


<section class="page-hero">
    <div class="container">
        <div class="row justify-content-center text-center">
            <div class="col-lg-8">
                <h1>{{ $post->title }}</h1>
            </div>
        </div>
    </div>
</section>

<div class="page-section">

    <div class="container">
        <div class="row">

            <div class="col-md-12 d-flex justify-content-between align-items-center mb-3">
                <div>Last updated {{ Carbon\Carbon::parse($post->updated_at)->format(config('custom.format.date_short')) }}</div>
                <div>
                    @if(!empty($post->tags))
                    @if(!empty($post->tags))
                    @foreach ($post->tags as $key => $tag)
                    <span class="badge rounded-pill text-bg-secondary p-3"><a href="{{ route('blog',['tag' => strtolower($tag->name)]) }}" class="text-white">{{ $tag->name }}</a></span>
                    @endforeach
                    @endif
                </div>
                @endif
            </div>

            <div class="col-md-12">
                <img class="img-fluid float-end m-3" src="{{ $post->image}}" alt="{{ $post->image_alt }}" title="{{ $post->image_title }}">
                {!! Str::replace('[[BOOKING]]', $bookingBlockHtml, $post->content) !!}
            </div>
        </div>

        <h2 class="py-4">Related Posts</h2>
        <div class="row g4">
            @foreach($posts as $post)
            <div class="col-12 col-md-6 col-lg-4">
                <article class="custom-card h-100">

                    @if($post->getRawOriginal('image'))
                    <a href="{{ route('blog_detail', $post->slug) }}" class="custom-card-image">
                        <img
                            src="{{ $post->image }}"
                            alt="{{ $post->image_alt ?: $post->name }}"
                            title="{{ $post->image_title ?: $post->name }}"
                            class="img-fluid">
                    </a>
                    @endif

                    <div class="custom-card-body">
                        <h2>{{ $post->title }}</h2>

                        <div class="custom-card-summary">
                            {!! Str::limit(strip_tags($post->content), 100) !!}
                        </div>


                        <div class="custom-card-actions">
                            <div class="custom-card-details-link">
                                <a href="{{ route('blog_detail', $post->slug) }}" class="btn btn-primary">Read More</a>
                            </div>
                        </div>
                        <span class="pt-1"><small>Updated on {{ Carbon\Carbon::parse($post->updated_at)->format(config('custom.format.date_short')) }} under {{ $post->tags[0]->name }}</small></span><br>
                    </div>
                </article>
            </div>
            @endforeach
        </div>

    </div>
</div>

@endsection