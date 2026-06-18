@extends('frontend.layouts.default')

@section('content')
<div class="container pt-5">

    <div class="row">
        <div class="col-md-12">
            <h1 class="text-primary">Thank You</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <p>Your booking has been confirmed as follows.</p>
            <table class="table table-borderless">
                <tr>
                    <td>Therapist:</td>
                    <td>{{ $booking->therapist->first_name }}</td>
                </tr>
                <tr>
                    <td>Session:</td>
                    <td>{{ $booking->duration}} Minutes</td>
                </tr>
                <tr>
                    <td>Time:</td>
                    <td>
                        {{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$booking->appointment_start)->format('l, d F Y') }} at
                        {{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$booking->appointment_start)->format('H:i') }}
                    </td>
                </tr>
                <tr>
                    <td>Address:</td>
                    <td>{{ $booking->address }}</td>
                </tr>
                <tr>
                    <td>To Perform:</td>
                    <td>{{ $booking->treatment->name }} Therapy</td>
                </tr>
                {{--
                <tr>
                    <td>Price:</td>
                    <td>
                        £{{ number_format($booking->training_cost + $booking->travel_supp - $booking->discount_amount,2) }}
                        @if($booking->payment->payment_type == 'cash')DUE IN CASH @endif
                        @if($booking->payment->payment_type == 'stripe')PAID BY CARD @endif
                    </td>
                </tr>
                --}}
            </table>
            <p>{{ $booking->therapist->first_name }} has been passed your mobile number {{ $booking->phone }} and will text you directly before your appointment start time.</p>
        </div>

        <div class="col-md-6">
            @if(Auth::user())
            <p>You have been emailed confirmation of this booking. This booking has also been added to your Customer Dashboard. <a href="{{ route('bookingPostcode') }}">Click here to go to your Dashboard</a>. </p>
            @else
            <div class="border border-primary p-3">
            <p class="h2">Join the Club: Get Rewarded</p>
            <p>Access your Customer Dashboard now! Sign up below to unlock exclusive loyalty offers, rate therapists,
                track your full booking history, and breeze through checkout faster than ever!</p>
            @include('frontend.modules.auth.register-form', [
            'name' => $booking->name,
            'email' => $booking->email,
            'bookingId' => $booking->id
            ])
            </div>
            @endif
        </div>
    </div>
</div>
@endsection