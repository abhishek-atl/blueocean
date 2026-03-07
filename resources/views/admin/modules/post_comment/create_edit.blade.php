@extends('admin.layouts.default')

@if(isset($comment))
@section('title', 'Edit Comment')
@else
@section('title', 'Create Comment')
@endif

@section('content')

<div class="container-fluid">
    <div class="row py-4">
        <div class="col-md-12">
            <div class="card-style d-flex flex-wrap align-items-center justify-content-between">
                <div class="title">
                    @if(isset($comment))
                    <h2>Edit Comment</h2>
                    @else
                    <h2>Create Comment</h2>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.post_comments.store') }}" method="post">

        @csrf

        @isset($comment)
        <input type="hidden" name="id" value="{{ $comment->id }}" />
        @endisset

        <div class="row">

            <div class="col-lg-12">
                <div class="card-style mb-30">

                    <div class="mb-3">
                        <label class="form-label required" for="post_id">Post</label>
                        <select name="post_id" id="post_id" class="form-control" required>
                            <option value="">-- Select Post --</option>
                            @foreach($posts as $post)
                            <option value="{{ $post->id }}" @if($comment && $comment->post_id == $post->id) selected="selected" @endif>{{ $post->title }}</option>
                            @endforeach
                        </select>
                        @error('post_id')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label required" for="author">Author Name</label>
                        <input type="text" name="author" id="author" class="form-control" placeholder="Author Name" value="{{ old('author', $comment->author ?? '') }}" required />
                        @error('author')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label required" for="email">Email</label>
                        <input type="email" name="email" id="email" class="form-control" placeholder="Email Address" value="{{ old('email', $comment->email ?? '') }}" required />
                        @error('email')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label required" for="content">Comment Content</label>
                        <textarea name="content" id="content" class="form-control" rows="8" placeholder="Comment Content" required>{{ old('content', $comment->content ?? '') }}</textarea>
                        @error('content')
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
                            <input type="radio" name="active" id="active_y" value="1" @if(isset($comment) && $comment->active) checked @endif>
                            <label class="form-check-label" for="active_y">Yes</label>
                        </div>
                        <div class="form-check form-check-inline radio-style mb-20">
                            <input type="radio" name="active" id="active_n" value="0" @if(!isset($comment) || !$comment->active) checked @endif>
                            <label class="form-check-label" for="active_n">No</label>
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-lg-12">
                <div class="card-style mb-30">
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <a href="{{ route('admin.post_comments.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </div>
            </div>
        </div>
    </form>

</div>
@endsection
