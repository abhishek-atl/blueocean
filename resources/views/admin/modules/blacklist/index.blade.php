@extends('admin.layouts.default')

@section('title', 'Blacklists')

@section('content')

<div class="container-fluid">

    <div class="row py-3">
        <div class="col-md-12">
            <div class="card-style d-flex flex-wrap align-items-center justify-content-between">
                <div class="title">
                    <h2>Blacklists</h2>
                    <div class="breadcrumb-wrapper">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('admin.dashboard')}}">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active">Blacklists</li>
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
                            <a href="{{ route('admin.blacklists.create')}}" class="btn btn-primary">Add to Blacklist</a>
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
                                <a href="{{ route('admin.blacklists.index', array_merge(request()->query(), ['sort_by' => 'id', 'sort_order' => request('sort_order') === 'asc' ? 'desc' : 'asc'])) }}">
                                    ID @if($sort_by == 'id') @if($sort_order == 'asc') <i class="fa fa-chevron-down"></i> @else <i class="fa fa-chevron-up"></i> @endif @endif
                                </a>
                            </th>
                            <th scope="col" style="width: 15%;">
                                Mobile
                            </th>
                            <th scope="col" style="width: 15%;">
                                IP Address
                            </th>
                            <th scope="col" style="width: 10%;">
                                Type
                            </th>
                            <th scope="col" style="width: 15%;">
                                Reason
                            </th>
                            <th scope="col" style="width: 15%;">
                                Approved At
                            </th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($blacklists as $blacklist)
                        <tr>
                            <th scope="row">{{ $blacklist->id }}</th>
                            <td>{{ $blacklist->mobile ?? '-' }}</td>
                            <td>{{ $blacklist->ip_address ?? '-' }}</td>
                            <td>
                                @if($blacklist->type)
                                <span class="badge bg-info">{{ ucfirst($blacklist->type) }}</span>
                                @else
                                <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>{{ Str::limit($blacklist->reason, 40) ?? '-' }}</td>
                            <td>
                                @if($blacklist->approved_at)
                                <span class="badge bg-success">{{ $blacklist->approved_at->format('M d, Y') }}</span>
                                @else
                                <span class="badge bg-warning">Pending</span>
                                @endif
                            </td>
                            <td>
                                <div class="action">
                                    <a href="{{ route('admin.blacklists.edit', ['id' => $blacklist->id]) }}" class="text-dark me-3">
                                        <i class="fa fa-pen"></i>
                                    </a>
                                    <a href="{{ route('admin.blacklists.destroy', ['id' => $blacklist->id]) }}" class="text-danger" onclick="return confirm('Are you sure you want to remove this blacklist entry?');">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">No blacklist entries found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection
