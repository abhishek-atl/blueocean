@extends('admin.layouts.default')

@section('title', 'Treatment Categories')

@section('content')

<div class="container-fluid">

    <div class="row py-4">
        <div class="col-md-12">
            <div class="card-style d-flex flex-wrap align-items-center justify-content-between">
                <div class="title">
                    <h2>Treatment Categories</h2>
                    <div class="breadcrumb-wrapper">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('admin.dashboard')}}">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active">Treatment Categories</li>
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
                            <a href="{{ route('admin.treatment_categories.create')}}" class="btn btn-primary">Add Treatment Category</a>
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
                                <a href="{{ route('admin.treatment_categories.index', array_merge(request()->query(), ['sort_by' => 'id', 'sort_order' => request('sort_order') === 'asc' ? 'desc' : 'asc'])) }}">
                                    ID @if($sort_by == 'id') @if($sort_order == 'asc') <i class="fa fa-chevron-down"></i> @else <i class="fa fa-chevron-up"></i> @endif @endif
                                </a>
                            </th>
                            <th scope="col" style="width: 20%;">Name</th>
                                <th scope="col" style="width: 10%;">Active</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($treatmentCategories as $treatmentCategory)
                        <tr>
                            <th>{{ $treatmentCategory->id }}</th>
                            <td>{{ $treatmentCategory->name }}</td>
                            <td><span class="status-btn {{ $treatmentCategory->is_active ? 'active-btn' : 'inactive-btn' }}">{{ $treatmentCategory->active ? 'Active' : 'Inactive' }}</span></td>
                            <td>
                                <div class="action">

                                    <div class="action">
                                        <a href="{{ route('admin.treatment_categories.edit', ['id' => $treatmentCategory->id]) }}" class="text-dark me-3">
                                            <i class="fa fa-pen"></i>
                                        </a>
                                        <a href="{{ route('admin.treatment_categories.destroy', ['id' => $treatmentCategory->id]) }}" class="text-danger" onclick="return confirm('Are you sure you want to delete this treatment category?');">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="col-md-12">
            {{ $treatmentCategories->links() }}
        </div>

    </div>
</div>

@endsection