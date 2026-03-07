@extends('admin.layouts.default')

@if(isset($post))
@section('title', 'Edit Post')
@else
@section('title', 'Create Post')
@endif

@section('content')

<div class="container-fluid">
    <div class="row py-4">
        <div class="col-md-12">
            <div class="card-style d-flex flex-wrap align-items-center justify-content-between">
                <div class="title">
                    @if(isset($post))
                    <h2>Edit Post</h2>
                    @else
                    <h2>Create Post</h2>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.posts.store') }}" method="post" enctype="multipart/form-data">

        @csrf

        @isset($post)
        <input type="hidden" name="id" value="{{ $post->id }}" />
        @endisset

        <div class="row">

            <div class="col-lg-12">
                <div class="card-style mb-30">

                    <div class="mb-3">
                        <label class="form-label required" for="title">Title</label>
                        <input type="text" name="title" id="title" class="form-control" placeholder="Post Title" value="{{ old('title', $post->title ?? '') }}" />
                        @error('title')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label required" for="slug">Slug</label>
                        <input type="text" name="slug" id="slug" class="form-control" placeholder="post-slug" value="{{ old('slug', $post->slug ?? '') }}" />
                        @error('slug')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label required" for="author">Author</label>
                        <input type="text" name="author" id="author" class="form-control" placeholder="Author Name" value="{{ old('author', $post->author ?? '') }}" />
                        @error('author')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label required" for="summary">Summary</label>
                        <textarea name="summary" id="summary" class="form-control" rows="3" placeholder="Post Summary">{{ old('summary', $post->summary ?? '') }}</textarea>
                        @error('summary')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label required" for="content">Content</label>
                        <textarea name="content" id="content" class="form-control" rows="8" placeholder="Post Content">{{ old('content', $post->content ?? '') }}</textarea>
                        @error('content')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="post_tag_id">Tags</label>
                        <select name="post_tag_id[]" id="post_tag_id" class="form-control" multiple>
                            @foreach($tags as $tag)
                            <option value="{{ $tag->id }}" @if(in_array($tag->id, $postTagIds)) selected="selected" @endif>{{ $tag->name }}</option>
                            @endforeach
                        </select>
                        @error('post_tag_id')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                </div>
            </div>

            <div class="col-lg-12">
                <div class="card-style mb-30">

                    <div class="mb-3">
                        <label class="form-label" for="image">Featured Image</label>
                        <input type="file" name="image" id="image" class="form-control" accept="image/*" />
                        @error('image')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                        @if(isset($post) && $post->image)
                        <div class="mt-2">
                            <img src="{{ asset($post->image) }}" alt="Post Image" style="max-width: 200px; max-height: 200px;">
                        </div>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="image_alt">Image Alt Text</label>
                        <input type="text" name="image_alt" id="image_alt" class="form-control" placeholder="Image Alt Text" value="{{ old('image_alt', $post->image_alt ?? '') }}" />
                        @error('image_alt')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="image_title">Image Title</label>
                        <input type="text" name="image_title" id="image_title" class="form-control" placeholder="Image Title" value="{{ old('image_title', $post->image_title ?? '') }}" />
                        @error('image_title')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                </div>
            </div>

            <div class="col-lg-12">
                <div class="card-style mb-30">

                    <div class="mb-3">
                        <label class="form-label" for="meta_title">Meta Title</label>
                        <input type="text" name="meta_title" id="meta_title" class="form-control" placeholder="Meta Title" value="{{ old('meta_title', $post->meta_title ?? '') }}" />
                        @error('meta_title')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="meta_description">Meta Description</label>
                        <textarea name="meta_description" id="meta_description" class="form-control" rows="3" placeholder="Meta Description">{{ old('meta_description', $post->meta_description ?? '') }}</textarea>
                        @error('meta_description')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="extra_meta_tags">Extra Meta Tags</label>
                        <textarea name="extra_meta_tags" id="extra_meta_tags" class="form-control" rows="3" placeholder="Extra Meta Tags">{{ old('extra_meta_tags', $post->extra_meta_tags ?? '') }}</textarea>
                        @error('extra_meta_tags')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                </div>
            </div>

            <div class="col-lg-12">
                <div class="card-style mb-30">

                    <div class="mb-3 col-3">
                        <label class="form-label col-4 required">Active</label>
                        <div class="form-check form-check-inline radio-style mb-20">
                            <input type="radio" name="active" id="active_y" value="1" @if(!isset($post) || $post->active) checked @endif>
                            <label class="form-check-label" for="active_y">Yes</label>
                        </div>
                        <div class="form-check form-check-inline radio-style mb-20">
                            <input type="radio" name="active" id="active_n" value="0" @if(isset($post) && !$post->active) checked @endif>
                            <label class="form-check-label" for="active_n">No</label>
                        </div>
                    </div>

                    <div class="mb-3 col-3">
                        <label class="form-label col-4 required">Comments Enabled</label>
                        <div class="form-check form-check-inline radio-style mb-20">
                            <input type="radio" name="comments_enabled" id="comments_y" value="1" @if(!isset($post) || $post->comments_enabled) checked @endif>
                            <label class="form-check-label" for="comments_y">Yes</label>
                        </div>
                        <div class="form-check form-check-inline radio-style mb-20">
                            <input type="radio" name="comments_enabled" id="comments_n" value="0" @if(isset($post) && !$post->comments_enabled) checked @endif>
                            <label class="form-check-label" for="comments_n">No</label>
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-lg-12">
                <div class="card-style mb-30">
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </div>
            </div>
        </div>
    </form>

</div>
@endsection

@push('pageScripts')

<script>
    $(document).ready(function () {
        // Auto-generate slug from title
        $('#title').on('keyup', function () {
            var title = $(this).val();
            var slug = title.toLowerCase()
                .trim()
                .replace(/[^\w\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-');
            $('#slug').val(slug);
        });
    });
</script>

@endpush