@extends('admin.layouts.default')

@if(isset($tariffPlan))
@section('title', 'Edit Tariff Plan')
@else
@section('title', 'Create Tariff Plan')
@endif

@section('content')

<div class="container-fluid">
    <div class="row py-4">
        <div class="col-md-12">
            <div class="card-style d-flex flex-wrap align-items-center justify-content-between">
                <div class="title">
                    @if(isset($tariffPlan))
                    <h2>Edit Tariff Plan</h2>
                    @else
                    <h2>Create Tariff Plan</h2>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.tariff_plans.store') }}" method="post">

        @csrf

        @isset($tariffPlan)
        <input type="hidden" name="id" value="{{ $tariffPlan->id }}" />
        @endisset

        <div class="row">

            <div class="col-lg-12">
                <div class="card-style mb-30">

                    <div class="mb-3">
                        <label class="form-label required" for="name">Plan Name</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="e.g., Basic Plan" value="{{ old('name', $tariffPlan->name ?? '') }}" required />
                        @error('name')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label required" for="duration">Duration (Days)</label>
                                <input type="number" name="duration" id="duration" class="form-control" placeholder="30" value="{{ old('duration', $tariffPlan->duration ?? '') }}" required />
                                @error('duration')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label required" for="amount">Amount</label>
                                <input type="number" step="0.01" name="amount" id="amount" class="form-control" placeholder="0.00" value="{{ old('amount', $tariffPlan->amount ?? '') }}" required />
                                @error('amount')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label required" for="fee">Fee</label>
                                <input type="number" step="0.01" name="fee" id="fee" class="form-control" placeholder="0.00" value="{{ old('fee', $tariffPlan->fee ?? '') }}" required />
                                @error('fee')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-lg-12">
                <div class="card-style mb-30">

                    <div class="mb-3 col-3">
                        <label class="form-label required">Active</label>
                        <div class="form-check form-check-inline radio-style mb-20">
                            <input type="radio" name="active" id="active_y" value="1" @if(isset($tariffPlan) && $tariffPlan->active) checked @endif>
                            <label class="form-check-label" for="active_y">Yes</label>
                        </div>
                        <div class="form-check form-check-inline radio-style mb-20">
                            <input type="radio" name="active" id="active_n" value="0" @if(!isset($tariffPlan) || !$tariffPlan->active) checked @endif>
                            <label class="form-check-label" for="active_n">No</label>
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-lg-12">
                <div class="card-style mb-30">
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <a href="{{ route('admin.tariff_plans.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </div>
            </div>
        </div>
    </form>

</div>
@endsection
