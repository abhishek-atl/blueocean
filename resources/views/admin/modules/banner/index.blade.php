@extends('admin.layouts.default')

@section('title', 'Banners')

@section('content')

<div class="container-fluid">

    <div class="row py-3">
        <div class="col-md-12">
            <div class="card-style d-flex flex-wrap align-items-center justify-content-between">
                <div class="title">
                    <h2>Banners</h2>
                    <div class="breadcrumb-wrapper">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('admin.dashboard')}}">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active">Banners</li>
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
                            <a href="{{ route('admin.banners.create')}}" class="btn btn-primary">Create Banner</a>
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
                            <th scope="col" style="width: 8%;">
                                <a href="{{ route('admin.banners.index', array_merge(request()->query(), ['sort_by' => 'id', 'sort_order' => request('sort_order') === 'asc' ? 'desc' : 'asc'])) }}">
                                    ID @if($sort_by == 'id') @if($sort_order == 'asc') <i class="fa fa-chevron-down"></i> @else <i class="fa fa-chevron-up"></i> @endif @endif
                                </a>
                            </th>
                            <th scope="col" style="width: 35%;">Text</th>
                            <th scope="col" style="width: 20%;">URL</th>
                            <th scope="col" style="width: 15%;">
                                <a href="{{ route('admin.banners.index', array_merge(request()->query(), ['sort_by' => 'placement', 'sort_order' => request('sort_order') === 'asc' ? 'desc' : 'asc'])) }}">
                                    Placement @if($sort_by == 'placement') @if($sort_order == 'asc') <i class="fa fa-chevron-down"></i> @else <i class="fa fa-chevron-up"></i> @endif @endif
                                </a>
                            </th>
                            <th scope="col" style="width: 10%;">Status</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($banners as $banner)
                        <tr>
                            <th scope="row">{{ $banner->id }}</th>
                            <td>{{ Str::limit($banner->text, 80) }}</td>
                            <td>
                                @if($banner->url)
                                <a href="{{ $banner->url }}" target="_blank">{{ Str::limit($banner->url, 40) }}</a>
                                @else
                                N/A
                                @endif
                            </td>
                            <td>
                                @if($banner->placement == 'home')
                                Home Page
                                @elseif($banner->placement == 'booking')
                                Booking Page
                                @else
                                N/A
                                @endif
                            </td>
                            <td>
                                <span class="badge {{ $banner->active ? 'bg-success' : 'bg-warning' }}">
                                    {{ $banner->active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td>
                                <div class="action">
                                    <a href="{{ route('admin.banners.edit', ['id' => $banner->id]) }}" class="text-dark me-3">
                                        <i class="fa fa-pen"></i>
                                    </a>
                                    <a href="{{ route('admin.banners.destroy', ['id' => $banner->id]) }}" class="text-danger" onclick="return confirm('Are you sure you want to delete this marquee?');">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">No Banners found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection