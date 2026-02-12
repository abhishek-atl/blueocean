@extends('admin.layouts.default')

@section('content')

<div class="container-fluid">

    <div class="row py-4">
        <div class="col-md-12">
            <div class="d-flex flex-wrap align-items-center justify-content-between">
                <div class="title">
                    <h2>Roles</h2>
                </div>
                <div class="right-content">
                    <a href="{{ route('admin.roles.create')}}" class="btn btn-primary">Create Role</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">

        <div class="col-md-12">

            @if (session('status'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('status') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <div class="card-style mb-30">
                <table class="table striped-table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Permissions</th>
                            <th scope="col">Type</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($roles as $role)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $role->name }}</td>
                            <td>
                                @if($role->is_default)
                                <a href="javascript:void(0)" class="text-light">View Permissions</a>
                                @else
                                <a href="{{ route('admin.roles.permissions', ['roleId' => $role->id]) }}">Manage Permissions</a>
                                @endif
                            </td>
                            <td><span class="status-btn active-btn">{{ $role->is_default ? 'Default' : 'Custom' }}</span></td>
                            <td>
                                @if($role->is_default)
                                <div class="action">
                                    <button class="text-light" disabled>
                                        <i class="fa fa-pen"></i>
                                    </button>
                                    <button class="text-light" disabled>
                                        <i class="fa fa-trash"></i>
                                    </button>
                                    @else
                                    <div class="action">
                                        <a href="{{ route('admin.roles.edit', ['id' => $role->id]) }}" class="text-dark me-3">
                                            <i class="fa fa-pen"></i>
                                        </a>
                                        <a href="{{ route('admin.roles.destroy', ['id' => $role->id]) }}" class="text-danger" onclick="return confirm('Are you sure you want to delete this role?');">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </div>
                                    @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

</div>
@endsection