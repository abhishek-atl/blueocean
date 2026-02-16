@extends('admin.layouts.default')

@section('content')

<div class="container-fluid">
    <div class="row py-4">
        <div class="col-md-6">
            <div class="d-flex flex-wrap align-items-center justify-content-between">
                <div class="title">
                    @if(isset($user))
                    <h2>Edit Therapist</h2>
                    @else
                    <h2>Create Therapist</h2>
                    @endif
                </div>
            </div>
        </div>
    </div>


    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link active" href="{{ route('admin.therapists.edit') }}">User Profile</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.therapists.profile', ['id' => $user?->id]) }}">Therapist Profile</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.therapists.treatments', ['id' => $user?->id]) }}">Treatments</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.therapists.postcodes', ['id' => $user?->id]) }}">Postcodes</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.therapists.schedules', ['id' => $user?->id]) }}">Schedules</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.therapists.fees', ['id' => $user?->id]) }}">Fees</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.therapists.fees', ['id' => $user?->id]) }}">Holidays</a>
        </li>
    </ul>


    <form action="{{ route('admin.therapists.store') }}" method="post" id="storeTherapistForm" enctype="multipart/form-data">

        @csrf

        @isset($user)
        <input type="hidden" name="id" value="{{ $user->id }}" />
        @endisset

        <div class="row">

            <div class="col-12">
                <div class="card-style mb-30">

                    <h4 class="mb-25">User Profile</h4>

                    <div class="mb-3 col-6">
                        <label class="form-label required" for="first_name">First Name</label>
                        <input type="text" name="first_name" id="first_name" class="form-control" placeholder="First Name" value="{{ old('first_name', $user->first_name ?? '') }}" />
                        @error('first_name')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 col-6">
                        <label class="form-label required" for="last_name">Last Name</label>
                        <input type="text" name="last_name" id="last_name" class="form-control" placeholder="Last Name" value="{{ old('last_name', $user->last_name ?? '') }}" />
                        @error('last_name')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror

                    </div>

                    <div class="mb-3 col-6">
                        <label class="form-label required" for="email">Email</label>
                        <input type="text" name="email" id="email" class="form-control" placeholder="Email" value="{{ old('email', $user->email ?? '') }}" />
                        @error('email')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 col-6">
                        <label class="form-label" for="password">Password</label>
                        <input type="text" name="password" id="password" class="form-control" placeholder="Password" value="" />
                        <small>Keep blank to keep unchanged.</small>
                    </div>

                    <div class="mb-3 col-6">
                        <label class="form-label required" for="mobile">Mobile</label>
                        <input type="text" name="mobile" id="mobile" class="form-control" placeholder="Mobile" value="{{ old('mobile', $user->user_profile->mobile ?? '') }}" />
                        @error('mobile')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 col-6">
                        <label class="form-label required" for="birthday">Birthday</label>
                        <input type="text" name="birthday" id="birthday" class="form-control" placeholder="Birthday" value="{{ old('birthday', $user->user_profile->birthday ?? '') }}" />
                        @error('birthday')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 col-6">
                        <label class="form-label required" for="flat_no">Flat Number</label>
                        <input type="text" name="flat_no" id="flat_no" class="form-control" placeholder="Flat Number" value="{{ old('flat_no', $user->user_profile->flat_no ?? '') }}" />
                        @error('flat_no')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 col-6">
                        <label class="form-label required" for="street_no">Street Number</label>
                        <input type="text" name="street_no" id="street_no" class="form-control" placeholder="Street Number" value="{{ old('street_no', $user->user_profile->street_no ?? '') }}" />
                        @error('street_no')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 col-6">
                        <label class="form-label required" for="street_name">Street Name</label>
                        <input type="text" name="street_name" id="street_name" class="form-control" placeholder="Street Name" value="{{ old('street_name', $user->user_profile->street_name ?? '') }}" />
                        @error('street_name')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 col-6">
                        <label class="form-label required" for="town">Town</label>
                        <input type="text" name="town" id="town" class="form-control" placeholder="Town" value="{{ old('town', $user->user_profile->town ?? '') }}" />
                        @error('town')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 col-6">
                        <label class="form-label required" for="postcode">Postcode</label>
                        <input type="text" name="postcode" id="postcode" class="form-control" placeholder="Postcode" value="{{ old('postcode', $user->user_profile->postcode ?? '') }}" />
                        @error('postcode')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 col-6">
                        <label class="form-label">Image</label>
                        <input type="file" id="image" name="image" class="form-control" accept="image/*" />
                        @if($isEdit)
                        <img id="showImage" style="height: 90px; max-width: 130px;" src="{{ $user->user_profile?->image }}" />
                        @else
                        <img id="showImage" src="#" style="height: 90px; max-width: 130px; display: none;" />
                        @endif
                        @error('image')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 col-6">
                        <label class="form-label col-4 required">Active</label>
                        <div class="form-check form-check-inline radio-style mb-20">
                            <input type="radio" name="active" id="active_y" value="1" @if($isEdit && $user->active) checked @endif>
                            <label class="form-check-label" for="active_y">Yes</label>
                        </div>
                        <div class="form-check form-check-inline radio-style mb-20">
                            <input type="radio" name="active" id="active_n" value="0" @if($isEdit && !$user->active) checked @endif>
                            <label class="form-check-label" for="active_n">No</label>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Save</button>
                            <a href="{{ route('admin.treatments.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
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
    });
</script>

@include('admin.modules.common.tinymce')

@endpush