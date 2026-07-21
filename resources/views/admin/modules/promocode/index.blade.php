@extends('admin.layouts.default')

@section('title', 'Promocodes')

@section('content')
<div class="container-fluid">
    <div class="row py-3">
        <div class="col-md-12">
            <div class="card-style d-flex flex-wrap align-items-center justify-content-between">
                <div class="title">
                    <h2>Promocodes</h2>
                    <div class="breadcrumb-wrapper">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active">Promocodes</li>
                            </ol>
                        </nav>
                    </div>
                </div>

                <div class="right-content">
                    <form class="row row-cols-lg-auto g-3 align-items-center" method="get" action="{{ url()->current() }}">
                        <div class="col-12">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control" placeholder="Search code..." value="{{ request('search') }}">
                                @if(!request('search'))
                                <button class="btn btn-secondary" type="submit"><i class="fa fa-search"></i></button>
                                @else
                                <a href="{{ url()->current() }}" class="btn btn-secondary">Clear</a>
                                @endif
                            </div>
                        </div>
                        <div class="col-12">
                            <a href="{{ route('admin.promocodes.create') }}" class="btn btn-primary">Add Promocode</a>
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
                                <a href="{{ route('admin.promocodes.index', array_merge(request()->query(), ['sort_by' => 'id', 'sort_order' => $sort_by === 'id' && $sort_order === 'asc' ? 'desc' : 'asc'])) }}">ID</a>
                            </th>
                            <th scope="col" style="width: 16%;">
                                <a href="{{ route('admin.promocodes.index', array_merge(request()->query(), ['sort_by' => 'code', 'sort_order' => $sort_by === 'code' && $sort_order === 'asc' ? 'desc' : 'asc'])) }}">Code</a>
                            </th>
                            <th scope="col" style="width: 12%;">Amount</th>
                            <th scope="col">Tariff Plans</th>
                            <th scope="col" style="width: 14%;">Expires</th>
                            <th scope="col" style="width: 10%;">Active</th>
                            <th scope="col" style="width: 10%;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($promocodes as $promocode)
                        <tr>
                            <th scope="row">{{ $promocode->id }}</th>
                            <td><code>{{ $promocode->code }}</code></td>
                            <td>£{{ number_format($promocode->amount, 2) }}</td>
                            <td>
                                {{ $promocode->tariffPlans->map(fn ($plan) => $plan->duration . ' minutes')->join(', ') }}
                            </td>
                            <td>{{ $promocode->expires_at->format(config('custom.format.date_time')) }}</td>
                            <td>
                                <span class="badge {{ $promocode->active ? 'bg-success' : 'bg-warning' }}">
                                    {{ $promocode->active ? 'Yes' : 'No' }}
                                </span>
                            </td>
                            <td>
                                <div class="action">
                                    <a href="{{ route('admin.promocodes.edit', ['id' => $promocode->id]) }}" class="text-dark me-3" aria-label="Edit {{ $promocode->code }}">
                                        <i class="fa fa-pen"></i>
                                    </a>
                                    <a href="{{ route('admin.promocodes.destroy', ['id' => $promocode->id]) }}" class="text-danger" aria-label="Delete {{ $promocode->code }}" onclick="return confirm('Are you sure you want to delete this promocode?');">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">No promocodes found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                {{ $promocodes->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
