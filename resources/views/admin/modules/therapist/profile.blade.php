@extends('admin.layouts.default')

@section('title', 'Therapist Profile')

@section('content')

<div class="container-fluid">
    <div class="row py-4">
        <div class="col-md-12">
            <div class="card-style d-flex flex-wrap align-items-center justify-content-between">
                <div class="title">
                    <h2>Therapist Profile</h2>
                    <div class="breadcrumb-wrapper">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('admin.dashboard')}}">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="{{ route('admin.therapists.index') }}">Therapists</a>
                                </li>
                                <li class="breadcrumb-item active">Therapist Profile</li>
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
            <a class="nav-link active" href="{{ route('admin.therapists.profile', ['id' => $user->id]) }}">Therapist Profile</a>
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
            <a class="nav-link" href="{{ route('admin.therapists.fees', ['id' => $user->id]) }}">Fees</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.therapists.holidays', ['id' => $user->id]) }}">Holidays</a>
        </li>
    </ul>


    <form action="{{ route('admin.therapists.profileStore') }}" method="post" id="storeTherapistForm" enctype="multipart/form-data">

        @csrf

        @isset($user)
        <input type="hidden" name="id" value="{{ $user->id }}" />
        @endisset

        <div class="row">

            <div class="col-12">
                <div class="card-style mb-30">

                    <h4 class="mb-25">Therapist Profile</h4>

                    <div class="mb-3 col-6" id="calendar_pick" data-td-target-input="nearest" data-td-target-toggle="nearest">
                        <label class="form-label required" for="health_renewal_date">Insurance Renewal</label>
                        <div class="input-group">
                            <input type="text" name="health_renewal_date" id="health_renewal_date" class="form-control" placeholder="Health Renewal Date" value="{{ old('birthday', $user->user_profile->health_renewal_date ?? '') }}" data-td-target="#birthday_pick" />
                            <span class="input-group-text" data-td-target="#calendar_pick" data-td-toggle="datetimepicker"><i class="fas fa-calendar"></i></span>
                        </div>
                        @error('birthday')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label col-4 required">Health Professional</label>
                        <div class="form-check form-check-inline radio-style mb-20">
                            <input type="radio" name="health_professional" id="health_professional_y" value="1" @if($user && $user->therapist_profile?->health_professional) checked @endif>
                            <label class="form-check-label" for="health_professional_y">Yes</label>
                        </div>
                        <div class="form-check form-check-inline radio-style mb-20">
                            <input type="radio" name="health_professional" id="health_professional_n" value="0" @if($user && !$user->therapist_profile?->health_professional) checked @endif>
                            <label class="form-check-label" for="health_professional_n">No</label>
                        </div>
                    </div>


                    <h6 class="mb-25">More Options</h6>

                    <div class="mb-3">
                        <label class="form-label col-4 required">Soothing</label>
                        <div class="form-check form-check-inline radio-style mb-20">
                            <input type="radio" name="soothing" id="soothing_y" value="1" @if($user && $user->therapist_profile?->soothing) checked @endif>
                            <label class="form-check-label" for="soothing_y">Yes</label>
                        </div>
                        <div class="form-check form-check-inline radio-style mb-20">
                            <input type="radio" name="soothing" id="soothing_n" value="0" @if($user && !$user->therapist_profile?->soothing) checked @endif>
                            <label class="form-check-label" for="soothing_n">No</label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label col-4 required">Strong</label>
                        <div class="form-check form-check-inline radio-style mb-20">
                            <input type="radio" name="strong" id="strong_y" value="1" @if($user && $user->therapist_profile?->strong) checked @endif>
                            <label class="form-check-label" for="strong_y">Yes</label>
                        </div>
                        <div class="form-check form-check-inline radio-style mb-20">
                            <input type="radio" name="strong" id="strong_n" value="0" @if($user && !$user->therapist_profile?->strong) checked @endif>
                            <label class="form-check-label" for="strong_n">No</label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label col-4 required">Z Chair</label>
                        <div class="form-check form-check-inline radio-style mb-20">
                            <input type="radio" name="z_chair" id="z_chair_y" value="1" @if($user && $user->therapist_profile?->z_chair) checked @endif>
                            <label class="form-check-label" for="z_chair_y">Yes</label>
                        </div>
                        <div class="form-check form-check-inline radio-style mb-20">
                            <input type="radio" name="z_chair" id="z_chair_n" value="0" @if($user && !$user->therapist_profile?->z_chair) checked @endif>
                            <label class="form-check-label" for="z_chair_n">No</label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label col-4 required">Massage Table</label>
                        <div class="form-check form-check-inline radio-style mb-20">
                            <input type="radio" name="massage_table" id="massage_table_y" value="1" @if($user && $user->therapist_profile?->massage_table) checked @endif>
                            <label class="form-check-label" for="massage_table_y">Yes</label>
                        </div>
                        <div class="form-check form-check-inline radio-style mb-20">
                            <input type="radio" name="massage_table" id="massage_table_n" value="0" @if($user && !$user->therapist_profile?->massage_table) checked @endif>
                            <label class="form-check-label" for="massage_table_n">No</label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="notes">Notes</label>
                        <textarea name="notes" class="form-control" id="notes" placeholder="Enter CTA Text">@if($user){{ $user->therapist_profile?->notes ?? '' }}@endif</textarea>
                        @error('notes')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label required" for="about">About</label>
                        <textarea name="about" class="form-control editor" id="about" placeholder="Enter CTA Text">@if($user){{ $user->therapist_profile->about ?? '' }}@endif</textarea>
                        @error('about')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label col-4 required">On Therapist Page</label>
                        <div class="form-check form-check-inline radio-style mb-20">
                            <input type="radio" name="on_therapist_page" id="on_therapist_page_y" value="1" @if($user && $user->therapist_profile?->on_therapist_page) checked @endif>
                            <label class="form-check-label" for="on_therapist_page_y">Yes</label>
                        </div>
                        <div class="form-check form-check-inline radio-style mb-20">
                            <input type="radio" name="on_therapist_page" id="on_therapist_page_n" value="0" @if($user && !$user->therapist_profile?->on_therapist_page) checked @endif>
                            <label class="form-check-label" for="on_therapist_page_n">No</label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label col-4 required">Bonus Eligible</label>
                        <div class="form-check form-check-inline radio-style mb-20">
                            <input type="radio" name="bonus_eligible" id="bonus_eligible_y" value="1" @if($user && $user->therapist_profile?->bonus_eligible) checked @endif>
                            <label class="form-check-label" for="bonus_eligible_y">Yes</label>
                        </div>
                        <div class="form-check form-check-inline radio-style mb-20">
                            <input type="radio" name="bonus_eligible" id="bonus_eligible_n" value="0" @if($user && !$user->therapist_profile?->bonus_eligible) checked @endif>
                            <label class="form-check-label" for="bonus_eligible_n">No</label>
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-lg-12">
                <div class="card-style mb-30">
                    @include('admin.modules.common.seo_form_fields', ['entity' => $user->therapist_profile])
                </div>
            </div>

            <div class="col-lg-12">
                <div class="mb-3">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <a href="{{ route('admin.therapists.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </div>

        </div>
    </form>

</div>
@endsection

@push('pageScripts')

<script>
    $(document).ready(function () {
        new tempusDominus.TempusDominus(document.getElementById('calendar_pick'), {
            allowInputToggle: true,
            defaultDate: undefined,
            useCurrent: false,
            localization: {
                format: date_format,
            },
            display: {
                components: {
                    calendar: true,
                    date: true,
                    month: true,
                    year: true,
                    decades: false,
                    clock: false,
                    hours: false,
                    minutes: false,
                    seconds: false,
                    useTwentyfourHour: undefined
                },
            }
        });
        @if ($user && $user->therapist_profile)
        $('#health_renewal_date').val(moment('{{ $user->therapist_profile->health_renewal_date}}').format(moment_date_format));
        @endif
    });
</script>

@include('admin.modules.common.tinymce')

@endpush