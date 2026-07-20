@extends('frontend.layouts.default')

@section('title')
Massage Booking Checkout Page | {{ config('app.name') }}
@endsection

@section('description')
Checkout page for massage
@endsection


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
        <div class="row">

            <div class="col-lg-8">
                <div class="content-panel">


                    <form id="frmCheckout" method="post" action="{{ route('bookingCheckoutPost') }}">
                        @csrf

                        <h2>Personal Information</h2>

                        <div class="row g-4 mb-4">
                            <div class="col-md-6">
                                <label class="form-label" for="name">Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ $name }}" placeholder="Type your name here">
                                @error('name')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="mobile">Mobile</label>
                                <input type="text" class="form-control" id="mobile" name="mobile" value="{{ $mobile }}" placeholder="eg. 07400123456">
                                @error('mobile')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            @if (Auth::user())
                            <div class="col-md-6">
                                <label class="form-label" for="email">Email</label>
                                <input type="text" class="form-control" id="email" name="email" value="{{ $email }}" @if (Auth::user()) readonly="readonly" @endif placeholder="eg. 07400123456">
                                @error('mobile')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            @endauth
                            <div class="col-md-6">
                                <label class="form-label" for="postcode">Postcode</label>
                                <input type="text" class="form-control" id="postcode" name="postcode" value="{{ $postcode }}" readonl>
                                @error('postcode')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="flat_no">Flat Number/Hotel</label>
                                <input type="text" id="flat_no" name="flat_no" class="form-control" placeholder="Optional (eg. Flat 12 River Court)" value="{{ $flat_no }}">
                                @error('flat_no')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="street_number">Street Number</label>
                                <input type="text" id="street_number" name="street_number" class="form-control" placeholder="eg. 10" value="{{ $street_number }}">
                                @error('street_number')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="street_name">Street Name</label>
                                <input type="text" id="street_name" name="street_name" class="form-control" placeholder="eg. Kings Road" value="{{ $street_name }}">
                                @error('flat_no')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <label class="form-label" for="town">Town</label>
                                <input type="text" id="town" name="town" class="form-control" placeholder="eg. London" value="{{ $town }}">
                                @error('town')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <label class="form-label" for="comment">Comment</label>
                                <textarea name="comment" id="comment" cols="30" rows="3" class="form-control" placeholder="Please state any medical conditions or other comments here"></textarea>
                            </div>
                        </div>

                        <div class="row g-4 mb-4">
                            <div class="form-group col-md-6">
                                <label class="form-label" for="discount_code">Discount code</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="discount_code" name="discount_code" placeholder="Enter your code">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-primary discountCode_apply" type="button">Apply</button>
                                    </div>
                                    @error('postcode')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                    <small class="discount_code_message"></small>
                                </div>
                            </div>
                        </div>

                        <h2>Payment Method</h2>
                        <div class="row g-4 mb-4">
                            <div class="col-md-6">
                                <label for="payment_method_cash" class="col-form-label">Payment Method</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="payment_method" id="payment_method_cash" value="cash" @if (($paymentMethod && $paymentMethod=='cash' ) || !$paymentMethod) checked="checked" @endif>
                                    <label class="form-check-label" for="payment_method_cash">Cash</label>
                                </div>

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
                            </div>
                        </div>

                        <div class="form-row mt-3">
                            <div class="col">
                                <p class="textCash bg-lightblue p-3">Your therapist will collect <span id="cost_massage_val"></span> in cash from you directly.</p>
                                <p class="textCreditCard bg-lightblue p-3" style="display:none;">
                                    <i class="fa fa-lock"></i>
                                    We process all credit cards directly through <a href="https://stripe.com/gb" target="_blank" class="text-dark">STRIPE</a>, a globally trusted secure
                                    payment processor.
                                </p>
                                <p class="textGiftVoucher bg-lightblue p-3" style="display:none;">
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

                    </form>

                </div>
            </div>

            <div class="col-md-4 d-none d-lg-block">
                <div class="content-panel">
                    <h2>BOOKING INFORMATION</h2>
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


        </div>
    </div>
</div>


<div class="modal fade" tabindex="-1" id="modal_common">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Information</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection



@push('pageCss')
<style>
    .iti {
        display: block !important;
    }
</style>

<link href="{{ asset('assets/css/intlTelInput.css') }}" rel="stylesheet">
@endpush

@push('pageScripts')
<script src="https://js.stripe.com/v3/"></script>
<script src="{{ asset('assets/js/intlTelInput.js') }}"></script>

