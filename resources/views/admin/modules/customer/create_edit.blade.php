@extends('admin.layouts.default')

@if($user)
@section('title', 'Edit Customer')
@else
@section('title', 'Add Customer')
@endif

@section('content')

<div class="container-fluid">
    <div class="row py-4">
        <div class="col-md-12">
            <div class="card-style d-flex flex-wrap align-items-center justify-content-between">
                <div class="title">
                    @if(isset($user))
                    <h2>Edit Customer</h2>
                    @else
                    <h2>Add Customer</h2>
                    @endif
                    <div class="breadcrumb-wrapper">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('admin.dashboard')}}">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="{{ route('admin.customers.index') }}">Customers</a>
                                </li>
                                @if(isset($user))
                                <li class="breadcrumb-item active">Edit Customer</li>
                                @else
                                <li class="breadcrumb-item active">Add Customer</li>
                                @endif
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <form action="{{ route('admin.customers.store') }}" method="post" id="storeCustomerForm" enctype="multipart/form-data">

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
                        <input type="password" name="password" id="password" class="form-control" placeholder="Password" value="" />
                        @if($user)
                        <small>Keep blank to keep unchanged.</small>
                        @else
                        @error('password')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                        @endif
                    </div>

                    <div class="mb-3 col-6">
                        <label class="form-label required" for="mobile">Mobile</label>
                        <input type="text" name="mobile" id="mobile" class="form-control" placeholder="Mobile" value="{{ old('mobile', $user->user_profile->mobile ?? '') }}" />
                        @error('mobile')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 col-6" id="calendar_pick" data-td-target-input="nearest" data-td-target-toggle="nearest">
                        <label class="form-label required" for="birthday">Birthday</label>
                        <div class="input-group">
                            <input type="text" name="birthday" id="birthday" class="form-control" placeholder="Birthday" value="{{ old('birthday') }}" data-td-target="#birthday_pick" />
                            <span class="input-group-text" data-td-target="#calendar_pick" data-td-toggle="datetimepicker"><i class="fas fa-calendar"></i></span>
                        </div>
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
                        @if($user)
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
                            <input type="radio" name="active" id="active_y" value="1" @if($user && $user->active) checked @elseif(!$user) checked @endif>
                            <label class="form-check-label" for="active_y">Yes</label>
                        </div>
                        <div class="form-check form-check-inline radio-style mb-20">
                            <input type="radio" name="active" id="active_n" value="0" @if($user && !$user->active) checked @endif>
                            <label class="form-check-label" for="active_n">No</label>
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-lg-12">
                <div class="mb-3">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <a href="{{ route('admin.customers.index') }}" class="btn btn-secondary">Cancel</a>
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
        @if ($user)
            $('#birthday').val(moment('{{ $user->user_profile->birthday}}').format(moment_date_format));
        @endif
    });
</script>

@include('admin.modules.common.tinymce')
@endpush