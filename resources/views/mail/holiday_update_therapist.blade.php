@inject('format', 'App\Services\FormatService')

<center>
    <table width="100%" cellpadding="0" cellspacing="0">
        <tbody>
            <tr>
                <td align="left">
                    <div>
                        <img src="{{ asset('assets/img/mail/email_confirmations_logo.jpg') }}">
                    </div>
                </td>
            </tr>
            <tr></tr>
        </tbody>
    </table>
    <p style="text-align: left;">Dear {{ $holiday->therapist->first_name }} {{ $holiday->therapist->last_name }}</p>
    
    @if($action == 'add')
    <p style="text-align: left;">We confirm your time off has now been processed in accordance with your request, details below:</p>
    <p style="text-align: left;"><b>TIME OFF</b></p>
    @else
    <p style="text-align: left;">We confirm your cancellation of time off in accordance with your request, details below:</p>
    <p style="text-align: left;"><b>CANCELLATION OF TIME OFF</b></p>
    @endif
    <p style="text-align: left;">Starts: {{ $format->date($holiday->start_date) }} {{$format->time($holiday->start_date)}}</p>
    <p style="text-align: left;">Ends: {{ $format->date($holiday->end_date) }} {{ $format->time($holiday->end_date)}}</p>
    <br />
    <table width="100%" cellpadding="0" cellspacing="0">
        <tbody>
            <tr>
                <td align="left">
                    <p> Please let us know if you wish to make any amendments to this. </p>
                    <p> Best wishes, </p>
                    <p> www.TheMassageRooms.com </p>
                </td>
            </tr>
            <tr></tr>
        </tbody>
    </table>
</center>