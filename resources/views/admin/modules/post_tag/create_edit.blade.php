@extends('admin.layouts.default')

@if(isset($tag))
@section('title', 'Edit Tag')
@else
@section('title', 'Create Tag')
@endif

@section('content')

<div class="container-fluid">
    <div class="row py-4">
        <div class="col-md-12">
            <div class="card-style d-flex flex-wrap align-items-center justify-content-between">
                <div class="title">
                    @if(isset($tag))
                    <h2>Edit Tag</h2>
                    @else
                    <h2>Create Tag</h2>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.post_tags.store') }}" method="post">

        @csrf

        @isset($tag)
        <input type="hidden" name="id" value="{{ $tag->id }}" />
        @endisset

        <div class="row">

            <div class="col-lg-12">
                <div class="card-style mb-30">

                    <div class="mb-3">
                        <label class="form-label required" for="name">Tag Name</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Tag Name" value="{{ old('name', $tag->name ?? '') }}" required />
                        @error('name')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label required" for="slug">Slug</label>
                        <input type="text" name="slug" id="slug" class="form-control" placeholder="tag-slug" value="{{ old('slug', $tag->slug ?? '') }}" />
                        <small class="form-text text-muted">Leave empty to auto-generate from tag name</small>
                        @error('slug')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                </div>
            </div>

            <div class="col-lg-12">
                <div class="card-style mb-30">
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <a href="{{ route('admin.post_tags.index') }}" class="btn btn-secondary">Cancel</a>
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
        // Auto-generate slug from name
        $('#name').on('keyup', function() {
            var name = $(this).val();
            var slug = name.toLowerCase()
                           .trim()
                           .replace(/[^\w\s-]/g, '')
                           .replace(/\s+/g, '-')
                           .replace(/-+/g, '-');
            $('#slug').val(slug);
        });
    });
</script>

@endpush
