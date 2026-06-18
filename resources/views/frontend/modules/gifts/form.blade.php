@extends('frontend.layouts.default')

@section('title', 'Massage Gift Cards for London - from just GBP20 | BlueOcean')
@section('description', 'Treat someone to a home massage in London with an instant delivery gift voucher - perfect for last-minute birthday gifts or any occasion. From just GBP20.')

@section('content')
<section class="page-hero">
    <div class="container">
        <div class="row justify-content-center text-center">
            <div class="col-lg-8">
                <h1>Buy a Massage Gift Card in London</h1>
                <p>Send a thoughtful home massage voucher instantly, or schedule it ahead for birthdays, anniversaries, and last-minute gifts.</p>
            </div>
        </div>
    </div>
</section>

<section class="content-section">
    <div class="container">
        <div class="row g-4 align-items-start">
            <div class="col-lg-5">
                <aside class="content-panel gift-preview">
                    <div class="gift-preview-image">
                        <img
                            src="{{ asset('assets/img/buy-massage-gift-card.jpg') }}"
                            alt="Londoner holding a massage gift voucher"
                            title="Massage gift card: instant delivery to phone">
                    </div>

                    <div class="gift-preview-body">
                        <div class="feature-icon"><i class="fa-solid fa-gift"></i></div>
                        <h2>A calm gift, delivered by email</h2>
                        <p>Gift vouchers can be delivered instantly, or scheduled ahead if you already know the date.</p>

                        <ul class="check-list">
                            <li><i class="fa-solid fa-check"></i> Instant or scheduled delivery</li>
                            <li><i class="fa-solid fa-check"></i> Choose preset sessions or custom value</li>
                            <li><i class="fa-solid fa-check"></i> Redeemable against massage treatments</li>
                        </ul>
                    </div>
                </aside>
            </div>

            <div class="col-lg-7">
                <div class="content-panel form-panel">
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form method="post" action="{{ route('giftsPost') }}" id="frmGift">
                        @csrf

                        <div class="form-section-heading form-section-heading-first">
                            <span>Gift Voucher Options</span>
                            <h2>Choose the gift value</h2>
                        </div>

                        <div class="row g-4">
                            <div class="col-12">
                                <div class="form-field">
                                    <label class="form-label" for="voucher_id">Choose Gift Card</label>
                                    <select name="voucher_id" id="voucher_id" class="form-control">
                                        <option value="">Please Select</option>
                                        @if(isset($tariff[0]))
                                        <option value="1" data-amount="{{ $tariff[0]->amount }}" @selected(old('voucher_id')==1)>&pound;{{ $tariff[0]->amount }} - "The Classic" covers a 60 minute massage</option>
                                        @endif
                                        @if(isset($tariff[1]))
                                        <option value="2" data-amount="{{ $tariff[1]->amount }}" @selected(old('voucher_id')==2)>&pound;{{ $tariff[1]->amount }} - "The Treat" covers a 90 minute massage</option>
                                        @endif
                                        @if(isset($tariff[2]))
                                        <option value="3" data-amount="{{ $tariff[2]->amount }}" @selected(old('voucher_id')==3)>&pound;{{ $tariff[2]->amount }} - "The Couple" covers two 60 minute massages for a couple</option>
                                        @endif
                                        <option value="4" @selected(old('voucher_id')==4)>Custom Value</option>
                                    </select>
                                    @error('voucher_id')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12 gift_amount_group {{ old('voucher_id') == 4 ? '' : 'd-none' }}">
                                <div class="form-field">
                                    <label class="form-label" for="gift_amount">Please Enter a Gift Amount (&pound;)</label>
                                    <input type="text" class="form-control" id="gift_amount" name="gift_amount" value="{{ old('gift_amount') }}" placeholder="Enter gift amount">
                                    @error('gift_amount')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-section-heading">
                            <span>Delivery Details</span>
                            <h2>Recipient and sender</h2>
                        </div>

                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="form-field">
                                    <label class="form-label" for="recipient_email">Email Gift Card To</label>
                                    <input type="text" class="form-control" id="recipient_email" name="recipient_email" value="{{ old('recipient_email') }}" placeholder="Enter email for delivery">
                                    @error('recipient_email')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-field">
                                    <label class="form-label" for="sender_email">Your Email</label>
                                    <input type="text" class="form-control" id="sender_email" name="sender_email" value="{{ old('sender_email') }}" placeholder="Enter your email">
                                    @error('sender_email')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-field">
                                    <label class="form-label" for="recipient_name">Recipient's Name</label>
                                    <input type="text" class="form-control" id="recipient_name" name="recipient_name" value="{{ old('recipient_name') }}" placeholder="Recipient's name">
                                    @error('recipient_name')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-field">
                                    <label class="form-label" for="sender_name">Your Name</label>
                                    <input type="text" class="form-control" id="sender_name" name="sender_name" value="{{ old('sender_name') }}" placeholder="Enter your name">
                                    @error('sender_name')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-section-heading">
                            <span>Send Time</span>
                            <h2>Choose delivery timing</h2>
                        </div>

                        <fieldset class="form-field option-group">
                            <legend>When would you like us to send the gift voucher?</legend>
                            <div class="option-stack gift-send-options">
                                <div class="form-check">
                                    <input type="radio" id="immediately" name="sendtime" class="form-check-input" value="now" @checked(old('sendtime', 'now' )=='now' )>
                                    <label class="form-check-label" for="immediately">Immediately</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" id="later" name="sendtime" class="form-check-input" value="later" @checked(old('sendtime')=='later' )>
                                    <label class="form-check-label" for="later">Later</label>
                                </div>
                            </div>
                        </fieldset>

                        <div id="calendar_pick" data-td-target-input="nearest" data-td-target-toggle="nearest">
                            <div class="form-field send_at_group mt-4 {{ old('sendtime') == 'later' ? '' : 'd-none' }}">
                                <label class="form-label" for="send_at">Send at</label>
                                <input type="text" class="form-control" id="send_at" name="send_at" value="{{ old('send_at') }}" placeholder="dd/mm/yyyy" autocomplete="off">
                                <span class="input-group-text float-left" data-td-target="#calendar_pick" data-td-toggle="datetimepicker"><i class="fas fa-calendar"></i></span>
                                @error('send_at')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-section-heading">
                            <span>Personal Message</span>
                            <h2>Add a note</h2>
                        </div>

                        <div class="form-field">
                            <label class="form-label" for="message">Message to Recipient (optional)</label>
                            <textarea name="message" id="message" class="form-control" placeholder="Make it personal with a message they'll love!">{{ old('message') }}</textarea>
                            @error('message')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">Continue to Payment</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</section>

