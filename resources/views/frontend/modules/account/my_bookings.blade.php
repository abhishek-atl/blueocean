@extends('frontend.layouts.default')

@inject('format', 'App\Services\FormatService')

@section('title', 'Customer Dashboard | My Bookings')


@section('content')

<section class="page-hero">
    <div class="container">
        <div class="row justify-content-center text-center">
            <div class="col-lg-8">
                <h1>{{ Auth::user()->first_name }}'s Dashboard</h1>
            </div>
        </div>
    </div>
</section>

<section class="page-section">

    <div class="container">

        <div class="row">
            <div class="col-md-12">
                <p>Your saved address and contact details are:</p>
                <p>{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}<br />
                    Postcode: {{ Auth::user()->user_profile?->postcode }}<br />
                    Mobile: {{ Auth::user()->user_profile?->mobile }}<br />
                </p>
            </div>
            <div class="col-md-12 mb-3">
                <form method="post" action="{{ route('bookingPostcode') }}" id="frmPostcode">
                    @csrf
                    <input type="hidden" name="postcode" id="postcode" />
                    <input type="hidden" name="postcode_id" id="postcode_id" />
                    <input type="hidden" name="travel_sup" id="travel_sup" />
                    <input type="hidden" name="profile_postcode" id="profile_postcode" value="{{ Auth::user()->postcode }}" />
                </form>
                @if(Auth::user()->postcode)
                <input type="button" class="btn btn-primary  mr-3 btn_new_booking" value="Make a New Booking with these details">
                @endif
                <a href="{{ route('account') }}" class="btn btn-primary mt-3 mt-lg-0"> @if(Auth::user()->town)Update Your Details @else Check Your Details @endif</a>
            </div>


            @if($bookings->count() > 0)
            <div class="col-md-6">
                <h2>Your Bookings</h2>
                <div class="table-responsive">
                    <table class="table booking_detail">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Duration</th>
                                <th>Therapist</th>
                            </tr>
                            @foreach($bookings as $booking)

                            @php
                            $class = '';
                            if($booking->appointment_start > now())
                            $class = 'table-success';
                            elseif($booking->appointment_start < now() && $booking->appointment_finish > now())
                                $class = 'table-warning';
                                elseif($booking->appointment_finish < now())
                                    $class='table-danger' ;
                                    @endphp
                                    <tr class="alink {{ $class }}" data-id="{{ $booking->id}}" data-url="{{ route('booking', ['id' => $booking->id]) }}">
                                    <td>{{ $format->date($booking->appointment_start) }}</td>
                                    <td>{{ $format->time($booking->appointment_start) }}</td>
                                    <td>{{ $booking->duration + $booking->extra_duration }} mins</td>
                                    <td>{{ $booking->therapist->first_name }}</td>
                                    </tr>
                                    @endforeach
                        </thead>
                    </table>
                </div>
                <div class="col-md-12 d-flex justify-content-center">
                    {{ $bookings->onEachSide(0)->links() }}
                </div>
                @if(Request::get('type') === 'cancelled')
                <a href="{{ route('bookings') }}" class="btn btn-primary">See Successful Bookings</a>
                @endif
            </div>
            <div class="col-md-6">
                <h2>Booking Details</h2>
                <table class="table">
                    <tr>
                        <td width="40%">Date & Time</td>
                        <td id="date"></td>
                    </tr>
                    <tr>
                        <td>For</td>
                        <td id="duration"></td>
                    </tr>
                    <tr>
                        <td>Style</td>
                        <td id="style"></td>
                    </tr>
                    <tr>
                        <td>Customer Comment</td>
                        <td id="comment"></td>
                    </tr>
                    <tr>
                        <td>Booking Address</td>
                        <td id="address"></td>
                    </tr>
                    <tr>
                        <td>Booking Mobile</td>
                        <td id="mobile"></td>
                    </tr>
                    <tr>
                        <td>Treatment Price</td>
                        <td id="price"></td>
                    </tr>
                    <tr>
                        <td>Travel Supplement</td>
                        <td id="travel_supp"></td>
                    </tr>
                    <tr>
                        <td>Total Price</td>
                        <td id="total_price"></td>
                    </tr>
                    <tr>
                        <td>Therapist</td>
                        <td id="therapist"></td>
                    </tr>
                    @if(Request::get('type') !== 'cancelled')
                    <tr>
                        <td>Rate therapist</td>
                        <td id="therapist_rating">
                            <div class="rate_therapist hide-elem">
                                @foreach([
                                    'eval_punctuality' => 'Punctuality',
                                    'eval_professionalism' => 'Professionalism',
                                    'eval_communication' => 'Communication',
                                    'eval_technique' => 'Technique',
                                ] as $field => $label)
                                <div class="mb-2 therapist-rating-row">
                                    <label for="{{ $field }}" class="d-block">{{ $label }}</label>
                                    <div class="therapist-rating" data-target="#{{ $field }}"></div>
                                    <input type="hidden" name="{{ $field }}" id="{{ $field }}" />
                                </div>
                                @endforeach
                                <div class="mb-3">
                                    <label for="therapist_review_comment" class="d-block">Comment (optional)</label>
                                    <textarea class="form-control" id="therapist_review_comment" rows="3" maxlength="5000"></textarea>
                                </div>
                                <span class="rate_therapist_msg d-block mb-2"></span>
                                <a href="#" class="btn btn-primary btn_rate_therapist">Rate Therapist</a>
                            </div>
                        </td>
                    </tr>
                    @endif
                </table>
            </div>
            @else
            <div class="col-md-12">
                <p>There are no bookings saved under this account yet.</p>
                <p>As a registered user you are already eligible for our fast-track checkout,
                    rate your therapists and receive special offers and discounts based on
                    your loyalty level.</p>
                <p>Start enjoying these benefits - and an amazing massage - by booking
                    your first treatment today!</p>
            </div>
            @endif
            <div class="col-md-12">
                @if(Request::get('type') != 'cancelled' && $cancelledBookings->count() > 0)
                <a href="{{ route('bookings', ['type' => 'cancelled']) }}" class="btn btn-primary">See Cancelled Bookings</a>
                @endif
            </div>

        </div>
    </div>

