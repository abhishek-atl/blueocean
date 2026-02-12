@extends('admin.layouts.default')

@section('content')

<div class="container-fluid">
    <div class="row py-4">
        <div class="col-md-6">
            <div class="d-flex flex-wrap align-items-center justify-content-between">
                <div class="title">
                    @if(isset($treatment))
                    <h2>Edit Treatment</h2>
                    @else
                    <h2>Create Treatment</h2>
                    @endif
                </div>
            </div>
        </div>
    </div>


    <form action="{{ route('admin.treatments.store') }}" method="post" id="storeTreatmentForm" enctype="multipart/form-data">

        @csrf

        @isset($treatment)
        <input type="hidden" name="id" value="{{ $treatment->id }}" />
        @endisset

        <div class="row">

            <div class="col-lg-12">
                <div class="card-style mb-30">
                    <div class="mb-3">
                        <label class="form-label required" for="name">Treatment Name</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Treatment Name" value="{{ old('name', $treatment->name ?? '') }}" />
                        @error('name')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label required" for="title">Title</label>
                        <input type="text" name="title" id="title" class="form-control" placeholder="Treatment Title" value="{{ old('title', $treatment->title ?? '') }}" />
                        @error('title')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label required" for="treatment_category_id">Category</label>
                        <select name="treatment_category_id[]" id="treatment_category_id" class="form-control" multiple="multiple">
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('treatment_category_id', $treatment->treatment_category_id ?? '') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('treatment_category_id')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label required" for="summary">Summary</label>
                        <textarea name="summary" id="summary" class="form-control editor" placeholder="Treatment Summary">{{ old('summary', $treatment->summary ?? '') }}</textarea>
                        @error('summary')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label required me-3" for="cta_text_visible">Show CTA Text</label>
                        <label class="radio-inline me-3">
                            <input type="radio" name="cta_text_visible" id="cta_text_visible_yes" value="1" @if($isEdit && $treatment->cta_text_visible) checked @endif>Yes</label>
                        <label class="radio-inline me-3">
                            <input type="radio" name="cta_text_visible" id="cta_text_visible_no" value="0" @if($isEdit && !$treatment->cta_text_visible) checked @endif> No</label>
                        @error('cta_text_visible')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label required" for="cta_text">CTA Text</label>
                        <textarea name="cta_text" class="form-control editor" id="cta_text" placeholder="Enter CTA Text">@if($isEdit){{ $treatment->cta_text ?? '' }}@endif</textarea>
                        @error('cta_text')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label required me-3" for="description">Description</label>
                        <textarea name="description" class="form-control editor" id="description" placeholder="Enter Description">@if($isEdit){{ $treatment->description ?? '' }}@endif</textarea>
                        @error('description')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Image</label>
                        <input type="file" id="image" name="image" class="form-control" accept="image/*" />
                        @if($isEdit)
                        <img id="showImage" style="height: 90px; max-width: 130px;" src="{{ $treatment->image }}" />
                        @else
                        <img id="showImage" src="#" style="height: 90px; max-width: 130px; display: none;" />
                        @endif
                        @error('image')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Active</label>
                        <div class="form-check">
                            <input type="checkbox" name="active" id="enabled" class="form-check-input" value="1" @if($isEdit && $treatment->active) checked @endif>
                            <label for="enabled" class="form-check-label">Active</label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">On Treatment Page</label>
                        <div class="form-check">
                            <input type="checkbox" name="on_treatment_page" id="on_treatment_page" class="form-check-input" value="1" @if($isEdit && $treatment->on_treatment_page) checked @endif>
                            <label for="on_treatment_page" class="form-check-label">Show on Treatment Page</label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Show CTA Button</label>
                        <div class="form-check">
                            <input type="checkbox" name="show_cta_button" id="show_cta_button" class="form-check-input" value="1" @if($isEdit && $treatment->show_cta_button) checked @endif>
                            <label for="show_cta_button" class="form-check-label">Show CTA Button</label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">CTA Button Text</label>
                        <input type="text" name="cta_button_text" id="cta_button_text" class="form-control" placeholder="CTA Button Text" value="{{ old('cta_button_text', $treatment->cta_button_text ?? '') }}" />
                        @error('cta_button_text')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">CTA Button URL</label>
                        <input type="text" name="cta_button_url" id="cta_button_url" class="form-control" placeholder="CTA Button URL" value="{{ old('cta_button_url', $treatment->cta_button_url ?? '') }}" />
                        @error('cta_button_url')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>


                </div>
            </div>

            <div class="col-lg-12">
                <div class="card-style mb-30">
                    @include('admin.modules.common.seo_form_fields', ['entity' => $treatment])
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <a href="{{ route('admin.treatments.index') }}" class="btn btn-secondary">Cancel</a>
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

        @if (Session:: has('status'))
            toastr.success("{{ Session::get('status') }}")
        @endif

        $('#image').on('change', function (evt) {
            const [file] = $('#image')[0].files
            if (file) {
                $('#showImage').css('display', '');
                $('#showImage').attr('src', URL.createObjectURL(file))
            }
        })

        $('#treatment_category_id').select2({
            placeholder: 'Select Categories',
        });

        @if ($isEdit)
            let selectedTags = '{!! json_encode($treatmentCategoryIds) !!}'
            $('#treatment_category_id').val(JSON.parse(selectedTags)).trigger('change');
        @endif
    });
</script>

@include('admin.modules.common.tinymce')

@endpush