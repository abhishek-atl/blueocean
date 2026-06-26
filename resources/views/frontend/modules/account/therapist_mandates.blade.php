@extends('frontend.layouts.default')

@inject('format', 'App\Services\FormatService')

@section('title', 'Therapist Dashboard | Mandates')

@section('content')

<div class="container pt50 mb40">

    <div class="row">
        <div class="col-3">
            <h1 class="text-primary mb-4">Profile</h1>
        </div>
        <div class="col-9 text-right">
            <a class="btn btn-secondary" href="{{ route('profile') }}">Personal</a>
            <a class="btn btn-secondary" href="{{ route('postcodes') }}">Postcode</a>
            <a class="btn btn-secondary" href="{{ route('schedules') }}">Schedule</a>
            <a class="btn btn-primary" href="{{ route('mandates') }}">Mandates</a>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card mb-3">
                <div class="card-body">
                    <h2 class="mb-3">Mandates</h2>

                    <div class="form-group row">
                        <div class="col-lg-8">
                            <form id="frmCheckout" method="post" action="{{ route('mandate_setup') }}">
                                @csrf
                                <input type="hidden" name="spk" id="spk" value="{{ $spk }}" />

                                @if($mandate && $mandate->stripe_status == 'active')
                                <p>ACTIVE: Your weekly invoices will be collected by Direct Debit from your account ending: ****{{ $mandate->bank_last_four_digits }}</p>
                                <button type="submit" class="btn btn-primary">Update Mandate</button>
                                @elseif($mandate && $mandate->mandate_id && !$mandate->stripe_status)
                                <p>PROCESSING: Your direct debit details have been submitted and we are waiting for your bank to approve. When approved this message will update to ACTIVE. Until then please continue to make your invoice payments manually as usual.</p>
                                @else
                                @if($mandate && $mandate->stripe_status=='inactive')
                                <p class="text-danger">The Direct Debit mandate you set up was rejected by your bank. Please check the details with your bank and then try again.</p>
                                @endif
                                <p>Please click the button below to set up your Direct Debit through our trusted payment provider Stripe. Any invoice payments you make will be protected by the <a href="https://stripe.com/legal/bacs-direct-debit-guarantee" target="_blank" class="text-primary">Direct Debit Guarantee</a>.</p>
                                <button type="submit" class="btn btn-primary">Create a Mandate</button>
                                @endif
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    @endsection

    @push('footerJs')
    <script>
        $('#frmCheckout').submit(function () {
            $('.loading').show();
        });
    </script>
    @endpush