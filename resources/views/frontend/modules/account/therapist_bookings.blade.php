@extends('frontend.layouts.default')

@inject('format', 'App\Services\FormatService')

@section('title', 'Therapist Dashboard | My Bookings')

@section('content')


<section class="page-hero">
    <div class="container">
        <div class="row justify-content-center text-center">
            <div class="col-lg-8">
                <h1>Bookings</h1>
            </div>
        </div>
    </div>
</section>

<section class="page-section">

    <div class="container">


        <div class="row g-3">

            @if($bookings->count() > 0)
            <div class="col-md-7">

                <form method="get" class="form-inline mb-3">
                    <div class="row">
                        <div class="col-8">
                            <input type="text" class="form-control" id="search_bookings" name="search_bookings" value="{{ Request::get('search_bookings')}}">
                        </div>
                        <div class="col-4">
                            @if(Request::get('search_bookings'))
                            <a href="{{ route('bookings') }}" class="btn btn-primary">Clear</a>
                            @else
                            <button type="submit" class="btn btn-primary">Search</button>
                            @endif
                        </div>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table booking_detail">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Client</th>
                                <th>Mobile</th>
                                <th>Postcode</th>
                            </tr>
                            @foreach($bookings as $booking)
                            @php
                            $class = '';
                            if($booking->appointment_start > now())
                            $class = 'table-success';
                            elseif($booking->training_day < now() && $booking->training_finish > now())
                                $class = 'table-warning';
                                elseif($booking->training_finish < now())
                                    $class='table-danger' ;
                                    if($booking->status == "new" && $booking->cancellation_requested_at) {
                                    $class='table-danger' ;
                                    }
                                    if($booking->is_extension_paid === 0) {
                                    $class='table-danger' ;
                                    }
                                    @endphp
                                    <tr class="alink {{ $class }}" data-id="{{ $booking->id}}" data-url="{{ route('booking', ['id' => $booking->id]) }}">
                                        <td>{{ $format->date($booking->training_day, 'd/m/y') }}</td>
                                        <td>{{ $format->time($booking->training_day) }}</td>
                                        <td>{{ $booking->name }}</td>
                                        <td>{{ $booking->phone }}</td>
                                        <td>{{ $booking->postcode }}</td>
                                    </tr>
                                    @endforeach
                        </thead>
                    </table>
                </div>
                <div class="col-md-12 d-flex justify-content-center">
                    {{ $bookings->onEachSide(0)->links() }}
                </div>
                @if(Request::get('type') === 'cancelled')
                <div class="text-center text-lg-left my-3">
                    <a href="{{ route('bookings',['search_bookings' => Request::get('search_bookings')]) }}" class="btn btn-primary">See Successful Bookings</a>
                </div>
                @endif
                @if(Request::get('type') != 'cancelled' && $cancelledBookings->count() > 0)
                <div class="text-center text-lg-left my-3">
                    <a href="{{ route('bookings', ['type' => 'cancelled', 'search_bookings' => Request::get('search_bookings')]) }}" class="btn btn-primary">See Cancelled Bookings</a>
                </div>
                @endif
            </div>

            <div class="col-md-5">
                <h2>Booking Details</h2>
                <table class="table">
                    <tr>
                        <td width="40%">Date</td>
                        <td id="date"></td>
                    </tr>
                    <tr>
                        <td>Time</td>
                        <td id="time"></td>
                    </tr>
                    <tr>
                        <td>Session</td>
                        <td id="duration"></td>
                    </tr>
                    <tr>
                        <td>Price</td>
                        <td id="total_price"></td>
                    </tr>
                    <tr>
                        <td>Name</td>
                        <td id="name"></td>
                    </tr>
                    <tr>
                        <td>Mobile</td>
                        <td id="mobile"></td>
                    </tr>
                    <tr>
                        <td>Address</td>
                        <td id="address"></td>
                    </tr>
                    <tr>
                        <td>Postcode</td>
                        <td id="postcode"></td>
                    </tr>
                    <tr>
                        <td>Style</td>
                        <td id="style"></td>
                    </tr>
                    <tr>
                        <td>Comments </td>
                        <td id="comments"></td>
                    </tr>
                </table>

                @if(Request::get('type') !== 'cancelled')
                <table class="table">
                    <tr>
                        <td>Rate client</td>
                        <td>
                            <div class="rate_client hide-elem">
                                @foreach([
                                    'eval_respectful_behaviour' => 'Respectful behaviour',
                                    'eval_communication' => 'Communication',
                                    'eval_booking_information_accuracy' => 'Accuracy of booking information',
                                    'eval_treatment_space_suitability' => 'Suitability of treatment space',
                                ] as $field => $label)
                                <div class="mb-2 client-rating-row">
                                    <label for="{{ $field }}" class="d-block">{{ $label }}</label>
                                    <div class="client-rating" data-target="#{{ $field }}"></div>
                                    <input type="hidden" name="{{ $field }}" id="{{ $field }}" />
                                </div>
                                @endforeach

                                <fieldset class="mb-2">
                                    <legend class="fs-6 mb-1">Did you feel safe?</legend>
                                    <label class="me-3"><input type="radio" name="felt_safe" value="1"> Yes</label>
                                    <label><input type="radio" name="felt_safe" value="0"> No</label>
                                </fieldset>

                                <fieldset class="mb-2">
                                    <legend class="fs-6 mb-1">Would you accept another booking from this client?</legend>
                                    <label class="me-3"><input type="radio" name="accept_future_booking" value="1"> Yes</label>
                                    <label><input type="radio" name="accept_future_booking" value="0"> No</label>
                                </fieldset>

                                <div class="mb-3">
                                    <label for="client_review_comment" class="d-block">Private comment (optional)</label>
                                    <textarea class="form-control" id="client_review_comment" rows="3" maxlength="5000"></textarea>
                                </div>

                                <span class="rate_client_msg d-block mb-2"></span>
                                <a href="#" class="btn btn-primary btn_rate_client">Rate Client</a>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <table class="table table-borderless">
                                <tr>
                                    <td><a href="#" class="btn btn-primary btn_late">Late</a></td>
                                    <td><a href="#" class="btn btn-primary btn_extend">Extend</a></td>
                                    <td><a href="#" class="btn btn-primary btn_cancel">Cancel</a></td>
                                </tr>
                                <tr>
                                    <td colspan="3"><a href="#" class="btn btn-primary btn_other_update">Other Update</a></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                @endif

            </div>
            @else
            <div class="col-md-12 text-center">
                <p>There are no bookings saved under this account yet.</p>
                @if(Request::get('type') != 'cancelled' && $cancelledBookings->count() > 0)
                <a href="{{ route('bookings', ['type' => 'cancelled', 'search_bookings' => Request::get('search_bookings')]) }}" class="btn btn-primary">See Cancelled Bookings</a>
                @endif
            </div>
            @endif

        </div>
    </div>

