@extends('admin.layouts.default')

@section('content')

<div class="container-fluid">
    <div class="row py-4">
        <div class="col-md-12">
            <div class="d-flex flex-wrap align-items-center justify-content-between">
                <div class="title">
                    @if(isset($postcode))
                    <h2>Edit Postcode</h2>
                    @else
                    <h2>Create Postcode</h2>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.therapists.edit', ['id' => $user->id]) }}">Therapist Information</a>
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

    <form action="{{ route('admin.therapists.schedulesStore') }}" method="post">
        @csrf
        @if($isEdit)
        <input type="hidden" name="id" value="{{ $user->id }}">
        @endif

        <div class="row">

            <div class="col-12">
                <div class="card-style mb-30">

                    <div class="row">
                        <div class="col-6">
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label" for="fee_therapist_60">Fee TMR 60 <span class="text-danger">*</span></label>
                                <div class="col-lg-6">
                                    <input type="text" class="form-control" id="fee_therapist_60" name="fee_therapist_60" placeholder="Enter Fee Amount..." value="@if($isEdit){{ $user->therapist_profile?->fee_therapist_60 ?? '' }}@endif">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label" for="fee_therapist_90">Fee TMR 90 <span class="text-danger">*</span></label>
                                <div class="col-lg-6">
                                    <input type="text" class="form-control" id="fee_therapist_90" name="fee_therapist_90" placeholder="Enter Fee Amount..." value="@if($isEdit){{ $user->therapist_profile?->fee_therapist_90 ?? '' }}@endif">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label" for="fee_therapist_120">Fee TMR 120 <span class="text-danger">*</span></label>
                                <div class="col-lg-6">
                                    <input type="text" class="form-control" id="fee_therapist_120" name="fee_therapist_120" placeholder="Enter Fee Amount..." value="@if($isEdit){{ $user->therapist_profile?->fee_therapist_120 ?? '' }}@endif">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label" for="fee_therapist_150">Fee TMR 150 <span class="text-danger">*</span></label>
                                <div class="col-lg-6">
                                    <input type="text" class="form-control" id="fee_therapist_150" name="fee_therapist_150" placeholder="Enter Fee Amount..." value="@if($isEdit){{ $user->therapist_profile?->fee_therapist_150 ?? '' }}@endif">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label" for="fee_therapist_180">Fee TMR 180 <span class="text-danger">*</span></label>
                                <div class="col-lg-6">
                                    <input type="text" class="form-control" id="fee_therapist_180" name="fee_therapist_180" placeholder="Enter Fee Amount..." value="@if($isEdit){{ $user->therapist_profile?->fee_therapist_180 ?? '' }}@endif">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label" for="fee_therapist_210">Fee TMR 210 <span class="text-danger">*</span></label>
                                <div class="col-lg-6">
                                    <input type="text" class="form-control" id="fee_therapist_210" name="fee_therapist_210" placeholder="Enter Fee Amount..." value="@if($isEdit){{ $user->therapist_profile?->fee_therapist_210 ?? '' }}@endif">
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <h4>Booking settings</h4>
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label" for="extend_cost">TMR Fee for Extensions <span class="text-danger">*</span></label>
                                <div class="col-lg-6">
                                    <input type="text" class="form-control" id="extend_cost" name="extend_cost" placeholder="Enter Fee Amount..." value="@if($isEdit){{ $user->therapist_profile?->extend_cost ?? '' }}@endif">
                                </div>
                            </div>
                        </div>
                    </div>



                    <div class="form-group row">
                        <div class="col-lg-8">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
    </form>
</div>

@endsection