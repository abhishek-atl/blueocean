@extends('admin.layouts.default')

@section('content')

<div class="container-fluid">
    <div class="row py-4">
        <div class="col-md-12">
            <div class="card-style d-flex flex-wrap align-items-center justify-content-between">
                <div class="title">
                    @if(isset($payment))
                    <h2>Edit Payment</h2>
                    @else
                    <h2>Create Payment</h2>
                    @endif

                    <div class="breadcrumb-wrapper">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('admin.dashboard')}}">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="{{ route('admin.payments.index') }}">Payments</a>
                                </li>
                                @if(isset($payment))
                                <li class="breadcrumb-item active">Edit Payment</li>
                                @else
                                <li class="breadcrumb-item active">Add Payment</li>
                                @endif
                            </ol>
                        </nav>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.payments.store') }}" method="post" id="storePaymentForm">

        @csrf

        @isset($payment)
        <input type="hidden" name="id" value="{{ $payment->id }}" />
        @endisset

        <div class="row">
            <!-- Booking Information -->
            <div class="col-lg-6">
                <div class="card-style mb-30">
                    <div class="mb-3">
                        <label class="form-label required" for="booking_id">Booking</label>
                        <select name="booking_id" id="booking_id" class="form-control" required>
                            <option value="">-- Select Booking --</option>
                            @foreach($bookings as $booking)
                            <option value="{{ $booking->id }}" @if(old('booking_id', $payment->booking_id ?? '') == $booking->id) selected @endif>
                                #{{ $booking->id }} - {{ $booking->name }} (£{{ number_format($booking->amount, 2) }})
                            </option>
                            @endforeach
                        </select>
                        @error('booking_id')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label required" for="amount">Amount</label>
                        <input type="number" name="amount" id="amount" class="form-control" placeholder="Amount" value="{{ old('amount', $payment->amount ?? '') }}" required />
                        @error('amount')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label required" for="payment_type">Payment Type</label>
                        <select name="payment_type" id="payment_type" class="form-control" required>
                            <option value="">-- Select Payment Type --</option>
                            <option value="cash" @if(old('payment_type', $payment->payment_type ?? '') === 'cash') selected @endif>Cash</option>
                            <option value="credit" @if(old('payment_type', $payment->payment_type ?? '') === 'credit') selected @endif>Credit</option>
                            <option value="stripe" @if(old('payment_type', $payment->payment_type ?? '') === 'stripe') selected @endif>Stripe</option>
                            <option value="gift_voucher" @if(old('payment_type', $payment->payment_type ?? '') === 'gift_voucher') selected @endif>Gift Voucher</option>
                        </select>
                        @error('payment_type')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label required" for="status">Status</label>
                        <select name="status" id="status" class="form-control" required>
                            <option value="">-- Select Status --</option>
                            <option value="pending" @if(old('status', $payment->status ?? '') === 'pending') selected @endif>Pending</option>
                            <option value="completed" @if(old('status', $payment->status ?? '') === 'completed') selected @endif>Completed</option>
                            <option value="failed" @if(old('status', $payment->status ?? '') === 'failed') selected @endif>Failed</option>
                            <option value="refunded" @if(old('status', $payment->status ?? '') === 'refunded') selected @endif>Refunded</option>
                        </select>
                        @error('status')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="refund_amount">Refund Amount</label>
                        <input type="number" name="refund_amount" id="refund_amount" class="form-control" placeholder="Refund amount in pence" value="{{ old('refund_amount', $payment->refund_amount ?? '') }}" />
                        @error('refund_amount')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="charge_id">Stripe Charge ID</label>
                        <input type="text" name="charge_id" id="charge_id" class="form-control" placeholder="Stripe Charge ID" value="{{ old('charge_id', $payment->charge_id ?? '') }}" />
                        @error('charge_id')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            @if($payment && $payment->booking)
            <div class="col-lg-6">
                <div class="card-style mb-30">
                    <div class="mb-3">
                        <label class="form-label">Booking Details</label>
                        <table class="table">
                            <tr>
                                <th>Client:</th>
                                <td>{{ $payment->booking->name }}</td>
                            </tr>
                            <tr>
                                <th>Therapist:</th>
                                <td>{{ $payment->booking->therapist->first_name }} {{ $payment->booking->therapist->last_name }}</td>
                            </tr>
                            <tr>
                                <th>Treatment:</th>
                                <td>{{ $payment->booking->treatment->name }}</td>
                            </tr>
                            <tr>
                                <th>Booking Cost:</th>
                                <td>£{{ number_format($payment->booking->amount, 2) }}</td>
                            </tr>
                            <tr>
                                <th>Status:</th>
                                <td>{{ ucfirst($payment->booking->status ?? 'new') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            @endif

            <!-- Form Actions -->
             @include('admin.modules.common.form_action_buttons', ['cancel_url' => route('admin.payments.index')])

        </div>
    </form>

</div>

@endsection

@push('pageScripts')

<script>
    $(document).ready(function () {
        // Update displayed booking details when selection changes
        $('#booking_id').on('change', function () {
            // You can add dynamic booking details loading here via AJAX
        });
    });
</script>

@endpush