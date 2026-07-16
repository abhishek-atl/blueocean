@extends('admin.layouts.default')

@section('content')

<div class="container-fluid">
    <div class="row py-4">
        <div class="col-md-12">
            <div class="card-style d-flex flex-wrap align-items-center justify-content-between">
                <div class="title">
                    @if(isset($treatmentCategory))
                    <h2>Edit Treatment Category</h2>
                    @else
                    <h2>Create Treatment Category</h2>
                    @endif

                    <div class="breadcrumb-wrapper">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('admin.dashboard')}}">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="{{ route('admin.treatment_categories.index') }}">Treatment Categories</a>
                                </li>
                                @if(isset($treatmentCategory))
                                <li class="breadcrumb-item active">Edit Treatment Category</li>
                                @else
                                <li class="breadcrumb-item active">Add Treatment Category</li>
                                @endif
                            </ol>
                        </nav>
                    </div>

                </div>
            </div>
        </div>
    </div>


    <form action="{{ route('admin.treatment_categories.store') }}" method="post" id="storeTreatmentCategoryForm" enctype="multipart/form-data">

        @csrf

        @isset($treatmentCategory)
        <input type="hidden" name="id" value="{{ $treatmentCategory->id }}" />
        @endisset

        <div class="row">

            <div class="col-lg-12">
                <div class="card-style mb-30">

                    <div class="mb-3">
                        <label class="form-label required" for="name">Treatment Category Name</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Treatment Category Name" value="{{ old('name', $treatmentCategory->name ?? '') }}" />
                        @error('name')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label required" for="description">Description</label>
                        <textarea name="description" id="description" class="form-control" placeholder="Description">{{ old('description', $treatmentCategory->description ?? '') }}</textarea>
                        @error('description')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
    
                    <div class="mb-3">
                        <label class="form-label">Image</label>
                        <input type="file" id="image" name="image" class="form-control" accept="image/*" />
                        @if($treatmentCategory && $treatmentCategory->image)
                        <img id="showImage" style="height: 90px; max-width: 130px;" src="{{ $treatmentCategory->image }}" />
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
                            <input type="checkbox" name="active" id="enabled" class="form-check-input" value="1" @if($treatmentCategory && $treatmentCategory->active) checked @endif>
                            <label for="enabled" class="form-check-label">Active</label>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-lg-12">
                <div class="card-style">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <a href="{{ route('admin.treatment_categories.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </div>

        </div>
    </form>

</div>
@endsection