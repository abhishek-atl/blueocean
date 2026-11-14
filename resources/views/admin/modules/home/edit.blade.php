@extends('admin.layouts.default')

@section('title', 'Home')

@section('content')
<div class="container-fluid">
    <div class="row py-4">
        <div class="col-12">
            <div class="card-style">
                <h2>Home</h2>
                <p>Upload images for the home page. Leave a field empty to keep its current image.</p>
            </div>
        </div>
    </div>

    @if(session('status'))
    <div class="alert alert-success" role="alert">{{ session('status') }}</div>
    @endif

    <form action="{{ route('admin.home.update') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row">
            @foreach($fields as $field => $definition)
            <div class="col-lg-6">
                <div class="card-style mb-30">
                    <label class="form-label" for="{{ $field }}">{{ $definition['label'] }}</label>
                    <div class="mb-3">
                        <img src="{{ $images[$field] }}" alt="Current {{ strtolower($definition['label']) }}" class="img-fluid" style="max-height: 220px; object-fit: contain;">
                    </div>
                    <input type="file" class="form-control" name="{{ $field }}" id="{{ $field }}" accept="image/jpeg,image/png,image/webp" aria-describedby="{{ $field }}_help">
                    <small id="{{ $field }}_help" class="text-muted">JPG, PNG or WebP. Maximum 5 MB.</small>
                    @error($field)
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            @endforeach
            <div class="col-12 mb-4">
                <button type="submit" class="btn btn-primary">Save images</button>
            </div>
        </div>
    </form>
</div>
@endsection