@endsection

@push('pageScripts')
<script>
    $(document).ready(function() {

        new tempusDominus.TempusDominus(document.getElementById('calendar_pick'), {
            allowInputToggle: true,
            defaultDate: undefined,
            useCurrent: false,
            localization: {
                format: date_format,
            },
            display: {
                components: {
                    calendar: true,
                    date: true,
                    month: true,
                    year: true,
                    decades: false,
                    clock: true,
                    hours: false,
                    minutes: false,
                    seconds: false,
                    useTwentyfourHour: undefined
                },
            }
        });

        function syncVoucherAmount() {
            if ($('#voucher_id').val() == 4) {
                $('.gift_amount_group').removeClass('d-none');
                if (!$('#gift_amount').data('old-value')) {
                    $('#gift_amount').val('');
                }
                return;
            }

            var giftAmount = $('#voucher_id').find(':selected').data('amount') || '';
            $('#gift_amount').val(giftAmount);
            $('.gift_amount_group').addClass('d-none');
        }

        $('#gift_amount').data('old-value', $('#gift_amount').val());

        $('[name="sendtime"]').on('change', function() {
            $('.send_at_group').toggleClass('d-none', this.id !== 'later');
        });

        $('#voucher_id').on('change', function() {
            $('#gift_amount').data('old-value', '');
            syncVoucherAmount();
        });

        syncVoucherAmount();
    });
</script>
@endpush