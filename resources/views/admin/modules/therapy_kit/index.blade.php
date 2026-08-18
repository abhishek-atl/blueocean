@extends('admin.layouts.default')

@section('title', 'Therapy Kits')

@section('content')
<div class="container-fluid">
    <div class="row py-4">
        <div class="col-md-12">
            <div class="card-style d-flex flex-wrap align-items-center justify-content-between">
                <div class="title">
                    <h2>Therapy Kits</h2>
                    <div class="breadcrumb-wrapper">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active">Therapy Kits</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="right-content">
                    <form class="row row-cols-lg-auto g-3 align-items-center" method="get" action="{{ url()->current() }}">
                        <div class="col-12">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control" placeholder="Search..." value="{{ request('search') }}">
                                @if(!request('search'))
                                    <button class="btn btn-secondary" type="submit"><i class="fa fa-search"></i></button>
                                @else
                                    <a href="{{ url()->current() }}" class="btn btn-secondary">Clear</a>
                                @endif
                            </div>
                        </div>
                        <div class="col-12">
                            <a href="{{ route('admin.therapy_kits.create') }}" class="btn btn-primary">Add Therapy Kit</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card-style mb-30">
                <div class="table-responsive">
                    <table class="table striped-table table-fixed">
                        <thead>
                            <tr>
                                @foreach(['id' => 'ID', 'name' => 'Name', 'price' => 'Price', 'type' => 'Type', 'active' => 'Active'] as $column => $label)
                                    <th scope="col">
                                        <a href="{{ route('admin.therapy_kits.index', array_merge(request()->query(), ['sort_by' => $column, 'sort_order' => $sort_by === $column && $sort_order === 'asc' ? 'desc' : 'asc'])) }}">
                                            {{ $label }}
                                            @if($sort_by === $column)
                                                <i class="fa fa-chevron-{{ $sort_order === 'asc' ? 'down' : 'up' }}"></i>
                                            @endif
                                        </a>
                                    </th>
                                @endforeach
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($therapyKits as $therapyKit)
                                <tr>
                                    <th>{{ $therapyKit->id }}</th>
                                    <td>{{ $therapyKit->name }}</td>
                                    <td>{{ number_format((float) $therapyKit->price, 2) }}</td>
                                    <td>{{ ucfirst($therapyKit->type) }}</td>
                                    <td>
                                        <span class="status-btn {{ $therapyKit->active ? 'active-btn' : 'inactive-btn' }}">
                                            {{ $therapyKit->active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="action">
                                            <a href="{{ route('admin.therapy_kits.edit', ['id' => $therapyKit->id]) }}" class="text-dark me-3" aria-label="Edit {{ $therapyKit->name }}">
                                                <i class="fa fa-pen"></i>
                                            </a>
                                            <a href="{{ route('admin.therapy_kits.destroy', ['id' => $therapyKit->id]) }}" class="text-danger" aria-label="Delete {{ $therapyKit->name }}" onclick="return confirm('Are you sure you want to delete this therapy kit?');">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="text-center">No therapy kits found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-12">{{ $therapyKits->links() }}</div>
    </div>
</div>
@endsection
