@extends('admin.layouts.default')

@section('title', 'Bookings')

@section('content')

<div class="container-fluid">

    <div class="row py-4">
        <div class="col-md-12">
            <div class="card-style d-flex flex-wrap align-items-center justify-content-between">
                <div class="title">
                    <h2>Bookings</h2>
                    <div class="breadcrumb-wrapper">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('admin.dashboard')}}">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active">Bookings</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="right-content">
                    <form class="row row-cols-lg-auto g-3 align-items-center" method="get" action="{{ url()->current() }}">
                        <div class="col-12">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control" placeholder="Search by client name..." value="{{ Request::get('search') }}">
                                @if(!Request::get('search'))
                                <button class="btn btn-secondary" type="submit"><i class="fa fa-search"></i></button>
                                @else
                                <a href="{{ url()->current() }}" class="btn btn-secondary" type="button">Clear</a>
                                @endif
                            </div>
                        </div>
                        <div class="col-12">
                            <a href="{{ route('admin.bookings.create')}}" class="btn btn-primary">Add Booking</a>
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
                                <a href="{{ route('admin.bookings.index', array_merge(request()->query(), ['sort_by' => 'id', 'sort_order' => request('sort_order') === 'asc' ? 'desc' : 'asc'])) }}">
                                    ID @if($sort_by == 'id') @if($sort_order == 'asc') <i class="fa fa-chevron-down"></i> @else <i class="fa fa-chevron-up"></i> @endif @endif
                                </a>
                            </th>
                            <th scope="col" style="width: 15%;">Client Name</th>
                            <th scope="col" style="width: 15%;">Therapist</th>
                            <th scope="col" style="width: 15%;">Treatment</th>
                            <th scope="col" style="width: 15%;">Appointment Date</th>
                            <th scope="col" style="width: 10%;">Cost</th>
                            <th scope="col" style="width: 10%;">Status</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bookings as $booking)
                        <tr>
                            <th>{{ $booking->id }}</th>
                            <td>{{ $booking->name }}</td>
                            <td>{{ $booking->therapist->first_name ?? 'N/A' }} {{ $booking->therapist->last_name ?? '' }}</td>
                            <td>{{ $booking->treatment->name ?? 'N/A' }}</td>
                            <td>{{ $booking->appointment_start ? $booking->appointment_start->format('d M Y H:i') : 'N/A' }}</td>
                            <td>£{{ number_format($booking->amount, 2) }}</td>
                            <td>
                                <span class="status-btn @if($booking->status === 'cancelled') inactive-btn @elseif($booking->status === 'processing') warning-btn @else active-btn @endif">
                                    {{ ucfirst($booking->status ?? 'new') }}
                                </span>
                            </td>
                            <td>
                                <div class="action">
                                    <a href="{{ route('admin.bookings.edit', ['id' => $booking->id]) }}" class="text-dark me-3">
                                        <i class="fa fa-pen"></i>
                                    </a>
                                    <a href="{{ route('admin.bookings.destroy', ['id' => $booking->id]) }}" class="text-danger" onclick="return confirm('Are you sure you want to delete this booking?');">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center">No bookings found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="col-md-12">
            {{ $bookings->links() }}
        </div>

    </div>
</div>

@endsection
