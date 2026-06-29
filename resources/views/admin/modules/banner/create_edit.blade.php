@extends('admin.layouts.default')

@if(isset($banner))
@section('title', 'Edit Banner')
@else
@section('title', 'Create Banner')
@endif

@section('content')

<div class="container-fluid">
    <div class="row py-4">
        <div class="col-md-12">
            <div class="card-style d-flex flex-wrap align-items-center justify-content-between">
                <div class="title">
                    @if(isset($banner))
                    <h2>Edit Banner</h2>
                    @else
                    <h2>Create Banner</h2>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.banners.store') }}" method="post">

        @csrf

        @isset($banner)
        <input type="hidden" name="id" value="{{ $banner->id }}" />
        @endisset

        <div class="row">

            <div class="col-lg-12">
                <div class="card-style mb-30">

                    <div class="mb-3">
                        <label class="form-label required" for="text">Text</label>
                        <input type="text" name="text" id="text" class="form-control" placeholder="Marquee text" value="{{ old('text', $banner->text ?? '') }}" required />
                        @error('text')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="url">URL</label>
                        <input type="url" name="url" id="url" class="form-control" placeholder="https://example.com" value="{{ old('url', $banner->url ?? '') }}" />
                        @error('url')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label required" for="placement">Placement</label>
                        <select name="placement" id="placement" class="form-control" required>
                            <option value="">Select placement</option>
                            <option value="home" @if(old('placement', $banner->placement ?? '') == 'home') selected @endif>Home Page</option>
                            <option value="booking" @if(old('placement', $banner->placement ?? '') == 'booking') selected @endif>Booking Page</option>
                        </select>
                        @error('placement')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 col-12">
                        <label class="form-label required">Status</label>
                        <div class="form-check form-check-inline radio-style mb-20">
                            <input type="radio" name="active" id="active_yes" value="1" @if(!isset($banner) || $banner->active) checked @endif>
                            <label class="form-check-label" for="active_yes">Active</label>
                        </div>
                        <div class="form-check form-check-inline radio-style mb-20">
                            <input type="radio" name="active" id="active_no" value="0" @if(isset($banner) && !$banner->active) checked @endif>
                            <label class="form-check-label" for="active_no">Inactive</label>
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-lg-12">
                <div class="card-style mb-30">
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <a href="{{ route('admin.banners.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </div>
            </div>
        </div>
    </form>

</div>
@endsection