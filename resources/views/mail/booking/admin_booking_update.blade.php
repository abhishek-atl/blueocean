@inject('format', 'App\Services\FormatService')

<center>
    <table width="100%" cellpadding="0" cellspacing="0">
        <tbody>
            <tr>
                <td align="left">
                    <div>
                        <img src="{{ asset('/assets/img/mail/email_confirmations_logo.jpg')}}" alt="{{ config('app.name') }}" />
                    </div>
                </td>
            </tr>
            <tr></tr>
        </tbody>
    </table>

    <p style="text-align: left"><strong>{{ $title }}</strong></p>
    <table width="100%" cellpadding="5" cellspacing="1" border="0">
        <tbody>
            <tr>
                <td align="left">
                    <p>TIME AND DATE: </p>
                </td>
                <td align="left">
                    <p>{{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$booking->appointment_start)->format('H:i a') }} on {{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$booking->appointment_start)->format('l, d F Y') }}</p>
                </td>
            </tr>
            <tr>
                <td align="left">
                    <p>SESSION: </p>
                </td>
                <td align="left">
                    @if($booking->payment && $booking->payment->payment_type=='cash')
                    <p>{{ $booking->duration + $booking->extra_duration }} Mins &pound;{{number_format($booking->cost + $booking->travel_supp, 2, '.')}} CASH @if($booking->travel_supp >0)(&pound;{{number_format($booking->cost,2,'.')}} + &pound;{{ number_format($booking->travel_supp, 2, '.')}} Travel Supplement)@endif</p>
                    @else
                    <p>{{ $booking->duration + $booking->extra_duration }} Mins &pound;{{number_format($booking->cost + $booking->travel_supp, 2, '.')}} PAID @if($booking->travel_supp >0)(&pound;{{number_format($booking->cost,2,'.')}} + &pound;{{number_format($booking->travel_supp,2,'.')}} Travel Supplement)@endif</p>
                    @endif
                </td>
            </tr>
            <tr>
                <td align="left">
                    <p>CUSTOMER NAME: </p>
                </td>
                <td align="left">
                    <p>{{$booking->name}}</p>
                </td>
            </tr>
            <tr>
                <td align="left">
                    <p>CUSTOMER PHONE: </p>
                </td>
                <td align="left">
                    <p>{{$booking->phone}}</p>
                </td>
            </tr>
            <tr>
                <td align="left">
                    <p>ADDRESS: </p>
                </td>
                <td align="left">
                    <p>@if($booking->flat_no){{ $booking->flat_no }},@endif {{ $booking->street_number }} {{ $booking->street_name }}, {{ $booking->town }}, {{ strtoupper($booking->postcode) }}</p>
                </td>
            </tr>
            <tr>
                <td align="left">
                    <p>CUSTOMER EMAIL: </p>
                </td>
                <td align="left">
                    <p>{{ $booking->email ?? 'Nothing mentioned' }}</p>
                </td>
            </tr>
            <tr>
                <td align="left">
                    <p>STYLE: </p>
                </td>
                <td align="left">
                    <p>{{ $booking->treatment->name}}</p>
                </td>
            </tr>
            <tr>
                <td align="left">
                    <p>FOCUS: </p>
                </td>
                <td align="left">
                    <p>{{ $booking->focus_areas ?? 'Nothing mentioned' }}</p>
                </td>
            </tr>
            <tr>
                <td align="left">
                    <p>CUSTOMER COMMENTS:</p>
                </td>
                <td align="left">
                    <p>{{ $booking->comments ?? 'Nothing mentioned'}}</p>
                </td>
            </tr>
            <tr>
                <td align="left">
                    <p>THERAPIST SENT:</p>
                </td>
                <td align="left">
                    <p>{{$booking->therapist->first_name}} {{$booking->therapist->last_name}}</p>
                </td>
            </tr>
            @if($booking->gift_discount_amount && $booking->gift_discount_amount > 0)
            <tr>
                <td colspan="2">
                    <hr />
                </td>
            </tr>
            <tr>
                <td align="left">GIFT CARD CODE USED:</td>
                <td align="left">{{ $booking->gift_discount_code }}</td>
            </tr>
            <tr>
                <td align="left">GIFT CARD APPLIED:</td>
                <td align="left">{{ $format->currency($booking->gift_discount_amount) }}</td>
            </tr>
            <tr>
                <td align="left">PAID ONLINE:</td>
                <td align="left">{{ $format->currency($booking->payment->amount/100) }}</td>
            </tr>
            @endif
            <tr>
                <td colspan="2">
                    <hr />
                </td>
            </tr>
            <tr>
                <td align="left">
                    <p>IP:</p>
                </td>
                <td align="left">
                    <p>{{$booking->client_ip_address}}</p>
                </td>
            </tr>
            <tr>
                <td align="left">
                    <p>SYSTEM:</p>
                </td>
                <td align="left">
                    <p>{{ Request::userAgent() }}</p>
                </td>
            </tr>
            <tr>
                <td align="left">
                    <p>BOOKING REF:</p>
                </td>
                <td align="left">
                    <p> <a href="{{ route('admin.bookings.edit',['id' => $booking->id]) }}" target="_blank" rel="noreferrer nofollow noopener">{{$booking->id}}</a></p>
                </td>
            </tr>
        </tbody>
    </table>

</center>