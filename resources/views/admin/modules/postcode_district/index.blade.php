@extends('admin.layouts.default')

@section('title', 'Districts')

@section('content')

<div class="container-fluid">

    <div class="row py-4">
        <div class="col-md-12">
            <div class="card-style d-flex flex-wrap align-items-center justify-content-between">
                <div class="title">
                    <h2>Post Districts</h2>
                    <div class="breadcrumb-wrapper">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('admin.dashboard')}}">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active">Post Districts</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="right-content">
                    <form method="get" action="{{ url()->current() }}">
                        <div class="input-group mb-3">
                            <input type="text" name="search" class="form-control" placeholder="Search..." value="{{ Request::get('search') }}">
                            @if(!Request::get('search'))
                            <button class="btn btn-secondary" type="submit"><i class="fa fa-search"></i></button>
                            @else
                            <a href="{{ url()->current() }}" class="btn btn-secondary" type="button">Clear</a>
                            @endif
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
                            <th scope="col" style="width: 10%;">
                                <a href="{{ route('admin.postcode_districts.index', array_merge(request()->query(), ['sort_by' => 'id', 'sort_order' => request('sort_order') === 'asc' ? 'desc' : 'asc'])) }}">
                                    ID @if($sort_by == 'id') @if($sort_order == 'asc') <i class="fa fa-chevron-down"></i> @else <i class="fa fa-chevron-up"></i> @endif @endif
                                </a>
                            </th>
                            <th scope="col" style="width: 25%;">
                                <a href="{{ route('admin.postcode_districts.index', array_merge(request()->query(), ['sort_by' => 'postcode_area', 'sort_order' => request('sort_order') === 'asc' ? 'desc' : 'asc'])) }}">
                                    Postcode @if($sort_by == 'postcode_area') @if($sort_order == 'asc') <i class="fa fa-chevron-down"></i> @else <i class="fa fa-chevron-up"></i> @endif @endif
                                </a>
                            </th>
                            <th scope="col">
                                <a href="{{ route('admin.postcode_districts.index', array_merge(request()->query(), ['sort_by' => 'district_name', 'sort_order' => request('sort_order') === 'asc' ? 'desc' : 'asc'])) }}">
                                    District Name @if($sort_by == 'district_name') @if($sort_order == 'asc') <i class="fa fa-chevron-down"></i> @else <i class="fa fa-chevron-up"></i> @endif @endif
                                </a>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($districts as $district)
                        <tr>
                            <th scope="row">{{ $district->id }}</th>
                            <td>{{ $district->postcode_area }}</td>
                            <td>{{ $district->district_name }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="col-md-12">
            {{ $districts->links() }}
        </div>

    </div>

</div>
@endsection