</section>

@include('frontend.modules.account.therapist_bookings_cancel')
@include('frontend.modules.account.therapist_bookings_late')
@include('frontend.modules.account.therapist_bookings_extend')
@include('frontend.modules.account.therapist_bookings_other_update')

@endsection

@push('pageScripts')
<script>
    @if($bookings->count())

    var datetime;
    $('.btn_rate_client').click(function(e) {
        e.preventDefault();
        const ratingFields = [
            'eval_respectful_behaviour',
            'eval_communication',
            'eval_booking_information_accuracy',
            'eval_treatment_space_suitability'
        ];
        const feltSafe = $('input[name="felt_safe"]:checked').val();
        const acceptFutureBooking = $('input[name="accept_future_booking"]:checked').val();

        if (ratingFields.some(field => !$('#' + field).val())) {
            alert("Please complete all four client ratings from 1 (poor) to 5 (excellent).");
            return false;
        }

        if (typeof feltSafe === 'undefined' || typeof acceptFutureBooking === 'undefined') {
            alert("Please answer both Yes/No questions.");
            return false;
        }

        $('.loading').show();
        let booking_id = $('tr.selected').attr('data-id');
        let review = {
            booking_id: booking_id,
            eval_respectful_behaviour: $('#eval_respectful_behaviour').val(),
            eval_communication: $('#eval_communication').val(),
            eval_booking_information_accuracy: $('#eval_booking_information_accuracy').val(),
            eval_treatment_space_suitability: $('#eval_treatment_space_suitability').val(),
            felt_safe: feltSafe,
            accept_future_booking: acceptFutureBooking,
            comment: $('#client_review_comment').val()
        };

        $.post("{{ route('rate_booking') }}", review, function() {
            $('.btn_rate_client').hide();
            $('.client-rating').raty('readOnly', true);
            $('input[name="felt_safe"], input[name="accept_future_booking"]').prop('disabled', true);
            $('#client_review_comment').prop('readonly', true);
            $('.rate_client_msg').text('Your private client evaluation has been saved.');
        }).fail(function(xhr) {
            const message = xhr.responseJSON && xhr.responseJSON.message
                ? xhr.responseJSON.message
                : 'The client evaluation could not be saved. Please try again.';
            alert(message);
        }).always(function() {
            $('.loading').hide();
        });

    });

    $('.alink').click(function() {
        $('.loading').show();
        $('.alink').removeClass('selected');
        $(this).addClass('selected');
        let url = $(this).attr('data-url');
        $.post(url, function(response) {

            let totalPrice = parseFloat(response.payable_amount);
            if (response.travel_supp)
                totalPrice += parseFloat(response.travel_supp);
            let paymentMethod = 'Cash';
            if (response.payment.payment_type != 'cash')
                paymentMethod = 'Paid';

            datetime = response.training_day;
            $('#date').html(moment(response.training_day).format('dddd, DD MMMM YYYY'));
            $('#time').html(moment(response.training_day).format('HH:mm'));
            $('#duration').html(response.duration + ' minutes');
            $('#postcode').html(response.postcode);
            $('#style').html(response.treatment.name + ' Therapy');
            $('#name').html(response.name);
            $('#comments').html(response.comments ? response.comments : '-');
            $('#address').html(response.flat_no);
            $('#mobile').html(response.phone);
            $('#price').html('£' + (response.payable_amount));
            $('#travel_supp').html('£' + (response.travel_supp));
            $('#total_price').html('£' + totalPrice.toFixed(2) + ' ' + paymentMethod);
            $('#therapist').html(response.therapist.first_name);

            $('.rate_client_msg').html('');
            $('.client-rating').raty('destroy');
            $('input[name="felt_safe"], input[name="accept_future_booking"]')
                .prop('checked', false)
                .prop('disabled', false);
            $('#client_review_comment').val('').prop('readonly', false);

            if (!response.user_id) {
                $('.rate_client').addClass('hide-elem');
                return;
            }

            $('.rate_client').removeClass('hide-elem');
            const clientReview = response.client_review;

            $('.client-rating').each(function() {
                const target = $(this).data('target');
                const field = target.substring(1);
                $(target).val(clientReview ? clientReview[field] : '');
                $(this).raty({
                    target: target,
                    targetType: 'score',
                    targetKeep: true,
                    starType: 'i',
                    starOn: 'fa-solid fa-star',
                    starOff: 'fa-regular fa-star',
                    readOnly: !!clientReview,
                    score: clientReview ? clientReview[field] : undefined
                });
            });

            if (!clientReview) {
                $('.btn_rate_client').show();
            } else {
                $('.btn_rate_client').hide();
                $('input[name="felt_safe"][value="' + Number(clientReview.felt_safe) + '"]').prop('checked', true);
                $('input[name="accept_future_booking"][value="' + Number(clientReview.accept_future_booking) + '"]').prop('checked', true);
                $('input[name="felt_safe"], input[name="accept_future_booking"]').prop('disabled', true);
                $('#client_review_comment')
                    .val(clientReview.comment || '')
                    .prop('readonly', true);
                $('.rate_client_msg').text('You have already evaluated this client.');
            }

        }).always(function() {
            $('.loading').hide();
        })
    });

    $(document).ready(function() {
        $('.alink').first().trigger('click');
    })

    @endif
</script>
<script src="{{ asset('assets/js/jquery.raty.js') }}"></script>

@endpush
