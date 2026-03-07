@extends('admin.layouts.default')

@section('title', 'Tariff Plans')

@section('content')

<div class="container-fluid">

    <div class="row py-3">
        <div class="col-md-12">
            <div class="card-style d-flex flex-wrap align-items-center justify-content-between">
                <div class="title">
                    <h2>Tariff Plans</h2>
                    <div class="breadcrumb-wrapper">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('admin.dashboard')}}">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active">Tariff Plans</li>
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
                            <a href="{{ route('admin.tariff_plans.create')}}" class="btn btn-primary">Create Plan</a>
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
                                <a href="{{ route('admin.tariff_plans.index', array_merge(request()->query(), ['sort_by' => 'id', 'sort_order' => request('sort_order') === 'asc' ? 'desc' : 'asc'])) }}">
                                    ID @if($sort_by == 'id') @if($sort_order == 'asc') <i class="fa fa-chevron-down"></i> @else <i class="fa fa-chevron-up"></i> @endif @endif
                                </a>
                            </th>
                            <th scope="col" style="width: 20%;">
                                <a href="{{ route('admin.tariff_plans.index', array_merge(request()->query(), ['sort_by' => 'name', 'sort_order' => request('sort_order') === 'asc' ? 'desc' : 'asc'])) }}">
                                    Name @if($sort_by == 'name') @if($sort_order == 'asc') <i class="fa fa-chevron-down"></i> @else <i class="fa fa-chevron-up"></i> @endif @endif
                                </a>
                            </th>
                            <th scope="col" style="width: 12%;">
                                Duration (Days)
                            </th>
                            <th scope="col" style="width: 12%;">
                                Amount
                            </th>
                            <th scope="col" style="width: 12%;">
                                Fee
                            </th>
                            <th scope="col" style="width: 10%;">
                                Active
                            </th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tariffPlans as $plan)
                        <tr>
                            <th scope="row">{{ $plan->id }}</th>
                            <td>{{ $plan->name }}</td>
                            <td>{{ $plan->duration }}</td>
                            <td>{{ number_format($plan->amount, 2) }}</td>
                            <td>{{ number_format($plan->fee, 2) }}</td>
                            <td>
                                <span class="badge {{ $plan->active ? 'bg-success' : 'bg-warning' }}">
                                    {{ $plan->active ? 'Yes' : 'No' }}
                                </span>
                            </td>
                            <td>
                                <div class="action">
                                    <a href="{{ route('admin.tariff_plans.edit', ['id' => $plan->id]) }}" class="text-dark me-3">
                                        <i class="fa fa-pen"></i>
                                    </a>
                                    <a href="{{ route('admin.tariff_plans.destroy', ['id' => $plan->id]) }}" class="text-danger" onclick="return confirm('Are you sure you want to delete this plan?');">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">No tariff plans found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection
