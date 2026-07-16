@extends('frontend.layouts.default')

@if(!$seoMeta)
@section('title', 'Massage Matters: Read Our Latest Blog Posts' . ($currentTag ? ' - ' . ucfirst($currentTag) : '') . ($posts->currentPage() > 1 ? ' | Page ' . $posts->currentPage() : ''))
@section('description', 'Explore our latest blog posts' .
($currentTag === 'all' ? ' about everything to do with massage therapy services, health, treatments and therapists in ' :
($currentTag ? ' with a particular focus on ' .
($currentTag === 'massage' ? 'aspects relevant to getting a mobile massage treatment in ' :
($currentTag === 'health' ? 'the remedial health benefits of massage treatments and therapies in ' :
($currentTag === 'therapists' ? 'massage therapists and their views about massage therapy in ' : 'all other aspects of therapeutic massage services in ')))
: ' all aspects of ')) . 'London. Page ' . $posts->currentPage())
@else
@section('title', str_replace('[[page]]', $posts->currentPage(), $seoMeta->page_meta_title))
@section('description', $seoMeta->page_meta_tag)
@endif


@section('content')

<section class="page-hero">
    <div class="container">
        <div class="row justify-content-center text-center">
            <div class="col-lg-8">
                <h1>Massage Blog</h1>
            </div>
        </div>
    </div>
</section>

<div class="page-section">

    <div class="container">

        <div class="row py-4">
            <div class="col">
                <ul class="nav nav-pills">
                    <li class="nav-item">
                        <a class="nav-link @if($currentTag === 'all') active @endif" aria-current="page" href="{{ route('blog') }}">All</a>
                    </li>
                    @foreach($tags as $key => $tag)
                    <li class="nav-item">
                        <a class="nav-link @if($currentTag === strtolower($tag->name)) active @endif" aria-current="page" href="{{ route('blog', ['tag' => strtolower($tag->name)]) }}">{{ $tag->name }}</a>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="row g-4">
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
        <div class="row">
            <div class="col-md-12 d-flex justify-content-center">
                {{ $posts->onEachSide(0)->links() }}
            </div>
        </div>

    </div>
</div>
@endsection