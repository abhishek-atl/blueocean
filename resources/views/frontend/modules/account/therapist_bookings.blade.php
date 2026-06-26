@extends('frontend.layouts.default')

@inject('format', 'App\Services\FormatService')

@section('title', 'Therapist Dashboard | My Bookings')

@push('headCss')
<style>
    tr.alink.selected {
        cursor: pointer;
        font-weight: bold;
    }

    .alink:hover {
        cursor: pointer;
    }
</style>
@endpush

@section('content')

<div class="container pt50 mb40">
    <div class="pb-2">
        <h1 class="text-primary mb-4">Bookings</h1>
    </div>
    <div class="row">

        @if($bookings->count() > 0)
        <div class="col-md-7">

            <form method="get" class="form-inline mb-3">

                <div>
                    <input type="text" class="form-control" id="search_bookings" name="search_bookings" value="{{ Request::get('search_bookings')}}">
                </div>

                @if(Request::get('search_bookings'))
                <a href="{{ route('bookings') }}" class="btn btn-primary">Clear</a>
                @else
                <button type="submit" class="btn btn-primary">Search</button>
                @endif
            </form>

            <div class="table-responsive" v-if="items && items.length > 0">
                <table class="table table-sm">
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
                        $bgcolor = '';
                        if($booking->training_day > now())
                        $bgcolor = 'lightyellow';
                        elseif($booking->training_day < now() && $booking->training_finish > now())
                            $bgcolor = 'lightgreen';
                            elseif($booking->training_finish < now()) $bgcolor='lightgray' ; if($booking->status == "new" && $booking->cancellation_requested_at) {
                                $bgcolor='#fa9884';
                                }
                                if($booking->is_extension_paid === 0) {
                                $bgcolor='#fa9884';
                                }
                                @endphp
                                <tr class="alink" style="background-color: {{ $bgcolor }};" data-id="{{ $booking->id}}" data-url="{{ route('booking', ['id' => $booking->id]) }}">
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
                    <td>Focus</td>
                    <td id="focus_area"></td>
                </tr>
                <tr>
                    <td>Comments </td>
                    <td id="comments"></td>
                </tr>

                @if(Request::get('type') !== 'cancelled')
                <tr>
                    <td>Rated</td>
                    <td>
                        <div class="rate_client hide-elem">
                            <div id="rating" class="rating"></div>
                            <input type="text" class="form-control" name="evaluation" id="evaluation" style="opacity: 0; height:0px !important;" />
                            <span class="rate_client_msg"></span>
                            <a href="#" class="btn btn-primary btn_rate_client">Rate Customer</a>
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
                @endif
            </table>
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

@include('frontend.modules.account.therapist_bookings_cancel')
@include('frontend.modules.account.therapist_bookings_late')
@include('frontend.modules.account.therapist_bookings_extend')
@include('frontend.modules.account.therapist_bookings_other_update')

@endsection

@push('footerJs')
<script>

    @if ($bookings -> count())

        var datetime;
    $('.btn_rate_client').click(function (e) {
        e.preventDefault();
        if (!$('#evaluation').val()) {
            alert("Please select rating from 1 (poor) to 5 (excellent)");
            return false;
        }
        $('.loading').show();
        let booking_id = $('tr.selected').attr('data-id');
        let evaluation = $('#evaluation').val();
        let url = "{{ route('rate_booking') }}" + '?booking_id=' + booking_id + '&evaluation=' + evaluation;
        $.post(url, function (response) {
            $('.loading').show();
            $('.btn_rate_client').hide();
            $('.rate_client_msg').html('Your ratings has been saved. Thank You!');
        }).always(function () {
            $('.loading').hide();
        });

    });

    $('.alink').click(function () {
        $('.loading').show();
        $('.alink').removeClass('selected');
        $(this).addClass('selected');
        let url = $(this).attr('data-url');
        $.post(url, function (response) {

            let totalPrice = parseFloat(response.cost);
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
            $('#focus_area').html(response.focus_areas ? response.focus_areas : 'Nothing Mentioned');
            $('#comments').html(response.comments ? response.comments : 'Nothing Mentioned');
            $('#address').html(response.address);
            $('#mobile').html(response.phone);
            $('#price').html('£' + (response.cost));
            $('#travel_supp').html('£' + (response.travel_supp));
            $('#total_price').html('£' + totalPrice.toFixed(2) + ' ' + paymentMethod);
            $('#therapist').html(response.therapist[0].first_name);

            $('.rate_client').removeClass('hide-elem');
            $('.rate_client_msg').html('');

            if (!response.client_rating) {
                $('.btn_rate_client').show();
                $('.rating').raty({
                    path: '{{ asset("assets/img/reviews/stars") }}',
                    starOn: 'star-on.png',
                    starOff: 'star-off.png',
                    target: '#evaluation',
                    targetType: 'score',
                    targetKeep: true,
                });
            } else {
                $('.btn_rate_client').hide();
                $('.rating').raty({
                    path: '{{ asset("assets/img/reviews/stars") }}',
                    starOn: 'star-on.png',
                    starOff: 'star-off.png',
                    target: '#evaluation',
                    targetType: 'score',
                    targetKeep: true,
                    readOnly: true,
                    score: response.client_rating
                });
            }

        }).always(function () {
            $('.loading').hide();
        })
    });
    $(document).ready(function () {
        $('.alink').first().trigger('click');
    })
    @endif
</script>
<script src="{{ asset('assets/js/jquery.raty.js') }}"></script>

@endpush