@extends('admin.layouts.default')

@if(isset($faq))
@section('title', 'Edit FAQ')
@else
@section('title', 'Create FAQ')
@endif

@section('content')

<div class="container-fluid">
    <div class="row py-4">
        <div class="col-md-12">
            <div class="card-style d-flex flex-wrap align-items-center justify-content-between">
                <div class="title">
                    @if(isset($faq))
                    <h2>Edit FAQ</h2>
                    @else
                    <h2>Create FAQ</h2>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.faqs.store') }}" method="post">

        @csrf

        @isset($faq)
        <input type="hidden" name="id" value="{{ $faq->id }}" />
        @endisset

        <div class="row">

            <div class="col-lg-12">
                <div class="card-style mb-30">

                    <div class="mb-3">
                        <label class="form-label required" for="question">Question</label>
                        <input type="text" name="question" id="question" class="form-control" placeholder="FAQ Question" value="{{ old('question', $faq->question ?? '') }}" required />
                        @error('question')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label required" for="answer">Answer</label>
                        <textarea name="answer" id="answer" class="form-control" rows="8" placeholder="FAQ Answer" required>{{ old('answer', $faq->answer ?? '') }}</textarea>
                        @error('answer')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="display_order">Display Order</label>
                        <input type="number" name="display_order" id="display_order" class="form-control" placeholder="0" value="{{ old('display_order', $faq->display_order ?? 0) }}" />
                        @error('display_order')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 col-12">
                        <label class="form-label required">Active</label>
                        <div class="form-check form-check-inline radio-style mb-20">
                            <input type="radio" name="active" id="active_yes" value="1" @if(!isset($faq) || $faq->active) checked @endif>
                            <label class="form-check-label" for="active_yes">Active</label>
                        </div>
                        <div class="form-check form-check-inline radio-style mb-20">
                            <input type="radio" name="active" id="active_no" value="0" @if(isset($faq) && !$faq->active) checked @endif>
                            <label class="form-check-label" for="active_no">Inactive</label>
                        </div>

                    </div>
                </div>

            </div>
        </div>

        <div class="col-lg-12">
            <div class="card-style mb-30">
                <div class="mb-3">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <a href="{{ route('admin.faqs.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </div>
        </div>
</div>
</form>

</div>
@endsection