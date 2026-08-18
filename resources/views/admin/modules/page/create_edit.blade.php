@extends('admin.layouts.default')

@section('title', $page ? 'Edit Page' : 'Create Page')

@section('content')
<div class="container-fluid">
    <div class="row py-4">
        <div class="col-md-12">
            <div class="card-style d-flex flex-wrap align-items-center justify-content-between">
                <div class="title">
                    <h2>{{ $page ? 'Edit Page' : 'Create Page' }}</h2>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.pages.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        @if($page)
        <input type="hidden" name="id" value="{{ $page->id }}">
        @endif

        <div class="row">
            <div class="col-lg-12">
                <div class="card-style mb-30">
                    <div class="mb-3">
                        <label class="form-label required" for="title">Title</label>
                        <input type="text" name="title" id="title" class="form-control" placeholder="Page Title" value="{{ old('title', $page?->title) }}">
                        @error('title')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label required" for="slug">Slug</label>
                        <input type="text" name="slug" id="slug" class="form-control" placeholder="page-slug" value="{{ old('slug', $page?->slug) }}">
                        @error('slug')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label required" for="author">Author</label>
                        <input type="text" name="author" id="author" class="form-control" placeholder="Author Name" value="{{ old('author', $page?->author) }}">
                        @error('author')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label required" for="content">Content</label>
                        <textarea name="content" id="content" class="form-control editor" rows="8" placeholder="Page Content">{{ old('content', $page?->content) }}</textarea>
                        @error('content')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="card-style mb-30">
                    @include('admin.modules.common.image_form_field', ['entity' => $page])
                </div>
            </div>

            <div class="col-lg-12">
                <div class="card-style mb-30">
                    @include('admin.modules.common.seo_form_fields', ['entity' => $page])
                </div>
            </div>

            <div class="col-lg-12">
                <div class="card-style mb-30">
                    <div class="mb-3 col-3">
                        <label class="form-label col-4 required">Active</label>
                        <div class="form-check form-check-inline radio-style mb-20">
                            <input type="radio" name="active" id="active_y" value="1" @checked((string) old('active', $page?->active ?? 1) === '1')>
                            <label class="form-check-label" for="active_y">Yes</label>
                        </div>
                        <div class="form-check form-check-inline radio-style mb-20">
                            <input type="radio" name="active" id="active_n" value="0" @checked((string) old('active', $page?->active ?? 1) === '0')>
                            <label class="form-check-label" for="active_n">No</label>
                        </div>
                        @error('active')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="card-style mb-30">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <a href="{{ route('admin.pages.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('pageScripts')
<script>
    $(document).ready(function() {
        $('#title').on('blur', function() {
            var slug = $(this).val().toLowerCase()
                .trim()
                .replace(/[^\w\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-');
            $('#slug').val(slug);
        });
    });
</script>

@include('admin.modules.common.tinymce')
@endpush
