@extends('mail.layouts.default')

@inject('format','App\Services\FormatService')

@section('content')

<center>
    <table border="0" cellpadding="0" cellspacing="0" width="80%">
        <tr>
            <td>
                <table border="0" cellpadding="10" cellspacing="10">
                    <tr>
                        <td colspan="2">
                            <h1 class="p30">Gift Card Receipt!</h1>
                            <p>
                                Hi {{ $giftCertificate->sender_name }},
                                Thank you for your recent gift card order. Please find the details of your order below:
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <hr />
                        </td>
                    </tr>
                    <tr>
                        <td width="50%" valign="top">
                            Gift Card ID<br />
                            {{ $giftCertificate->id }}
                        </td>
                        <td width="50%" valign="top" align="right">
                            Delivery Date<br />
                            {{ $format->date($giftCertificate->send_at) }}
                        </td>
                    </tr>
                    <tr>
                        <td width="50%" valign="top">
                            Gift Value<br />
                            {{ $format->currency($giftCertificate->gift_amount) }}
                        </td>
                        <td valign="top" align="right">
                            Delivered to<br />
                            {{ $giftCertificate->recipient_email }}
                        </td>
                    </tr>
                    <tr>
                        <td valign="top">
                            Message<br />
                            {{ $giftCertificate->message }}
                        </td>
                        <td valign="top" align="right">
                            Delivery method <br />
                            Via email
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <hr />
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">If you have any questions with regards to your order, please email us at <a href="#">{{ config('mail.to.admin_address') }}</a></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <hr />
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
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