@extends('frontend.layouts.default')

@section('title', 'Massage Booking Checkout Page | TheMassageRooms')
@section('description', 'Checkout page for massage')

@section('content')

<section class="page-hero">
    <div class="container">
        <div class="row justify-content-center text-center">
            <div class="col-lg-8">
                <h1>Checkout</h1>
            </div>
        </div>
    </div>
</section>

<div class="page-section">

    <div class="container">

        <form id="frmCheckout" method="post" action="{{ route('bookingCheckoutPost') }}">
            @csrf

            <div class="row">

                <div class="d-lg-none d-md-block col-md-12">
                    <p class="font-weight-bold">BOOKING INFORMATION</p>
                    <p>Checking Out: A {{ $duration->duration }}-min {{ $treatment->name }} massage with
                        {{ $therapist->first_name }} at {{ $dateTime->format('H:i') }} on {{ $dateTime->format('D d M') }}
                    </p>
                </div>

                <div class="col-md-8">
                    <p class="fw-bold">Personal Information</p>

                    <div class="row">
                        <div class="col">
                            <label for="name" class="col-form-label">Name</label>
                            <input type="text" id="name" name="name" class="form-control autosave" placeholder="Type your name here" value="{{ $name }}">
                        </div>
                        <div class="col">
                            <label for="mobile" class="col-form-label">Mobile</label>
                            <input type="tel" id="mobile" name="mobile" class="form-control autosave" placeholder="07400123456" value="{{ $mobile }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <label for="town" class="col-form-label">Email</label>
                            <input type="text" id="email" name="email" class="form-control autosave" value="{{ $email }}" @if (Auth::user()) readonly="readonly" @endif>
                        </div>
                    </div>


                    <p class="fw-bold mt-3">Address</p>
                    <div class="row">
                        <div class="col">
                            <label for="postcode" class="col-form-label">Postcode</label>
                            <input type="text" id="postcode" name="postcode" class="form-control autosave" value="{{ $postcode }}" readonly>
                        </div>
                        <div class="col">
                            <label for="flat_no" class="col-form-label">Flat Number / Building Name / Hotel
                                Name</label>
                            <input type="text" id="flat_no" name="flat_no" class="form-control autosave" placeholder="Optional (eg. Flat 12 River Court)" value="{{ $flat_no }}">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <label for="street_number" class="col-form-label">Street Number</label>
                            <input type="text" id="street_number" name="street_number" class="form-control autosave" placeholder="eg. 10" value="{{ $street_number }}">
                        </div>
                        <div class="col">
                            <label for="street_name" class="col-form-label">Street Name</label>
                            <input type="text" id="street_name" name="street_name" class="form-control autosave" placeholder="eg. Kings Road" value="{{ $street_name }}">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <label for="town" class="col-form-label">Town</label>
                            <input type="text" id="town" name="town" class="form-control autosave" placeholder="eg. London" value="{{ $town }}">
                        </div>
                    </div>

                    {{--
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="Comment" class="col-form-label">Comment</label>
                        <textarea name="comment" id="comment" cols="30" rows="3" class="form-control" placeholder="Please state any medical conditions or other comments here"></textarea>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="discount_code" class="col-form-label">Discount code</label>
                        <div class="input-group">
                            <input type="text" name="discount_code" id="discount_code" class="form-control" placeholder="Enter your code">
                            <div class="input-group-append">
                                <button class="btn btn-outline-primary discountCode_apply" type="button">Apply</button>
                            </div>
                        </div>
                        <small class="discount_code_message"></small>
                    </div>
                </div>
                --}}

                    <div class="d-lg-none d-md-block">
                        <div class="form-group row py-0 my-0">
                            <label class="col-5 col-form-label">Cost</label>
                            <div class="col-3">
                                <input type="text" id="session_cost" name="session_cost" class="form-control-plaintext text-right" value="" readonly>
                            </div>
                        </div>
                        <div class="form-group row py-0 my-0">
                            <label class="col-5 col-form-label">Travel Cost</label>
                            <div class="col-3">
                                <input type="text" id="travel_supp" name="travel_supp" class="form-control-plaintext text-right" value="" readonly>
                            </div>
                        </div>
                        <div class="form-group row py-0 my-0">
                            <label class="col-5 col-form-label">Discount Code</label>
                            <div class="col-3">
                                <input type="text" id="discount_amount" name="discount_amount" class="form-control-plaintext text-right" value="" readonly>
                            </div>
                        </div>
                        <div class="form-group row py-0 my-0">
                            <label class="col-5 col-form-label">Gift Card</label>
                            <div class="col-3">
                                <input type="text" id="gift_voucher_amount" name="gift_voucher_amount" class="form-control-plaintext text-right" value="" readonly>
                            </div>
                        </div>
                        <div class="form-group row py-0 my-0">
                            <label class="col-5 col-form-label"><b>Total Cost</b></label>
                            <div class="col-3">
                                <input type="text" id="total_cost" name="total_cost" class="form-control-plaintext font-weight-bold text-right" value="" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="payment_method_cash" class="col-form-label">Payment Method</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment_method" id="payment_method_cash" value="cash" @if (($paymentMethod && $paymentMethod=='cash' ) || !$paymentMethod) checked="checked" @endif>
                                <label class="form-check-label" for="payment_method_cash">Cash</label>
                            </div>
                            {{--
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="payment_method" id="payment_method_cc" value="credit_card" @if ($paymentMethod && $paymentMethod=='credit_card' ) checked="checked" @endif>
                            <label class="form-check-label" for="payment_method_cc">Credit Card</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="payment_method" id="gift_voucher" value="gift_voucher" @if ($paymentMethod && $paymentMethod=='gift_voucher' ) checked="checked" @endif>
                            <label class="form-check-label" for="gift_voucher">Gift Card</label>
                        </div>
                        <div class="form-group gift_voucher_block hide-elem mt-3">
                            <div class="input-group">
                                <input type="text" name="gift_code" id="gift_code" class="form-control" placeholder="Enter your gift code">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-primary giftCode_apply" type="button">Check</button>
                                </div>
                            </div>
                            <small class="gift_code_message"></small>
                        </div>
                        --}}
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col">
                            <p class="textCash m-0 p-3">Your therapist will collect <span id="cost_massage_val"></span> in cash from you directly.</p>
                            <p class="textCreditCard bg-secondary m-0 p-3" style="display:none;">
                                <i class="fa fa-lock"></i>
                                We process all credit cards directly through <a href="https://stripe.com/gb" target="_blank" class="text-white text-dark">STRIPE</a>, a globally trusted secure
                                payment processor.
                            </p>
                            <p class="textGiftVoucher bg-secondary m-0 p-3" style="display:none;">
                                Please enter your gift card code and press "Check"
                            </p>
                        </div>
                    </div>
                    <div class="form-row m-2 ml-lg-0 text-center">
                        <small>By confirming your booking, you agree to our <a href="{{ route('terms_conditions') }}" target="_blank">Terms & Conditions</a>.</small>
                    </div>
                    <div class="form-row mt-2 d-flex justify-content-lg-start justify-content-center">
                        <button type="submit" class="btn btn-primary btnSubmit">CONFIRM</button>
                    </div>
                </div>

                <div class="col-md-4 d-none d-lg-block">
                    <p class="font-weight-bold">BOOKING INFORMATION</p>
                    <div class="form-group row">
                        <label class="col-sm-6 col-form-label" for="massage_type">Massage Type:</label>
                        <div class="col-sm-6">
                            <input type="text" id="massage_type" name="massage_type" class="form-control-plaintext" value="{{ $treatment->name }}" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-6 col-form-label" for="therapist_name">Therapist Name:</label>
                        <div class="col-sm-6">
                            <input type="text" id="therapist_name" name="therapist_name" class="form-control-plaintext" value="{{ $therapist->first_name }}" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-6 col-form-label" for="date">Date</label>
                        <div class="col-sm-6">
                            <input type="text" id="date" name="date" class="form-control-plaintext" value="{{ $dateTime->format('d F Y') }}" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-6 col-form-label" for="time">Time:</label>
                        <div class="col-sm-6">
                            <input type="text" id="time" name="time" class="form-control-plaintext" value="{{ $dateTime->format('H:i') }}" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-6 col-form-label" for="session_duration">Session Duration:</label>
                        <div class="col-sm-6">
                            <input type="text" id="session_duration" name="session_duration" class="form-control-plaintext" value="{{ $duration->duration }} minute" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-6 col-form-label" for="session_cost">Session Cost:</label>
                        <div class="col-sm-6">
                            <input type="text" id="session_cost" name="session_cost" class="form-control-plaintext" value="" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-6 col-form-label" for="travel_sup">Travel Supplement:</label>
                        <div class="col-sm-6">
                            <input type="text" id="travel_supp" name="travel_supp" class="form-control-plaintext" value="" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-6 col-form-label" for="discount_amount">Discount Amount:</label>
                        <div class="col-sm-6">
                            <input type="text" id="discount_amount" name="discount_amount" class="form-control-plaintext" value="" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-6 col-form-label" for="gift_discount_amount">Gift Card:</label>
                        <div class="col-sm-6">
                            <input type="text" id="gift_voucher_amount" name="gift_voucher_amount" class="form-control-plaintext" value="" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-6 col-form-label" for="total_cost">Total Cost:</label>
                        <div class="col-sm-6">
                            <input type="text" id="total_cost" name="total_cost" class="form-control-plaintext" value="" readonly>
                        </div>
                    </div>
                    <input type="hidden" name="spk" id="spk" value="{{ $spk }}" />
                    Click <a href="{{ route('bookingInfo') }}">here</a> if you want to make changes in booking
                    information.
                </div>
            </div>
        </form>
    </div>

