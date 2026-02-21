@extends('admin.layouts.default')

@section('title', 'Therapist Fees')

@section('content')

<div class="container-fluid">
    <div class="row py-4">
        <div class="col-md-12">
            <div class="card-style d-flex flex-wrap align-items-center justify-content-between">
                <div class="title">
                    <h2>Therapists Fees</h2>

                    <div class="breadcrumb-wrapper">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('admin.dashboard')}}">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="{{ route('admin.therapists.index') }}">Therapists</a>
                                </li>
                                <li class="breadcrumb-item active">Therapist Fees</li>
                            </ol>
                        </nav>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <ul class="nav nav-tabs">
       <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.therapists.edit', ['id' => $user->id]) }}">User Profile</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.therapists.profile', ['id' => $user->id]) }}">Therapist Profile</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.therapists.treatments', ['id' => $user->id]) }}">Treatments</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.therapists.postcodes', ['id' => $user->id]) }}">Postcodes</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.therapists.schedules', ['id' => $user->id]) }}">Schedules</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="{{ route('admin.therapists.fees', ['id' => $user->id]) }}">Fees</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.therapists.holidays', ['id' => $user->id]) }}">Holidays</a>
        </li>
    </ul>

    <form action="{{ route('admin.therapists.feesStore') }}" method="post">
        @csrf
        @if($user)
        <input type="hidden" name="id" value="{{ $user->id }}">
        @endif

        <div class="row">

            <div class="col-12">
                <div class="card-style mb-30">

                    <div class="row">
                        <div class="col-6">

                            <div class="mb-3 col-6">
                                <label class="form-label required" for="fee_therapist_60">Fee for 60 min</label>
                                <input type="text" name="fee_therapist_60" id="fee_therapist_60" class="form-control" placeholder="Fee for 60 min" value="{{ old('fee_therapist_60', $user->therapist_profile?->fee_therapist_60 ?? '') }}" />
                                @error('fee_therapist_60')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 col-6">
                                <label class="form-label required" for="fee_therapist_90">Fee for 90 min</label>
                                <input type="text" name="fee_therapist_90" id="fee_therapist_90" class="form-control" placeholder="Fee for 90 min" value="{{ old('fee_therapist_90', $user->therapist_profile?->fee_therapist_90 ?? '') }}" />
                                @error('fee_therapist_90')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 col-6">
                                <label class="form-label required" for="fee_therapist_120">Fee for 120 min</label>
                                <input type="text" name="fee_therapist_120" id="fee_therapist_120" class="form-control" placeholder="Fee for 120 min" value="{{ old('fee_therapist_120', $user->therapist_profile?->fee_therapist_120 ?? '') }}" />
                                @error('fee_therapist_120')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 col-6">
                                <label class="form-label required" for="fee_therapist_150">Fee for 150 min</label>
                                <input type="text" name="fee_therapist_150" id="fee_therapist_150" class="form-control" placeholder="Fee for 150 min" value="{{ old('fee_therapist_150', $user->therapist_profile?->fee_therapist_150 ?? '') }}" />
                                @error('fee_therapist_150')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 col-6">
                                <label class="form-label required" for="fee_therapist_180">Fee for 180 min</label>
                                <input type="text" name="fee_therapist_180" id="fee_therapist_180" class="form-control" placeholder="Fee for 180 min" value="{{ old('fee_therapist_180', $user->therapist_profile?->fee_therapist_180 ?? '') }}" />
                                @error('fee_therapist_150')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 col-6">
                                <label class="form-label required" for="fee_therapist_210">Fee for 210 min</label>
                                <input type="text" name="fee_therapist_210" id="fee_therapist_210" class="form-control" placeholder="Fee for 210 min" value="{{ old('fee_therapist_210', $user->therapist_profile?->fee_therapist_210 ?? '') }}" />
                                @error('fee_therapist_210')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>
                        <div class="col-6">
                            <h4>Booking settings</h4>
                            <div class="mb-3 col-6">
                                <label class="form-label required" for="extend_cost">Fee for Extensions</label>
                                <input type="text" name="extend_cost" id="extend_cost" class="form-control" placeholder="Fee for Extensions" value="{{ old('extend_cost', $user->therapist_profile?->extend_cost ?? '') }}" />
                                @error('extend_cost')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="mb-30">
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Save</button>
                            <a href="{{ route('admin.therapists.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </form>
</div>

@endsection