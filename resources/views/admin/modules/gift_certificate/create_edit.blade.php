@extends('admin.layouts.default')

@if(isset($giftCertificate))
@section('title', 'Edit Gift Certificate')
@else
@section('title', 'Create Gift Certificate')
@endif

@section('content')

<div class="container-fluid">
    <div class="row py-4">
        <div class="col-md-12">
            <div class="card-style d-flex flex-wrap align-items-center justify-content-between">
                <div class="title">
                    @if(isset($giftCertificate))
                    <h2>Edit Gift Certificate</h2>
                    @else
                    <h2>Create Gift Certificate</h2>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.gift_certificates.store') }}" method="post">

        @csrf

        @isset($giftCertificate)
        <input type="hidden" name="id" value="{{ $giftCertificate->id }}" />
        @endisset

        <div class="row">

            <div class="col-lg-12">
                <div class="card-style mb-30">
                    <h5 class="mb-3">Recipient Information</h5>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label required" for="recipient_name">Recipient Name</label>
                                <input type="text" name="recipient_name" id="recipient_name" class="form-control" placeholder="Recipient Name" value="{{ old('recipient_name', $giftCertificate->recipient_name ?? '') }}" required />
                                @error('recipient_name')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label required" for="recipient_email">Recipient Email</label>
                                <input type="email" name="recipient_email" id="recipient_email" class="form-control" placeholder="Recipient Email" value="{{ old('recipient_email', $giftCertificate->recipient_email ?? '') }}" required />
                                @error('recipient_email')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="card-style mb-30">
                    <h5 class="mb-3">Sender Information</h5>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label required" for="sender_name">Sender Name</label>
                                <input type="text" name="sender_name" id="sender_name" class="form-control" placeholder="Sender Name" value="{{ old('sender_name', $giftCertificate->sender_name ?? '') }}" required />
                                @error('sender_name')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label required" for="sender_email">Sender Email</label>
                                <input type="email" name="sender_email" id="sender_email" class="form-control" placeholder="Sender Email" value="{{ old('sender_email', $giftCertificate->sender_email ?? '') }}" required />
                                @error('sender_email')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="message">Message</label>
                        <textarea name="message" id="message" class="form-control" rows="4" placeholder="Optional message">{{ old('message', $giftCertificate->message ?? '') }}</textarea>
                        @error('message')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="card-style mb-30">
                    <h5 class="mb-3">Gift Details</h5>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label required" for="gift_amount">Gift Amount</label>
                                <input type="number" step="0.01" name="gift_amount" id="gift_amount" class="form-control" placeholder="0.00" value="{{ old('gift_amount', $giftCertificate->gift_amount ?? '') }}" required />
                                @error('gift_amount')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label required" for="gift_code">Gift Code</label>
                                <input type="text" name="gift_code" id="gift_code" class="form-control" placeholder="Auto-generated" value="{{ old('gift_code', $giftCertificate->gift_code ?? '') }}" required />
                                @error('gift_code')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label required" for="used_amount">Used Amount</label>
                                <input type="number" step="0.01" name="used_amount" id="used_amount" class="form-control" placeholder="0.00" value="{{ old('used_amount', $giftCertificate->used_amount ?? 0) }}" required />
                                @error('used_amount')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label required" for="remaining_amount">Remaining Amount</label>
                                <input type="number" step="0.01" name="remaining_amount" id="remaining_amount" class="form-control" placeholder="0.00" value="{{ old('remaining_amount', $giftCertificate->remaining_amount ?? '') }}" required />
                                @error('remaining_amount')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label required" for="payment_status">Payment Status</label>
                                <select name="payment_status" id="payment_status" class="form-control" required>
                                    <option value="">-- Select Status --</option>
                                    <option value="in_progress" @if(isset($giftCertificate) && $giftCertificate->payment_status == 'in_progress') selected @endif>In Progress</option>
                                    <option value="paid" @if(isset($giftCertificate) && $giftCertificate->payment_status == 'paid') selected @endif>Paid</option>
                                    <option value="failed" @if(isset($giftCertificate) && $giftCertificate->payment_status == 'failed') selected @endif>Failed</option>
                                </select>
                                @error('payment_status')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label required" for="payment_method">Payment Method</label>
                                <select name="payment_method" id="payment_method" class="form-control" required>
                                    <option value="">-- Select Method --</option>
                                    <option value="paypal" @if(isset($giftCertificate) && $giftCertificate->payment_method == 'paypal') selected @endif>PayPal</option>
                                    <option value="stripe" @if(isset($giftCertificate) && $giftCertificate->payment_method == 'stripe') selected @endif>Stripe</option>
                                    <option value="apple_pay" @if(isset($giftCertificate) && $giftCertificate->payment_method == 'apple_pay') selected @endif>Apple Pay</option>
                                </select>
                                @error('payment_method')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label" for="voucher_id">Voucher ID</label>
                                <input type="number" name="voucher_id" id="voucher_id" class="form-control" placeholder="0" value="{{ old('voucher_id', $giftCertificate->voucher_id ?? '') }}" />
                                @error('voucher_id')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="send_at">Send Date</label>
                                <input type="datetime-local" name="send_at" id="send_at" class="form-control" value="{{ old('send_at', isset($giftCertificate) && $giftCertificate->send_at ? $giftCertificate->send_at->format('Y-m-d\TH:i') : '') }}" />
                                @error('send_at')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="expire_at">Expiration Date</label>
                                <input type="datetime-local" name="expire_at" id="expire_at" class="form-control" value="{{ old('expire_at', isset($giftCertificate) && $giftCertificate->expire_at ? $giftCertificate->expire_at->format('Y-m-d\TH:i') : '') }}" />
                                @error('expire_at')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="charge_id">Charge ID</label>
                        <input type="text" name="charge_id" id="charge_id" class="form-control" placeholder="Payment Charge ID" value="{{ old('charge_id', $giftCertificate->charge_id ?? '') }}" readonly />
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="card-style mb-30">
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <a href="{{ route('admin.gift_certificates.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </div>
            </div>
        </div>
    </form>

</div>
@endsection
