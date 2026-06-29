@extends('admin.layouts.default')

@section('title', 'Dashboard')

@section('content')

<div class="container-fluid">

    <div class="row py-4">
        <div class="col-md-12">
            <div class="card-style d-flex flex-wrap align-items-center justify-content-between">
                <div class="title">
                    <h2>Dashboard</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-3 col-lg-4 col-sm-6">
            <div class="icon-card mb-30">
                <div class="icon purple">
                    <i class="fa-solid fa-cart-shopping"></i>
                </div>
                <div class="content">
                    <h6 class="mb-10">New Bookings</h6>
                    <h3 class="text-bold mb-10">{{ $bookings->count() }}</h3>
                    <p class="text-sm text-gray">Last 7 days</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-4 col-sm-6">
            <div class="icon-card mb-30">
                <div class="icon success">
                    <i class="fa-solid fa-dollar-sign"></i>
                </div>
                <div class="content">
                    <h6 class="mb-10">Total Income</h6>
                    <h3 class="text-bold mb-10">&pound;{{ number_format($totalIncome/100, 2) }}</h3>
                    <p class="text-sm text-gray">From recent bookings</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-4 col-sm-6">
            <div class="icon-card mb-30">
                <div class="icon primary">
                    <i class="fa-solid fa-credit-card"></i>
                </div>
                <div class="content">
                    <h6 class="mb-10">Total Payout</h6>
                    <h3 class="text-bold mb-10">&pound;{{ number_format($totalPayout, 2) }}</h3>
                    <p class="text-sm text-gray">Settled therapist payout</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-4 col-sm-6">
            <div class="icon-card mb-30">
                <div class="icon orange">
                    <i class="fa-solid fa-user"></i>
                </div>
                <div class="content">
                    <h6 class="mb-10">New Users</h6>
                    <h3 class="text-bold mb-10">{{ $newUsers }}</h3>
                    <p class="text-sm text-gray">Last 7 days</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card-style mb-30">
                <div class="title d-flex flex-wrap align-items-center justify-content-between">
                    <div class="left">
                        <h6 class="text-medium mb-30">Recent New Bookings</h6>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table top-selling-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Customer Name</th>
                                <th>Therapist Name</th>
                                <th>Treatment</th>
                                <th>Booked At</th>
                                <th>Status</th>
                                <th>
                                    <h6 class="text-sm text-medium text-end">
                                        Actions <i class="lni lni-arrows-vertical"></i>
                                    </h6>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($bookings as $booking)
                            <tr>
                                <td>{{ $booking->id }}</td>
                                <td>{{ $booking->name }}</td>
                                <td>{{ $booking->therapist->first_name ?? 'N/A' }} {{ $booking->therapist->last_name ?? '' }}</td>
                                <td>{{ $booking->treatment->name ?? 'N/A' }}</td>
                                <td>{{ $booking->created_at ? $booking->created_at->format('d M Y H:i') : 'N/A' }}</td>
                                <td><span class="status-btn active-btn">{{ ucfirst($booking->status ?? 'new') }}</span></td>
                                <td>
                                    <div class="action justify-content-end">
                                        <a href="{{ route('admin.bookings.edit', ['id' => $booking->id]) }}" class="more-btn ml-10">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center">No new bookings found from the last 7 days.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection
