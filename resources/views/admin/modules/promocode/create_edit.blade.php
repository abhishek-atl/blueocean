@extends('admin.layouts.default')

@section('title', $promocode ? 'Edit Promocode' : 'Create Promocode')

@section('content')
@php
$selectedTariffPlans = old('tariff_plan_ids', $promocode?->tariffPlans->pluck('id')->all() ?? []);
$active = (int) old('active', $promocode ? (int) $promocode->active : 1);
@endphp

<div class="container-fluid">
    <div class="row py-4">
        <div class="col-md-12">
            <div class="card-style d-flex flex-wrap align-items-center justify-content-between">
                <div class="title">
                    <h2>{{ $promocode ? 'Edit Promocode' : 'Create Promocode' }}</h2>
                    <div class="breadcrumb-wrapper">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="{{ route('admin.promocodes.index') }}">Promocodes</a>
                                </li>
                                <li class="breadcrumb-item active">{{ $promocode ? 'Edit' : 'Create' }}</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.promocodes.store') }}" method="post">
        @csrf

        @if($promocode)
        <input type="hidden" name="id" value="{{ $promocode->id }}">
        @endif

        <div class="row">
            <div class="col-lg-12">
                <div class="card-style mb-30">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label required" for="code">Code</label>
                                <input type="text" name="code" id="code" class="form-control text-uppercase" value="{{ old('code', $promocode?->code) }}" maxlength="255" required autofocus>
                                @error('code')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label required" for="amount">Discount Amount</label>
                                <input type="number" name="amount" id="amount" class="form-control" value="{{ old('amount', $promocode?->amount) }}" min="0" step="0.01" required>
                                @error('amount')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <div id="calendar_pick" data-td-target-input="nearest" data-td-target-toggle="nearest">
                                    <label class="form-label required" for="expires_at">Expires At</label>
                                    <input type="text" name="expires_at" id="expires_at" class="form-control" value="{{ old('expires_at', $promocode?->expires_at?->format('d/m/Y H:i')) }}" required>
                                    @error('expires_at')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label required">Tariff Plans</label>
                                <div>
                                    @foreach($tariffPlans as $tariffPlan)
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="tariff_plan_ids[]" value="{{ $tariffPlan->id }}" id="tariff_plan_{{ $tariffPlan->id }}" @checked(in_array($tariffPlan->id, $selectedTariffPlans))>
                                        <label class="form-check-label" for="tariff_plan_{{ $tariffPlan->id }}">
                                            {{ $tariffPlan->name }} ({{ $tariffPlan->duration }} minutes)
                                        </label>
                                    </div>
                                    @endforeach
                                </div>
                                @error('tariff_plan_ids')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                                @error('tariff_plan_ids.*')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label required">Active</label>
                        <div class="form-check form-check-inline radio-style">
                            <input type="radio" name="active" id="active_y" value="1" @checked($active===1)>
                            <label class="form-check-label" for="active_y">Yes</label>
                        </div>
                        <div class="form-check form-check-inline radio-style">
                            <input type="radio" name="active" id="active_n" value="0" @checked($active===0)>
                            <label class="form-check-label" for="active_n">No</label>
                        </div>
                        @error('active')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="card-style mb-30">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <a href="{{ route('admin.promocodes.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('pageScripts')
<script>
    new tempusDominus.TempusDominus(document.getElementById('calendar_pick'), {
        allowInputToggle: true,
        defaultDate: undefined,
        useCurrent: false,
        localization: {
            format: date_time_format,
        },
        display: {
            components: {
                calendar: true,
                date: true,
                month: true,
                year: true,
                decades: false,
                clock: true,
                hours: true,
                minutes: true,
                seconds: true,
                useTwentyfourHour: undefined
            },
        }
    });
</script>
@endpush
