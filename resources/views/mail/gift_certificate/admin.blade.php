@inject('format','App\Services\FormatService')

<center>
    <table border="0" cellpadding="5" cellspacing="5" width="100%">
        <tr>
            <td colspan="2">
                <p>Click <a href="{{ route('admin.gift_certificates.edit', ['id' => $giftCertificate->id]) }}">here</a> for details</p>
            </td>
        </tr>
        <tr>
            <td>Buyer Name</td>
            <td>{{ $giftCertificate->sender_name }}</td>
        </tr>
        <tr>
            <td>Buyer Email</td>
            <td>{{ $giftCertificate->sender_email }}</td>
        </tr>
        <tr>
            <td>Value Purchased</td>
            <td>{{ $format->currency($giftCertificate->gift_amount) }}</td>
        </tr>
        <tr>
            <td>Purchase method</td>
            <td>STRIPE</td>
        </tr>
        <tr>
            <td>Recipient Name</td>
            <td>{{ $giftCertificate->recipient_name }}</td>
        </tr>
        <tr>
            <td>Recipient Email</td>
            <td>{{ $giftCertificate->recipient_email }}</td>
        </tr>
        <tr>
            <td>Personal Message</td>
            <td>{{ $giftCertificate->message }}</td>
        </tr>
        <tr>
            <td>Delivery Date</td>
            <td>
                @if($giftCertificate->send_at)
                {{ $format->date($giftCertificate->send_at) }}
                @else
                {{ $format->date($giftCertificate->created_at) }}
                @endif
            </td>
        </tr>
        <tr>
            <td>Gift Card Code</td>
            <td>{{ $giftCertificate->gift_code }}</td>
        </tr>
        <tr>
            <td>Gift Card Balance</td>
            <td>{{ $format->currency($giftCertificate->remaining_amount) }}</td>
        </tr>

        <tr>
            <td width="20%">Purchase Date</td>
            <td>{{ $format->date($giftCertificate->created_at) }}</td>
        </tr>

        <tr>
            <td>Expiry Date</td>
            <td>{{ $format->date($giftCertificate->expire_at) }}</td>
        </tr>

    </table>

</center>