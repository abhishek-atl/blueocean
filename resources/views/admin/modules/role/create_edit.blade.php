@extends('admin.layouts.default')

@if(isset($role))
@section('title', 'Edit Role')
@else
@section('title', 'Add Role')
@endif

@section('content')

<div class="container-fluid">
    <div class="row py-4">
        <div class="col-md-12">
            <div class="card-style d-flex flex-wrap align-items-center justify-content-between">
                <div class="title">
                    @if(isset($role))
                    <h2>Edit Role</h2>
                    @else
                    <h2>Add Role</h2>
                    @endif
                    <div class="breadcrumb-wrapper">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('admin.dashboard')}}">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="{{ route('admin.roles.index')}}">Roles</a>
                                </li>
                                @if(isset($role))
                                <li class="breadcrumb-item active">Edit Role</li>
                                @else
                                <li class="breadcrumb-item active">Add Role</li>
                                @endif
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-lg-6">

            <div class="card-style mb-30">

                <form action="{{ route('admin.roles.store') }}" method="post">
                    @csrf

                    @isset($role)
                    <input type="hidden" name="id" value="{{ $role->id }}" />
                    @endisset
                    <div class="mb-3">
                        <label class="form-label required" for="name">Role Name</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Role Name" value="{{ old('name', $role->name ?? '') }}" />
                        @error('name')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>

            </div>
        </div>
    </div>

</div>


@endsection