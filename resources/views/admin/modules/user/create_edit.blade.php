@extends('admin.layouts.default')

@if($user)
@section('title', 'Edit Admin')
@else
@section('title', 'Add Admin')
@endif

@section('content')

<div class="container-fluid">
    <div class="row py-4">
        <div class="col-md-12">
            <div class="card-style d-flex flex-wrap align-items-center justify-content-between">
                <div class="title">
                    @if(isset($user))
                    <h2>Edit Admin</h2>
                    @else
                    <h2>Add Admin</h2>
                    @endif
                    <div class="breadcrumb-wrapper">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('admin.dashboard')}}">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="{{ route('admin.users.index') }}">Admins</a>
                                </li>
                                @if(isset($user))
                                <li class="breadcrumb-item active">Edit Admin</li>
                                @else
                                <li class="breadcrumb-item active">Add Admin</li>
                                @endif
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <form action="{{ route('admin.users.store') }}" method="post" id="storeCustomerForm" enctype="multipart/form-data">

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
                        <label class="form-label" for="roles">Roles</label>
                        <select name="role" id="role" class="form-control">
                            @foreach($roles as $role)
                            <option value="{{ $role->name }}" @if($user && $user->roles->pluck('name')->contains($role->name)) selected @endif>{{ $role->name }}</option>
                            @endforeach
                        </select>
                        @error('role')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 col-6">
                        <label class="form-label required">Active</label>
                        <div class="form-check form-check-inline radio-style">
                            <input type="radio" name="active" id="active_y" value="1" @if($user && $user->active) checked @elseif(!$user) checked @endif>
                            <label class="form-check-label" for="active_y">Yes</label>
                        </div>
                        <div class="form-check form-check-inline radio-style">
                            <input type="radio" name="active" id="active_n" value="0" @if($user && !$user->active) checked @endif>
                            <label class="form-check-label" for="active_n">No</label>
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-lg-12">
                <div class="mb-3">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </div>

        </div>
    </form>

</div>
@endsection

@push('pageScripts')

@include('admin.modules.common.tinymce')
@endpush