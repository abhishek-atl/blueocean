@extends('admin.layouts.default')

@section('title', 'Therapist Applications')

@section('content')
<div class="container-fluid">
    <div class="row py-4">
        <div class="col-md-12">
            <div class="card-style d-flex flex-wrap align-items-center justify-content-between">
                <div class="title">
                    <h2>Therapist Applications</h2>
                    <div class="breadcrumb-wrapper">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active">Applications</li>
                            </ol>
                        </nav>
                    </div>
                </div>

                <div class="right-content">
                    <form class="row row-cols-lg-auto g-3 align-items-center" method="get" action="{{ url()->current() }}">
                        <div class="col-12">
                            <select name="status" class="form-control" onchange="this.form.submit()">
                                <option value="">All applications</option>
                                <option value="pending" @selected(request('status') === 'pending')>Pending</option>
                                <option value="approved" @selected(request('status') === 'approved')>Approved</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control" placeholder="Search..." value="{{ request('search') }}">
                                <button class="btn btn-secondary" type="submit"><i class="fa fa-search"></i></button>
                                @if(request('search') || request('status'))
                                <a href="{{ url()->current() }}" class="btn btn-secondary">Clear</a>
                                @endif
                            </div>
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
                            <th scope="col" style="width: 7%;">
                                <a href="{{ route('admin.therapist_applications.index', array_merge(request()->query(), ['sort_by' => 'id', 'sort_order' => $sort_by === 'id' && $sort_order === 'asc' ? 'desc' : 'asc'])) }}">ID</a>
                            </th>
                            <th scope="col" style="width: 14%;">First Name</th>
                            <th scope="col" style="width: 14%;">Last Name</th>
                            <th scope="col" style="width: 22%;">Email</th>
                            <th scope="col" style="width: 14%;">Mobile</th>
                            <th scope="col">Therapy Kit</th>
                            <th scope="col" style="width: 13%;">Applied</th>
                            <th scope="col" style="width: 9%;">Status</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($applications as $application)
                        <tr>
                            <th scope="row">{{ $application->id }}</th>
                            <td>{{ $application->first_name }}</td>
                            <td>{{ $application->last_name }}</td>
                            <td>{{ $application->email }}</td>
                            <td>{{ $application->mobile ?: 'N/A' }}</td>
                            <td>
                                @php
                                    $selectedKits = collect($application->therapy_kit_ids ?? [])
                                        ->map(fn ($id) => $therapyKits->get($id))
                                        ->filter();
                                @endphp
                                {{ $selectedKits->isNotEmpty() ? $selectedKits->join(', ') : 'None selected' }}
                            </td>
                            <td>{{ $application->created_at->format(config('custom.format.date_time')) }}</td>
                            <td>
                                <span class="badge {{ $application->approved ? 'bg-success' : 'bg-warning' }}">
                                    {{ $application->approved ? 'Approved' : 'Pending' }}
                                </span>
                            </td>
                            <td>
                                @if(!$application->approved)
                                <form action="{{ route('admin.therapist_applications.approve', ['id' => $application->id]) }}" method="post" onsubmit="return confirm('Approve this application and create a therapist account?');">
                                    @csrf
                                    <button type="submit" class="btn btn-primary btn-sm">Approve</button>
                                </form>
                                @else
                                <span class="text-muted">—</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center">No therapist applications found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                {{ $applications->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
