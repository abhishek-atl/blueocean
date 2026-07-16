@extends('admin.layouts.default')

@section('content')

<div class="container-fluid">
    <div class="row py-4">
        <div class="col-md-12">
            <div class="card-style d-flex flex-wrap align-items-center justify-content-between">
                <div class="title">
                    @if(isset($treatment))
                    <h2>Edit Treatment</h2>
                    @else
                    <h2>Create Treatment</h2>
                    @endif

                    <div class="breadcrumb-wrapper">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('admin.dashboard')}}">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="{{ route('admin.treatments.index') }}">Treatments</a>
                                </li>
                                @if(isset($treatment))
                                <li class="breadcrumb-item active">Edit Treatment</li>
                                @else
                                <li class="breadcrumb-item active">Add Treatment</li>
                                @endif
                            </ol>
                        </nav>
                    </div>

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
                        <label class="form-label required me-3" for="description">Description</label>
                        <textarea name="description" class="form-control editor" id="description" placeholder="Enter Description">@if($treatment){{ $treatment->description ?? '' }}@endif</textarea>
                        @error('description')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label required" for="technique">Technique</label>
                        <input type="text" name="technique" id="technique" class="form-control" placeholder="Treatment Techniques" value="{{ old('technique', $treatment->technique ?? '') }}" />
                        @error('technique')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label required" for="ideal_for">Ideal For</label>
                        <input type="text" name="ideal_for" id="ideal_for" class="form-control" placeholder="Ideal for" value="{{ old('ideal_for', $treatment->ideal_for ?? '') }}" />
                        @error('ideal_for')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Image</label>
                        <input type="file" id="image" name="image" class="form-control" accept="image/*" />
                        @if($treatment)
                        <img id="showImage" style="height: 90px; max-width: 130px;" src="{{ $treatment->image }}" />
                        @else
                        <img id="showImage" src="#" style="height: 90px; max-width: 130px; display: none;" />
                        @endif
                        @error('image')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="image_alt">Image Alt Text</label>
                        <input type="text" name="image_alt" id="image_alt" class="form-control" placeholder="Image Alt Text" value="{{ old('image_alt', $entity->image_alt ?? '') }}" />
                        @error('image_alt')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="image_title">Image Title</label>
                        <input type="text" name="image_title" id="image_title" class="form-control" placeholder="Image Title" value="{{ old('image_title', $entity->image_title ?? '') }}" />
                        @error('image_title')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Active</label>
                        <div class="form-check">
                            <input type="checkbox" name="active" id="enabled" class="form-check-input" value="1" @if($treatment && $treatment->active) checked @endif>
                            <label for="enabled" class="form-check-label">Active</label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">On Treatment Page</label>
                        <div class="form-check">
                            <input type="checkbox" name="on_treatment_page" id="on_treatment_page" class="form-check-input" value="1" @if($treatment && $treatment->on_treatment_page) checked @endif>
                            <label for="on_treatment_page" class="form-check-label">Show on Treatment Page</label>
                        </div>
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
    $(document).ready(function() {

        $('#image').on('change', function(evt) {
            const [file] = $('#image')[0].files
            if (file) {
                $('#showImage').css('display', '');
                $('#showImage').attr('src', URL.createObjectURL(file))
            }
        })

        $('#treatment_category_id').select2({
            placeholder: 'Select Categories',
        });

        @if($treatment)
        let selectedTags = '{!! json_encode($treatmentCategoryIds) !!}'
        $('#treatment_category_id').val(JSON.parse(selectedTags)).trigger('change');
        @endif
    });
</script>

@include('admin.modules.common.tinymce')

@endpush