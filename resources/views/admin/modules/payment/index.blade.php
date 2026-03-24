@extends('admin.layouts.default')

@section('title', 'Payments')

@section('content')

<div class="container-fluid">

    <div class="row py-4">
        <div class="col-md-12">
            <div class="card-style d-flex flex-wrap align-items-center justify-content-between">
                <div class="title">
                    <h2>Payments</h2>
                    <div class="breadcrumb-wrapper">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('admin.dashboard')}}">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active">Payments</li>
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
                            <a href="{{ route('admin.payments.create')}}" class="btn btn-primary">Add Payment</a>
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
                                <a href="{{ route('admin.payments.index', array_merge(request()->query(), ['sort_by' => 'id', 'sort_order' => request('sort_order') === 'asc' ? 'desc' : 'asc'])) }}">
                                    ID @if($sort_by == 'id') @if($sort_order == 'asc') <i class="fa fa-chevron-down"></i> @else <i class="fa fa-chevron-up"></i> @endif @endif
                                </a>
                            </th>
                            <th scope="col" style="width: 12%;">Booking ID</th>
                            <th scope="col" style="width: 12%;">Amount</th>
                            <th scope="col" style="width: 15%;">Payment Type</th>
                            <th scope="col" style="width: 15%;">Status</th>
                            <th scope="col" style="width: 20%;">Charge ID</th>
                            <th scope="col" style="width: 10%;">Created Date</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($payments as $payment)
                        <tr>
                            <th>{{ $payment->id }}</th>
                            <td>
                                <a href="{{ route('admin.bookings.edit', ['id' => $payment->booking_id]) }}" class="text-primary">
                                    #{{ $payment->booking_id }}
                                </a>
                            </td>
                            <td>£{{ number_format($payment->amount / 100, 2) }}</td>
                            <td>
                                <span class="badge bg-info">{{ ucfirst(str_replace('_', ' ', $payment->payment_type)) }}</span>
                            </td>
                            <td>
                                <span class="status-btn @if($payment->status === 'completed') active-btn @elseif($payment->status === 'pending') warning-btn @elseif($payment->status === 'failed') inactive-btn @elseif($payment->status === 'refunded') secondary-btn @endif">
                                    {{ ucfirst($payment->status) }}
                                </span>
                            </td>
                            <td>{{ $payment->charge_id ?? 'N/A' }}</td>
                            <td>{{ $payment->created_at ? $payment->created_at->format('d M Y H:i') : 'N/A' }}</td>
                            <td>
                                <div class="action">
                                    <a href="{{ route('admin.payments.edit', ['id' => $payment->id]) }}" class="text-dark me-3">
                                        <i class="fa fa-pen"></i>
                                    </a>
                                    <a href="{{ route('admin.payments.destroy', ['id' => $payment->id]) }}" class="text-danger" onclick="return confirm('Are you sure you want to delete this payment?');">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center">No payments found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="col-md-12">
            {{ $payments->links() }}
        </div>

    </div>
</div>

@endsection
