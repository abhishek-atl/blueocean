@extends('frontend.layouts.default')

@section('title','Massage Gift Cards for Every Occasion - TheMassageRooms')
@section('description','Give an instant gift of relaxation with a gift card from The Massage Rooms. These massage gift cards are perfect for birthdays, anniversaries, romantic weekends or pregnant partners.')

@section('content')

<section class="page-hero">
    <div class="container">
        <div class="row justify-content-center text-center">
            <div class="col-lg-8">
                <h1>Gift Card - Payment Options</h1>
            </div>
        </div>
    </div>
</section>

<section class="page-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12 content-panel">
                <p>Please select your payment method to complete the purchase of your massage gift card.</p>
                <form method="post" action="{{ route('giftsPost') }}" id="frmGift">
                    @csrf
                    <input type="hidden" name="spk" id="spk" value="{{ $spk }}" />
                    <a class="btn btn-primary btn-block btnPaymentTypeStripe mb-3 p-3">Stripe</a>
                </form>
            </div>
        </div>
    </div>
</section>


@endsection

@push('pageScripts')
<script src="https://js.stripe.com/v3/"></script>
<script>
    $('.btnPaymentTypeStripe').click(function(e) {
        e.preventDefault();
        if ($('#frmGift').valid()) {
            $('.loading').show();
            var formSerialize = $(this).serialize();
            var stripe = Stripe($('#spk').val());
            $.post("{{ route('gifts_payment_post') }}", formSerialize, function(response) {
                if (response.success) {
                    return stripe.redirectToCheckout({
                        sessionId: response.session.id
                    });
                } else {
                    return false;;
                }
            });
        }
    });
</script>

@endpush