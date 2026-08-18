@extends('admin.layouts.default')

@section('title', 'Pages')

@section('content')
<div class="container-fluid">
    <div class="row py-3">
        <div class="col-md-12">
            <div class="card-style d-flex flex-wrap align-items-center justify-content-between">
                <div class="title">
                    <h2>Pages</h2>
                    <div class="breadcrumb-wrapper">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active">Pages</li>
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
                            <a href="{{ route('admin.pages.create') }}" class="btn btn-primary">Add Page</a>
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
                                @foreach(['id' => 'ID', 'title' => 'Title', 'slug' => 'Slug', 'author' => 'Author', 'active' => 'Active'] as $column => $label)
                                <th scope="col">
                                    <a href="{{ route('admin.pages.index', array_merge(request()->query(), ['sort_by' => $column, 'sort_order' => $sort_by === $column && $sort_order === 'asc' ? 'desc' : 'asc'])) }}">
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
                            @forelse($pages as $page)
                            <tr>
                                <th scope="row">{{ $page->id }}</th>
                                <td>{{ $page->title }}</td>
                                <td>{{ $page->slug }}</td>
                                <td>{{ $page->author }}</td>
                                <td>{{ $page->active ? 'Yes' : 'No' }}</td>
                                <td>
                                    <div class="action">
                                        <a href="{{ route('admin.pages.edit', ['id' => $page->id]) }}" class="text-dark me-3" aria-label="Edit {{ $page->title }}">
                                            <i class="fa fa-pen"></i>
                                        </a>
                                        <a href="{{ route('admin.pages.destroy', ['id' => $page->id]) }}" class="text-danger" aria-label="Delete {{ $page->title }}" onclick="return confirm('Are you sure you want to delete this page?');">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="6" class="text-center">No pages found</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{ $pages->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
