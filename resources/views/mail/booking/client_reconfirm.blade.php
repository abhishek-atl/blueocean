@inject('format', 'App\Services\FormatService')

<table cellpadding="5" cellspacing="5" width="100%" border="0" align="center" bgcolor="#e7e7e7">
    <tr align="center">
        <td colspan="2">
            <a href="{{ route('home') }}" target="_blank"><img src="{{ asset('assets/img/mail/massage_room_small_logo.png') }}" height="150"></a>
        </td>
    </tr>
    <tr align="center">
        <td colspan="2" style="padding:10px; border-top: solid 2px #dddddd; border-bottom:solid 2px #dddddd;font-size: 18px; font-weight: bold; text-transform:uppercase;">We can't wait to see you</td>
    </tr>
    <tr align="center">
        <td colspan="2">
            <table cellpadding="0" cellspacing="0" border="0" width="25%">
                <tr align="center">
                    <td><img src="{{ asset('assets/img/mail/see_you_soon.png') }}" height="150"></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="2" align="center" bgcolor="#ffffff">
            <table cellpadding="5" cellspacing="5" border="0" width="100%">
                <tr>
                    <td colspan="2" style="padding-top: 40px; padding-bottom:40px;" align="center">
                        <p>Hello {{ $booking->name }}!</p>
                        <p style="text-align: left;">We are pleased to confirm your booking as below:</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="2" align="center">
            <table cellpadding="5" cellspacing="5" border="0" width="80%">
                <td colspan="2" align="center">
                    <h2>Booking Details</h2>
                </td>
                <tr>
                    <td width="50%">Therapist:</td>
                    <td align="right">{{ $booking->therapist->first_name }}</td>
                </tr>
                <tr>
                    <td>Arriving:</td>
                    <td align="right">
                        {{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$booking->appointment_start)->format('l, d F Y') }} at
                        {{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$booking->appointment_start)->format('H:i') }}
                    </td>
                </tr>
                <tr>
                    <td>For:</td>
                    <td align="right">{{ $booking->duration + $booking->extra_duration }} minutes</td>
                </tr>
                <tr>
                    <td>To Perform:</td>
                    <td align="right">{{ $booking->treatment->name}} Therapy</td>
                </tr>
                <tr>
                    <td>Focusing On Your:</td>
                    <td align="right">{{ $booking->focus_areas ?? 'Nothing mentioned' }}</td>
                </tr>
                <tr>
                    <td>Will Bear In Mind:</td>
                    <td align="right">{{ $booking->comments ?? 'Nothing mentioned'}}</td>
                </tr>
            </table>
        </td>
    </tr>
    <tr bgcolor="#ffffff">
        <td colspan="2" align="center">
            <table cellpadding="5" cellspacing="5" border="0" width="80%">
                <tr>
                    <td colspan="2" align="center">
                        <h2>Your Details</h2>
                    </td>
                </tr>
                <tr>
                    <td width="50%">Your Name:</td>
                    <td align="right">{{ $booking->name }}</td>
                </tr>
                <tr>
                    <td>Your Address:</td>
                    <td align="right">@if($booking->flat_no){{ $booking->flat_no }},@endif {{ $booking->street_number }} {{ $booking->street_name }}, {{ $booking->town }}, {{ strtoupper($booking->postcode) }}</td>
                </tr>
                <tr>
                    <td>Your Number:</td>
                    <td align="right">{{ $booking->phone }}</td>
                </tr>
                @if($booking->discount_amount && $booking->discount_amount > 0)
                <tr>
                    <td>Standard Treatment Price:</td>
                    <td align="right">{{ $format->currency($booking->training_cost) }}</td>
                </tr>
                <tr>
                    <td>Discount Code Applied:</td>
                    <td align="right">-{{ $format->currency($booking->discount_amount) }}</td>
                </tr>
                @else
                <tr>
                    <td>Treatment Price:</td>
                    <td align="right">{{ $format->currency($booking->training_cost) }}</td>
                </tr>
                @endif
                @if($booking->extra_duration > 0)
                <tr>
                    <td>Extra Duration Price:</td>
                    <td align="right">{{ $format->currency($booking->fee_tmr_extension + $booking->fee_therapist_extension) }}</td>
                </tr>
                @endif
                <tr>
                    <td>Travel Supplement:</td>
                    <td align="right">{{ ($booking->travel_supp && $booking->travel_supp > 0) ? $format->currency($booking->travel_supp) : '£0.00' }}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">Total Price:</td>
                    <td style="font-weight: bold;" align="right">
                        {{ $format->currency($booking->cost + $booking->travel_supp) }}
                        @if($booking->payment->payment_type == 'cash')DUE IN CASH
                        @else{{ 'PAID' }}
                        @endif
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <table cellpadding="5" cellspacing="5" border="0" width="100%">
                            @if($booking->gift_discount_amount && $booking->gift_discount_amount > 0)

                            @if($booking->payment->charge_id)
                            <tr>
                                <td>Paid By Credit Card:</td>
                                <td align="right">{{ $format->currency($booking->payment->amount / 100) }}</td>
                            </tr>
                            @endif
                            <tr>
                                <td>Gift Card Code Used:</td>
                                <td align="right">{{ $booking->gift_discount_code }}</td>
                            </tr>
                            <tr>
                                <td>Gift Card Applied:</td>
                                <td align="right">{{ $format->currency($booking->gift_discount_amount) }}</td>
                            </tr>
                            <tr>
                                <td>Gift Card Balance Remaining:</td>
                                <td align="right">{{ $format->currency($booking->gift_discount_remaining_amount) }}</td>
                            </tr>
                            @endif
                        </table>
                    </td>
                </tr>

            </table>
        </td>
    </tr>
    <tr bgcolor="#e7e7e7">
        <td colspan="2" align="center" style="padding-top: 20px;">
            <p><span style="color: #ff8400; font-weight: bold;">WHAT WE DO</span></p>
            <p>Improve your health &amp; wellness through amazing treatments.</p>
            <p><span style="color: #ff8400; font-weight: bold;">HOW WE DO IT</span></p>
            <p>Our therapists come to you <span style="color: #ff8400;">→</span> It's easier for you.</p>
            <p>Our therapists do not bring a table <span style="color: #ff8400;">→</span>
                &nbsp;It's more hygienic for you <a target="_blank" href="{{ route('home',['slug' => 'massage-tables-in-mobile-therapy']) }}">(read why)</a>.</p>
            <p>Our therapists are tested professionals&nbsp;<span style="color: #ff8400;">→</span> It's better for you.</p>
            <p>
                <span style="color: #ff8400;">
                    <strong>Ts &amp; Cs
                        <br>
                    </strong>
                </span>
                <br>Access the Terms &amp; Conditions of your booking by
                <span style="color: #ff8400;">
                    <a href="https://www.themassagerooms.com/legal/legal.html" style="color: #ff8400;">clicking here</a>
                </span>
            </p>
            <img src="{{ asset('assets/img/mail/massage_room_logo.jpg') }}" width="100" height="100">
        </td>
    </tr>
</table>