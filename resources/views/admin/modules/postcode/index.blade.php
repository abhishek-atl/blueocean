@extends('admin.layouts.default')

@section('title', 'Postcodes')

@section('content')

<div class="container-fluid">

    <div class="row py-3">
        <div class="col-md-12">
            <div class="card-style d-flex flex-wrap align-items-center justify-content-between">
                <div class="title">
                    <h2>Postcodes</h2>
                    <div class="breadcrumb-wrapper">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('admin.dashboard')}}">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active">Postcodes</li>
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
                            <a href="{{ route('admin.postcodes.create')}}" class="btn btn-primary">Create Postcode</a>
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
                                <a href="{{ route('admin.postcodes.index', array_merge(request()->query(), ['sort_by' => 'id', 'sort_order' => request('sort_order') === 'asc' ? 'desc' : 'asc'])) }}">
                                    ID @if($sort_by == 'id') @if($sort_order == 'asc') <i class="fa fa-chevron-down"></i> @else <i class="fa fa-chevron-up"></i> @endif @endif
                                </a>
                            </th>
                            <th scope="col" style="width: 15%;">
                                <a href="{{ route('admin.postcodes.index', array_merge(request()->query(), ['sort_by' => 'postcode', 'sort_order' => request('sort_order') === 'asc' ? 'desc' : 'asc'])) }}">
                                    Postcode @if($sort_by == 'postcode') @if($sort_order == 'asc') <i class="fa fa-chevron-down"></i> @else <i class="fa fa-chevron-up"></i> @endif @endif
                                </a>
                            </th>
                            <th scope="col" style="width: 15%;">
                                District
                            </th>
                            <th scope="col" style="width: 15%;">
                                Travel Supplement
                            </th>
                            <th scope="col" style="width: 15%;">
                                Active
                            </th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($postcodes as $postcode)
                        <tr>
                            <th scope="row">{{ $postcode->id }}</th>
                            <td>{{ $postcode->postcode }}</td>
                            <td>{{ $postcode->district->district_name }}</td>
                            <td>{{ $postcode->travel_supp ?? 'Free'}}</td>
                            <td>{{ $postcode->active ? 'Yes' : 'No' }}</td>
                            <td>
                                <div class="action">
                                    <a href="{{ route('admin.postcodes.edit', ['id' => $postcode->id]) }}" class="text-dark me-3">
                                        <i class="fa fa-pen"></i>
                                    </a>
                                    <a href="{{ route('admin.postcodes.destroy', ['id' => $postcode->id]) }}" class="text-danger" onclick="return confirm('Are you sure you want to delete this postcode?');">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="col-md-12">
            {{ $postcodes->links() }}
        </div>

    </div>

</div>
@endsection