<script>
    $(document).ready(function() {

        var input = document.querySelector("#mobile");
        // initialise plugin
        var iti = intlTelInput(input, {
            preferredCountries: ['gb', 'us'],
            utilsScript: "{{ asset('assets/js/utils.js') }}",
            initialCountry: "gb",
        });

        function paymentMethodChanged() {
            $('.loading').show();
            let paymentMethod = $('[name="payment_method"]:checked').val();
            let paymentMethodChangedRoute = "{{ route('updatePaymentMethod') }}?payment_method=" +
                paymentMethod;
            $.post(paymentMethodChangedRoute, function(response) {
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

                    $('#gift_code').val('');
                    $('.gift_code_message').html('');

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
            paymentMethodChanged();
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

        $('.discountCode_apply').click(function() {
            if (!$('#discount_code').val().trim()) {
                return;
            }
            var promocode = $('#discount_code').val();
            var tariff = "{{ session('booking.duration') }}";
            var date = "{{ $dateTime->format('d-m-Y H:i:s') }}";
            $.post("{{ route('checkPromocode') }}", {
                'promocode': promocode,
                'tariff': tariff,
                'date': date
            }).fail(function(xhr, status, error) {
                if (xhr.status == 419) {
                    alert(xhr.responseJSON.message);
                    window.location.reload();
                }
            }).done(function(data) {
                if (data.success) {
                    calcCharges();
                    let discountAmount = data.discountAmount;
                    $('.discount_code_message').addClass('text-success');
                    $('.discount_code_message').removeClass('text-danger');
                    $('.discount_code_message').removeClass('hide-elem');
                    $('.discount_code_message').html('Discount code applied successfully for ' +
                        '£' + discountAmount.toFixed(2));
                } else {
                    $('.discount_code_message').addClass('text-danger');
                    $('.discount_code_message').removeClass('text-success');
                    $('.discount_code_message').removeClass('hide-elem');
                    $('.discount_code_message').html(data.message);
                }
            });
        })

        $('.giftCode_apply').click(function() {
            if (!$('#gift_code').val().trim()) {
                return;
            }
            var giftcode = $('#gift_code').val();
            $.post("{{ route('checkGiftcode') }}", {
                'giftcode': giftcode
            }).done(function(data) {
                let totalCost = $('#total_cost').val();
                if (data.success) {
                    calcCharges();
                    $('.btnSubmit').prop('disabled', false);
                    $('.gift_code_message').addClass('text-success');
                    $('.gift_code_message').removeClass('text-danger');
                    $('.gift_code_message').removeClass('hide-elem');
                    $('.gift_code_message').html(data.message);

                } else {
                    $('.gift_code_message').addClass('text-danger');
                    $('.gift_code_message').removeClass('text-success');
                    $('.gift_code_message').removeClass('hide-elem');
                    $('.gift_code_message').html(data.message);
                }
            }).fail(function(xhr, status, error) {
                if (xhr.status == 419) {
                    alert(xhr.responseJSON.message);
                    window.location.reload();
                }
            });
        });

        function createStripeSession() {
            var stripe = Stripe($('#spk').val());
            $.post("{{ route('bookingCreateStripeSession') }}", function(response) {
                if (response.success) {
                    return stripe.redirectToCheckout({
                        sessionId: response.session.id
                    });
                } else {
                    return false;;
                }
            }).fail(function(xhr, status, error) {
                if (xhr.status == 419) {
                    alert(xhr.responseJSON.message);
                    window.location.reload();
                }
            });
        }

        function validate() {
            let msg = '';
            let mail_pattern = /^([a-z0-9_\.-])+@[a-z0-9-]+\.([a-z]{2,6}\.)?[a-z]{2,6}$/i;

            if (!$('#name').val().length) {
                msg += 'Please enter your name<br/>';
            }
            if (!$('#mobile').val().length) {
                msg += 'Please enter your mobile number<br/>';

            }
            if (!iti.isValidNumber()) {
                msg += 'Your mobile number is invalid<br/>';
            }
            if (!$('#street_number').val().length) {
                msg += 'Please enter your street number<br/>';
            }
            if (!$('#street_name').val().length) {
                msg += 'Please enter your street name<br/>';
            }
            if (!$('#town').val().length) {
                msg += 'Please enter your town<br/>';
            }
            if (!$('#postcode').val().length) {
                msg += 'Please enter your postcode<br/>';
            }
            if (msg) {
                $('#modal_common .modal-body').empty();
                $('#modal_common .modal-body').html(msg);
                $('#modal_common').modal('show');
                return false;
            }

            $('.btnSubmit').prop('disabled', true);
            $('.btnSubmit').html('Please wait..');
            return true;
        }

        $('#frmCheckout').submit(function(e) {
            e.preventDefault();
            var number = iti.getNumber();
            $('#mobile').val(number);
            if (validate()) {
                $('.loading').show();
                var formSerialize = $(this).serialize();
                $.post("{{ route('bookingCheckoutPost') }}", formSerialize, function(response) {
                    if (response.result === 0) {
                        alert(response.message);
                        window.location.replace("{{ route('bookingPostcode') }}");
                        return false;
                    }
                    if (response.payment.payment_type == 'stripe' && response.payment.status ==
                        'pending') {
                        createStripeSession();
                    } else if (response.payment.payment_type == 'gift_voucher' && response
                        .payment.status == 'pending') {
                        createStripeSession();
                    } else {
                        window.location.replace("{{ route('bookingSuccess') }}");
                    }
                }).fail(function(xhr, status, error) {
                    if (xhr.status == 419) {
                        alert(xhr.responseJSON.message);
                        window.location.reload();
                    }
                }).always(function() {

                });
            }
        });




    });
</script>
@endpush