@extends('admin.layouts.default')

@if(isset($review))
@section('title', 'Edit Review')
@else
@section('title', 'Create Review')
@endif

@section('content')

<div class="container-fluid">
    <div class="row py-4">
        <div class="col-md-12">
            <div class="card-style d-flex flex-wrap align-items-center justify-content-between">
                <div class="title">
                    @if(isset($review))
                    <h2>Edit Review</h2>
                    @else
                    <h2>Create Review</h2>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.reviews.store') }}" method="post" enctype="multipart/form-data">

        @csrf

        @isset($review)
        <input type="hidden" name="id" value="{{ $review->id }}" />
        @endisset

        <div class="row">

            <div class="col-lg-12">
                <div class="card-style mb-30">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label required" for="first_name">First Name</label>
                                <input type="text" name="first_name" id="first_name" class="form-control" placeholder="First Name" value="{{ old('first_name', $review->first_name ?? '') }}" required />
                                @error('first_name')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="last_name">Last Name</label>
                                <input type="text" name="last_name" id="last_name" class="form-control" placeholder="Last Name" value="{{ old('last_name', $review->last_name ?? '') }}" />
                                @error('last_name')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="email">Email</label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="Email Address" value="{{ old('email', $review->email ?? '') }}" />
                                @error('email')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label required" for="location">Location</label>
                                <input type="text" name="location" id="location" class="form-control" placeholder="Location" value="{{ old('location', $review->location ?? '') }}" required />
                                @error('location')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="profession">Profession</label>
                                <input type="text" name="profession" id="profession" class="form-control" placeholder="Profession" value="{{ old('profession', $review->profession ?? '') }}" />
                                @error('profession')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="company">Company</label>
                                <input type="text" name="company" id="company" class="form-control" placeholder="Company" value="{{ old('company', $review->company ?? '') }}" />
                                @error('company')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label required" for="comment">Review Comment</label>
                        <textarea name="comment" id="comment" class="form-control" rows="8" placeholder="Review Comment" required>{{ old('comment', $review->comment ?? '') }}</textarea>
                        @error('comment')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="reply">Admin Reply</label>
                        <textarea name="reply" id="reply" class="form-control" rows="6" placeholder="Admin Reply">{{ old('reply', $review->reply ?? '') }}</textarea>
                        @error('reply')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                </div>
            </div>

            <div class="col-lg-12">
                <div class="card-style mb-30">

                    <div class="mb-3">
                        <label class="form-label" for="photo">Review Photo</label>
                        <input type="file" name="photo" id="photo" class="form-control" accept="image/*" />
                        @error('photo')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                        @if(isset($review) && $review->photo)
                        <div class="mt-2">
                            <img src="{{ asset($review->photo) }}" alt="Review Photo" style="max-width: 200px; max-height: 200px;">
                        </div>
                        @endif
                    </div>

                    <div class="mb-3" for="ip_address">
                        <label class="form-label">IP Address</label>
                        <input type="text" name="ip_address" id="ip_address" class="form-control" placeholder="IP Address" value="{{ old('ip_address', $review->ip_address ?? '') }}" readonly />
                    </div>

                </div>
            </div>

            <div class="col-lg-12">
                <div class="card-style mb-30">

                    <div class="mb-3 col-3">
                        <label class="form-label col-4 required">Status</label>
                        <div class="form-check form-check-inline radio-style mb-20">
                            <input type="radio" name="status" id="status_approved" value="1" @if(isset($review) && $review->status) checked @endif>
                            <label class="form-check-label" for="status_approved">Approved</label>
                        </div>
                        <div class="form-check form-check-inline radio-style mb-20">
                            <input type="radio" name="status" id="status_pending" value="0" @if(!isset($review) || !$review->status) checked @endif>
                            <label class="form-check-label" for="status_pending">Pending</label>
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-lg-12">
                <div class="card-style mb-30">
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <a href="{{ route('admin.reviews.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </div>
            </div>
        </div>
    </form>

</div>
@endsection