</div>


<div class="modal fade" tabindex="-1" id="modal_common">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Information</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection



@push('pageCss')
<link href="{{ asset('assets/css/intlTelInput.css') }}" rel="stylesheet">
@endpush

@push('pageScripts')
<script src="https://js.stripe.com/v3/"></script>
<script src="{{ asset('assets/js/intlTelInput.js') }}"></script>

<script>
    $(document).ready(function() {

        function calcCharges() {
            var chargesRoute = "{{ route('bookingCharges') }}";
            $.post(chargesRoute, function(response) {
                if (response.result === 1) {
                    var sessionCost = '£' + parseFloat(response.data.session_cost).toFixed(2);
                    var travelSupp = '£' + parseFloat(response.data.travel_supp).toFixed(2);
                    var discountAmount = '£' + parseFloat(response.data.discount_amount).toFixed(2);
                    var giftVoucherAmount = '£' + parseFloat(response.data.gift_voucher_amount).toFixed(
                        2);
                    var totalCost = '£' + parseFloat(response.data.total_cost).toFixed(2);

                    $('[name="session_cost"]').val(sessionCost);
                    $('[name="travel_supp"]').val(travelSupp);
                    $('[name="discount_amount"]').val(discountAmount);
                    $('[name="gift_voucher_amount"]').val(giftVoucherAmount);
                    $('[name="total_cost"]').val(totalCost);
                    $('#cost_massage_val').text('£' + parseFloat(response.data.total_cost).toFixed(2));

                }
            }).fail(function(xhr, status, error) {
                if (xhr.status == 419) {
                    alert(xhr.responseJSON.message);
                    window.location.reload();
                }
            }).always(function() {
                $('.loading').hide();
            });
        }
        calcCharges();

        $('[name="payment_method"]').change(function() {
            //paymentMethodChanged();
            if ($(this).val() == 'credit_card') {
                $('.textCreditCard').show();
                $('.textCash').hide();
                $('.btnSubmit').prop('disabled', false);
                $('.textGiftVoucher').hide();
                $('.gift_voucher_block').addClass('hide-elem');
            } else if ($(this).val() == 'cash') {
                $('.textCreditCard').hide();
                $('.textCash').show();
                $('.btnSubmit').prop('disabled', false);
                $('.textGiftVoucher').hide();
                $('.gift_voucher_block').addClass('hide-elem');
            } else {
                $('.textCreditCard').hide();
                $('.textCash').hide();
                $('.btnSubmit').prop('disabled', true);
                $('.textGiftVoucher').show();
                $('.gift_voucher_block').removeClass('hide-elem');

            }
        });

    });
</script>
@endpush