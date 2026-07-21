@extends('admin.layouts.default')

@section('title', 'Edit Setting')

@section('content')
<div class="container-fluid">
    <div class="row py-4">
        <div class="col-md-12">
            <div class="card-style">
                <div class="title">
                    <h2>Edit Setting</h2>
                    <div class="breadcrumb-wrapper">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="{{ route('admin.settings.index') }}">Settings</a>
                                </li>
                                <li class="breadcrumb-item active">Edit</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.settings.update', $setting) }}" method="post">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-lg-12">
                <div class="card-style mb-30">
                    <div class="mb-3">
                        <label class="form-label" for="param_key">Key</label>
                        <input type="text" id="param_key" class="form-control" value="{{ $setting->param_key }}" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label required" for="param_value">Value</label>
                        <input type="text" name="param_value" id="param_value" class="form-control" value="{{ old('param_value', $setting->param_value) }}" maxlength="55" required autofocus>
                        @error('param_value')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="card-style mb-30">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <a href="{{ route('admin.settings.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
