@extends('admin.layouts.default')

@section('title', $therapyKit ? 'Edit Therapy Kit' : 'Add Therapy Kit')

@section('content')
<div class="container-fluid">
    <div class="row py-4">
        <div class="col-md-12">
            <div class="card-style d-flex flex-wrap align-items-center justify-content-between">
                <div class="title">
                    <h2>{{ $therapyKit ? 'Edit Therapy Kit' : 'Add Therapy Kit' }}</h2>
                    <div class="breadcrumb-wrapper">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('admin.therapy_kits.index') }}">Therapy Kits</a></li>
                                <li class="breadcrumb-item active">{{ $therapyKit ? 'Edit' : 'Add' }} Therapy Kit</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.therapy_kits.store') }}" method="post">
        @csrf
        @if($therapyKit)
            <input type="hidden" name="id" value="{{ $therapyKit->id }}">
        @endif

        <div class="row">
            <div class="col-lg-12">
                <div class="card-style mb-30">
                    <div class="mb-3">
                        <label class="form-label required" for="name">Name</label>
                        <input type="text" name="name" id="name" class="form-control" maxlength="255" value="{{ old('name', $therapyKit?->name) }}" required>
                        @error('name')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label required" for="price">Price</label>
                        <input type="number" name="price" id="price" class="form-control" min="0" max="99999999.99" step="0.01" value="{{ old('price', $therapyKit?->price ?? '0.00') }}" required>
                        @error('price')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label required" for="type">Type</label>
                        <select name="type" id="type" class="form-select" required>
                            <option value="">Select type</option>
                            <option value="equipment" @selected(old('type', $therapyKit?->type) === 'equipment')>Equipment</option>
                            <option value="product" @selected(old('type', $therapyKit?->type) === 'product')>Product</option>
                        </select>
                        @error('type')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input type="checkbox" name="active" id="active" class="form-check-input" value="1" @checked(old('active', $therapyKit?->active ?? true))>
                            <label class="form-check-label" for="active">Active</label>
                        </div>
                        @error('active')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card-style">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <a href="{{ route('admin.therapy_kits.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
