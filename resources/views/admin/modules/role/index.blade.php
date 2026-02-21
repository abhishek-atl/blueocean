@extends('admin.layouts.default')

@section('title', 'Roles')

@section('content')

<div class="container-fluid">

    <div class="row py-4">
        <div class="col-md-12">
            <div class="card-style d-flex flex-wrap align-items-center justify-content-between">
                <div class="title">
                    <h2>Roles</h2>
                    <div class="breadcrumb-wrapper">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('admin.dashboard')}}">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active">Roles</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="right-content">
                    <form class="row row-cols-lg-auto g-3 align-items-center" method="get" action="{{ url()->current() }}">
                        <div class="col-12">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control" placeholder="Search..." value="{{ Request::get('search') }}">
                                @if(!Request::get('search'))
                                <button class="btn btn-secondary" type="submit"><i class="fa fa-search"></i></button>
                                @else
                                <a href="{{ url()->current() }}" class="btn btn-secondary" type="button">Clear</a>
                                @endif
                            </div>
                        </div>
                        <div class="col-12">
                            <a href="{{ route('admin.roles.create')}}" class="btn btn-primary">Add Role</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">

        <div class="col-md-12">

            <div class="card-style mb-30">
                <table class="table striped-table table-fixed">
                    <thead>
                        <tr>
                            <th scope="col" style="width: 5%;">
                                <a href="{{ route('admin.roles.index', array_merge(request()->query(), ['sort_by' => 'id', 'sort_order' => request('sort_order') === 'asc' ? 'desc' : 'asc'])) }}">
                                    ID @if($sort_by == 'id') @if($sort_order == 'asc') <i class="fa fa-chevron-down"></i> @else <i class="fa fa-chevron-up"></i> @endif @endif
                                </a>
                            </th>
                            <th scope="col" style="width: 20%;">
                                <a href="{{ route('admin.roles.index', array_merge(request()->query(), ['sort_by' => 'name', 'sort_order' => request('sort_order') === 'asc' ? 'desc' : 'asc'])) }}">
                                    Name @if($sort_by == 'name') @if($sort_order == 'asc') <i class="fa fa-chevron-down"></i> @else <i class="fa fa-chevron-up"></i> @endif @endif
                                </a>
                            </th>
                            <th scope="col" style="width: 20%;">Permissions</th>
                            <th scope="col" style="width: 20%;">Type</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($roles as $role)
                        <tr>
                            <th scope="row">
                                {{ $role->id }}
                            </th>
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

@endsection