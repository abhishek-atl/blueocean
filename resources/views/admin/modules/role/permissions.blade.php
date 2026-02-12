@extends('admin.layouts.default')

@section('content')

<div class="container-fluid">
    <div class="row py-4">
        <div class="col-md-6">
            <div class="d-flex flex-wrap align-items-center justify-content-between">
                <div class="title">
                    <h2>Editing Role: {{ $role->name }}</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">

            <form method="post" action="{{ route('admin.roles.permissions.store') }}">
                @csrf
                <input type="hidden" name="role_id" value="{{ $role->id }}" />

                <div class="card-style mb-30">

                    @foreach($permissions as $title => $permission)
                        <h4 class="mb-3">{{ $title }}</h4>
                        @foreach($permission as $perm)
                        <div class="form-check form-check-inline mb-3">
                            <input class="form-check-input" type="checkbox" value="{{ $perm['name'] }}" name="permissions[]" id="perm_{{ $perm['id'] }}" @if(in_array($perm['name'], $rolePermissions)) checked @endif>
                            <label class="form-check-label" for="perm_{{ $perm['id'] }}">{{ $perm['name'] }}</label>
                        </div>
                        @endforeach
                    @endforeach
                </div>

                <div class="mb-3">
                    <button type="submit" class="btn btn-primary">Save Permissions</button>
                    <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>

        </div>
    </div>

</div>
@endsection