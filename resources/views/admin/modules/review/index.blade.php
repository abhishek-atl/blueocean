@extends('admin.layouts.default')

@section('title', 'Reviews')

@section('content')

<div class="container-fluid">

    <div class="row py-3">
        <div class="col-md-12">
            <div class="card-style d-flex flex-wrap align-items-center justify-content-between">
                <div class="title">
                    <h2>Reviews</h2>
                    <div class="breadcrumb-wrapper">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('admin.dashboard')}}">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active">Reviews</li>
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
                            <a href="{{ route('admin.reviews.create')}}" class="btn btn-primary">Create Review</a>
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
                                <a href="{{ route('admin.reviews.index', array_merge(request()->query(), ['sort_by' => 'id', 'sort_order' => request('sort_order') === 'asc' ? 'desc' : 'asc'])) }}">
                                    ID @if($sort_by == 'id') @if($sort_order == 'asc') <i class="fa fa-chevron-down"></i> @else <i class="fa fa-chevron-up"></i> @endif @endif
                                </a>
                            </th>
                            <th scope="col" style="width: 12%;">
                                <a href="{{ route('admin.reviews.index', array_merge(request()->query(), ['sort_by' => 'first_name', 'sort_order' => request('sort_order') === 'asc' ? 'desc' : 'asc'])) }}">
                                    Name @if($sort_by == 'first_name') @if($sort_order == 'asc') <i class="fa fa-chevron-down"></i> @else <i class="fa fa-chevron-up"></i> @endif @endif
                                </a>
                            </th>
                            <th scope="col" style="width: 15%;">
                                Email
                            </th>
                            <th scope="col" style="width: 12%;">
                                Location
                            </th>
                            <th scope="col" style="width: 12%;">
                                Profession
                            </th>
                            <th scope="col" style="width: 10%;">
                                Status
                            </th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reviews as $review)
                        <tr>
                            <th scope="row">{{ $review->id }}</th>
                            <td>{{ $review->first_name }} {{ $review->last_name }}</td>
                            <td>{{ $review->email }}</td>
                            <td>{{ $review->location }}</td>
                            <td>{{ $review->profession }}</td>
                            <td>
                                <span class="badge {{ $review->status ? 'bg-success' : 'bg-warning' }}">
                                    {{ $review->status ? 'Approved' : 'Pending' }}
                                </span>
                            </td>
                            <td>
                                <div class="action">
                                    <a href="{{ route('admin.reviews.edit', ['id' => $review->id]) }}" class="text-dark me-3">
                                        <i class="fa fa-pen"></i>
                                    </a>
                                    <a href="{{ route('admin.reviews.destroy', ['id' => $review->id]) }}" class="text-danger" onclick="return confirm('Are you sure you want to delete this review?');">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">No reviews found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection
