@extends('admin.layouts.default')

@section('content')

<div class="container-fluid">
    <div class="row py-4">
        <div class="col-md-12">
            <div class="card-style d-flex flex-wrap align-items-center justify-content-between">
                <div class="title">
                    @if(isset($booking))
                    <h2>Edit Booking</h2>
                    @else
                    <h2>Create Booking</h2>
                    @endif

                    <div class="breadcrumb-wrapper">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('admin.dashboard')}}">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="{{ route('admin.bookings.index') }}">Bookings</a>
                                </li>
                                @if(isset($booking))
                                <li class="breadcrumb-item active">Edit Booking</li>
                                @else
                                <li class="breadcrumb-item active">Add Booking</li>
                                @endif
                            </ol>
                        </nav>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.bookings.store') }}" method="post" id="storeBookingForm">

        @csrf

        @isset($booking)
        <input type="hidden" name="id" value="{{ $booking->id }}" />
        @endisset

        <div class="row">
            <!-- Client Information -->
            <div class="col-lg-4">
                <div class="card-style mb-30">
                    <h5 class="mb-3">Client Information</h5>

                    <div class="mb-3">
                        <label class="form-label required" for="phone">Phone</label>
                        <input type="text" name="phone" id="phone" class="form-control" placeholder="Phone Number" value="{{ old('phone', $booking->phone ?? '') }}" required />
                        @error('phone')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label required" for="name">Client Name</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Client Name" value="{{ old('name', $booking->name ?? '') }}" required />
                        @error('name')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="email">Email</label>
                        <input type="email" name="email" id="email" class="form-control" placeholder="client@example.com" value="{{ old('email', $booking->email ?? '') }}" />
                        @error('email')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label required" for="postcode">Postcode</label>
                        <input type="text" name="postcode" id="postcode" class="form-control" placeholder="Postcode" value="{{ old('postcode', $booking->postcode ?? '') }}" required />
                        @error('postcode')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="flat_no">Flat/Unit No</label>
                        <input type="text" name="flat_no" id="flat_no" class="form-control" placeholder="Flat/Unit Number" value="{{ old('flat_no', $booking->flat_no ?? '') }}" />
                        @error('flat_no')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label required" for="street_number">Street Number</label>
                        <input type="text" name="street_number" id="street_number" class="form-control" placeholder="Street Number" value="{{ old('street_number', $booking->street_number ?? '') }}" required />
                        @error('street_number')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="street_name">Street Name</label>
                        <input type="text" name="street_name" id="street_name" class="form-control" placeholder="Street Name" value="{{ old('street_name', $booking->street_name ?? '') }}" />
                        @error('street_name')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label required" for="town">Town/City</label>
                        <input type="text" name="town" id="town" class="form-control" placeholder="Town/City" value="{{ old('town', $booking->town ?? '') }}" required />
                        @error('town')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                </div>
            </div>

            <!-- Service Details -->
            <div class="col-lg-4">
                <div class="card-style mb-30">
                    <h5 class="mb-3">Service Details</h5>

                    <div class="mb-3">
                        <label class="form-label required" for="appointment_start">Booking Date & Time</label>
                        <input type="text" name="appointment_start" id="appointment_start" class="form-control" placeholder="Appointment starts at" value="{{ old('appointment_start', $booking ? $booking->appointment_start->format(config('custom.format.date_time')) : '') }}" required />
                        @error('appointment_start')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label required" for="duration">Duration (minutes)</label>
                        <select class="form-control" name="duration" id="duration">
                            <option value="">-- Select Duration --</option>
                            @foreach($tariffPlans as $tariffPlan)
                            <option value="{{ $tariffPlan->duration }}" @if(old('duration', $booking->duration ?? '') == $tariffPlan->duration) selected @endif>{{ $tariffPlan->duration }}</option>
                            @endforeach
                        </select>
                        @error('duration')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label required" for="therapist_id">Therapist</label>
                        <select name="therapist_id" id="therapist_id" class="form-control" required>
                            <option value="">-- Select Therapist --</option>
                            @foreach($therapists as $therapist)
                            <option value="{{ $therapist->id }}" @if(old('therapist_id', $booking->therapist_id ?? '') == $therapist->id) selected @endif>
                                {{ $therapist->first_name }} {{ $therapist->last_name }}
                            </option>
                            @endforeach
                        </select>
                        @error('therapist_id')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label required" for="treatment_id">Treatment</label>
                        <select name="treatment_id" id="treatment_id" class="form-control" required>
                            <option value="">-- Select Treatment --</option>
                            @foreach($treatments as $treatment)
                            <option value="{{ $treatment->id }}" @if(old('treatment_id', $booking->treatment_id ?? '') == $treatment->id) selected @endif>
                                {{ $treatment->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('treatment_id')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="comments">Comments</label>
                        <textarea name="comments" id="comments" class="form-control" rows="3" placeholder="Add comments...">{{ old('comments', $booking->comments ?? '') }}</textarea>
                        @error('comments')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                </div>
            </div>

            <!-- Cost Details -->
            <div class="col-lg-4">
                <div class="card-style mb-30">
                    <h5 class="mb-3">Cost Details</h5>

                    <div class="mb-3">
                        <label class="form-label required" for="amount">Amount</label>
                        <input type="number" name="amount" id="amount" class="form-control" placeholder="0.00" step="0.01" value="{{ old('amount', $booking->amount ?? '') }}" required />
                        @error('amount')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="discount_amount">Discount Amount</label>
                        <input type="number" name="discount_amount" id="discount_amount" class="form-control" placeholder="0.00" step="0.01" value="{{ old('discount_amount', $booking->discount_amount ?? '') }}" />
                        @error('discount_amount')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="travel_supp">Travel Supplement</label>
                        <input type="number" name="travel_supp" id="travel_supp" class="form-control" placeholder="0.00" step="0.01" value="{{ old('travel_supp', $booking->travel_supp ?? '') }}" />
                        @error('travel_supp')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label required" for="payable_amount">Payable Amount</label>
                        <input type="number" name="payable_amount" id="payable_amount" class="form-control" placeholder="0.00" step="0.01" value="{{ old('payable_amount', $booking->payable_amount ?? '') }}" required />
                        @error('payable_amount')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label required" for="fee_platform">Platform Fee</label>
                        <input type="number" name="fee_platform" id="fee_platform" class="form-control" placeholder="0.00" step="0.01" value="{{ old('fee_platform', $booking->fee_platform ?? '') }}" required />
                        @error('fee_platform')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label required" for="fee_therapist">Therapist Fee</label>
                        <input type="number" name="fee_therapist" id="fee_therapist" class="form-control" placeholder="0.00" step="0.01" value="{{ old('fee_therapist', $booking->fee_therapist ?? '') }}" required />
                        @error('fee_therapist')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>


                </div>

            </div>

            @include('admin.modules.common.form_action_buttons', ['cancel_url' => route('admin.bookings.index')])

        </div>
    </form>

</div>

@endsection

@push('pageScripts')

<script>
    $(document).ready(function () {

        new tempusDominus.TempusDominus(document.getElementById('appointment_start'), {
            allowInputToggle: true,
            defaultDate: undefined,
            useCurrent: false,
            localization: {
                format: date_time_format,
            },
            display: {
                components: {
                    calendar: true,
                    date: true,
                    month: true,
                    year: true,
                    decades: false,
                    clock: true,
                    hours: true,
                    minutes: true,
                    seconds: false,
                    useTwentyfourHour: false
                },
            }

        });
    });
</script>

@endpush