@extends('frontend.layouts.default')

@inject('format','App\Services\FormatService')

@section('title','Massage Gift Cards for Every Occasion - TheMassageRooms')
@section('description','Give an instant gift of relaxation with a gift card from The Massage Rooms. These massage gift cards are perfect for birthdays, anniversaries, romantic weekends or pregnant partners.')

@section('content')
<div class="container pt50">
    <div class="row">
        <div class="col-md-12">
            <h1 class="text-primary">Gift Card Purchase</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <p>Thank you for your purchase of a massage gift card!</p>
            <table class="table">
                <tr>
                    <td>Recipient Name:</td>
                    <td>{{ $giftCertificate->recipient_name }}</td>
                </tr>
                <tr>
                    <td>Recipient Email:</td>
                    <td>{{ $giftCertificate->recipient_email }}</td>
                </tr>
                <tr>
                    <td>Gift Massage:</td>
                    <td>{{ $giftCertificate->message }}</td>
                </tr>
                <tr>
                    <td>Gift Card Value:</td>
                    <td>{{ $format->currency($giftCertificate->gift_amount) }}</td>
                </tr>
                <tr>
                    <td>From:</td>
                    <td>{{ $giftCertificate->sender_name }}</td>
                </tr>
                <tr>
                    <td>Delivery Date:</td>
                    <td>{{ $giftCertificate->send_at ? $format->date($giftCertificate->send_at, 'H:i a'). ' on '. $format->date($giftCertificate->send_at, 'd M Y') : 'Immediate' }}</td>
                </tr>
            </table>
            <p>You can print a copy for yourself using the button below.</p>
            <a href="javascript:void(0)" class="btnPrint btn btn-primary">Print Gift Card</a>
        </div>

    </div>
</div>
@endsection

@push('pageScripts')

<script>
    $('.btnPrint').click(function (event) {
        event.preventDefault();
        window.open("{{ route('gifts_payment_print', ['id' => $giftCertificate->id]) }}");
    });
</script>

@endpush