</section>

@endsection

@push('pageScripts')
<script>
    $('.btn_new_booking').click(function() {
        $('.loading').show();
        let url = "{{ route('bookingPostcode') }}";
        let profilePostcode = $('#profile_postcode').val();
        $.post(url, {
            postcode: profilePostcode
        }, function(response) {
            if (response.success.success) {
                $('#postcode').val(profilePostcode);
                $('#postcode_id').val(response.success.id_postal);
                $('#travel_sup').val(response.success.supplement);
                $('#frmPostcode').submit();
            }
        }).always(function() {
            $('.loading').hide();
        });
    })

    @if($bookings->count())

    $('.btn_rate_therapist').click(function(e) {
        e.preventDefault();
        const ratingFields = [
            'eval_punctuality',
            'eval_professionalism',
            'eval_communication',
            'eval_technique'
        ];

        if (ratingFields.some(field => !$('#' + field).val())) {
            alert("Please rate punctuality, professionalism, communication, and technique from 1 (poor) to 5 (excellent).");
            return false;
        }

        $('.loading').show();
        let booking_id = $('tr.selected').attr('data-id');
        let review = {
            booking_id: booking_id,
            eval_punctuality: $('#eval_punctuality').val(),
            eval_professionalism: $('#eval_professionalism').val(),
            eval_communication: $('#eval_communication').val(),
            eval_technique: $('#eval_technique').val(),
            comment: $('#therapist_review_comment').val()
        };

        $.post("{{ route('rate_booking') }}", review, function() {
            $('.btn_rate_therapist').hide();
            $('.therapist-rating').raty('readOnly', true);
            $('#therapist_review_comment').prop('readonly', true);
            $('.rate_therapist_msg').text('Your ratings have been saved. Thank you!');
        }).fail(function(xhr) {
            const message = xhr.responseJSON && xhr.responseJSON.message
                ? xhr.responseJSON.message
                : 'Your rating could not be saved. Please try again.';
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

            let totalPrice = parseFloat(response.payable_amount) + parseFloat(response.travel_supp);
            let paymentMethod = 'Cash';
            if (response.payment.payment_type != 'cash')
                paymentMethod = 'Paid';

            $('#date').html(moment(response.appointment_start).format('dddd, DD MMMM YYYY') + ' at ' + moment(response.appointment_start).format('HH:mm'));
            $('#duration').html(response.duration + ' minutes');
            $('#style').html(response.treatment.name + ' Therapy');
            $('#comment').html(response.comments ? response.comments : '-');
            $('#address').html(response.postcode);
            $('#mobile').html(response.phone);
            $('#price').html('£' + (response.payable_amount));
            $('#travel_supp').html('£' + (response.travel_supp));
            $('#total_price').html('£' + totalPrice.toFixed(2) + ' ' + paymentMethod);
            $('#therapist').html(response.therapist.first_name);

            $('.rate_therapist').removeClass('hide-elem');
            $('.rate_therapist_msg').html('');
            $('.therapist-rating').raty('destroy');
            $('#therapist_review_comment').val('').prop('readonly', false);

            const therapistReview = response.therapist_review;
            $('.therapist-rating').each(function() {
                const target = $(this).data('target');
                const field = target.substring(1);
                $(target).val(therapistReview ? therapistReview[field] : '');
                $(this).raty({
                    target: target,
                    targetType: 'score',
                    targetKeep: true,
                    starType: 'i',
                    starOn: 'fa-solid fa-star',
                    starOff: 'fa-regular fa-star',
                    readOnly: !!therapistReview,
                    score: therapistReview ? therapistReview[field] : undefined
                });
            });

            if (!therapistReview) {
                $('.btn_rate_therapist').show();
            } else {
                $('.btn_rate_therapist').hide();
                $('#therapist_review_comment')
                    .val(therapistReview.comment || '')
                    .prop('readonly', true);
                $('.rate_therapist_msg').text('You have already reviewed this therapist.');
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
<script type="text/javascript">
    $('document').ready(function() {

    });
</script>
@endpush
