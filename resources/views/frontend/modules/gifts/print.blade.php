@extends('mail.layouts.default')

@inject('format','App\Services\FormatService')

@section('content')

<center>
    <table border="0" cellpadding="0" cellspacing="0" width="70%">
        <tr>
            <td>
                <table border="0" cellpadding="0" cellspacing="0" class="table-centered container">
                    <tr>
                        <td>
                            <h1 class="p30">You've got a gift!</h1>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p class="strong-text padding-default">Congratulations! {{ $giftCertificate->sender_name }} has sent you a {{ $format->currency($giftCertificate->gift_amount) }} gift card for a massage session with us.</p>
                            <p class="strong-text padding-default">Choose from any of our on-demand wellness services delivered to your home.</p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <hr />
                        </td>
                    </tr>

                    @if($giftCertificate->message)
                    <tr>
                        <td>
                            <p class="strong-text padding-default">Note from {{ $giftCertificate->sender_name }}</p>
                            <p class="strong-text padding-default">{{ $giftCertificate->message }}</p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <hr />
                        </td>
                    </tr>
                    @endif
                    <tr>
                        <td>
                            <p class="strong-text padding-default">Your Gift Card Amount<br />
                                {{ $format->currency($giftCertificate->gift_amount) }}
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p class="strong-text padding-default">Name: {{ $giftCertificate->recipient_name }}<br />
                                Expiry: {{ $format->date($giftCertificate->expire_at) }}</p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p class="strong-text padding-default">Code: <b>{{ $giftCertificate->gift_code }}</b></p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <table border="0" cellpadding="0" cellspacing="0" class="table-centered pt15">
                    <tr>
                        <td>
                            <p>Simply redeem your gift card at <a href="{{ route('home') }}">TheMassageRooms.com</a> and enter your gfit card code at checkout to redeem.</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <table border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
                            <p>Terms and Conditions</p>
                            <ol class="small-font">
                                <li>Gift Cards can be used to purchase any treatment available at time of use.</li>
                                <li>If the treatment purchased total less than the value of the Gift Card, any balance will remain on the gift card and will be redeemable against future bookings place within the 12-month gift card redemption period.</li>
                                <li>Change in the form of currency or credits or credit/debit cards cannot be provided. Gift Cards cannot be exchanged for cash.</li>
                                <li>The Gift Card will expire on {{ $format->date($giftCertificate->expire_at) }}.</li>
                            </ol>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

</center>
@endsection
<script>
    window.print();
</script>