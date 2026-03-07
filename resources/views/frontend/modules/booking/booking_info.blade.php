@extends('frontend.layouts.default')

@section('content')

<form name="frmMassageInfo" method="post" action="{{ route('bookingInfoPost') }}">
    @csrf
    <input type="hidden" id="date" name="date" value="@if(session('booking.date')){{ session('booking.date') }}@endif">
    <input type="hidden" id="time" name="time" value="@if(session('booking.time')){{ session('booking.time') }}@endif">
    <input type="hidden" id="asap" name="asap" value="@if(session('booking.asap')){{ session('booking.asap') }}@endif">
    <input type="hidden" id="therapist_id" name="therapist_id" value="@if(session('booking.therapist_id')){{ session('booking.therapist_id') }}@endif">

    <div class="container">

        <div class="row duration-block style-block">
            <div class="col-md-2">
                <label for="duration" class="form-label font-weight-bold">Postcode</label>
                <input type="text" class="form-control" value="{{ session('booking.postcode') }}" readonly>
                <a href="{{ route('bookingPostcode') }}">Change</a>
            </div>
            <div class="col-md-2 mt-lg-0 mt-3">
                {{ session('booking.duration') }}
                <label for="duration" class="form-label font-weight-bold">Duration</label>
                <select class="form-control" id="duration" name="duration">
                    @foreach ($durations as $duration)
                    @php $class= ''; @endphp
                    @if (session('booking.duration') == $duration->id)
                    @php $class = 'selected'; @endphp
                    @endif
                    <option value="{{ $duration->id }}" data-amount="£{{ number_format($duration->amount, 2) }}" {{ $class }}>
                        {{ $duration->duration }} minutes</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 mt-lg-0 mt-3">
                <label for="duration_amount" class="form-label font-weight-bold">Amount</label>
                <input type="text" id="duration_amount" class="form-control" value="" readonly>
            </div>
            <div class="col-md-3 mt-lg-0 mt-3">
                <label for="treatment" class="form-label font-weight-bold">Style</label>
                <select class="form-control" id="treatment" name="treatment">
                    @foreach ($treatments as $treatment)
                    @php $class= ''; @endphp
                    @if (session('booking.treatment') == $treatment->id)
                    @php $class = 'selected'; @endphp
                    @endif
                    <option value="{{ $treatment->id }}" {{ $class }}>{{ $treatment->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row mt-3 date-block">
            <div class="col-md-12">
                <label class="form-label font-weight-bold">Select Date</label>
                <span id="days_update"></span>
            </div>
        </div>

        <div class="row mt-3 time-block">
            <div class="col-md-12">
                <label class="form-label font-weight-bold">Select Time</label>
                <span id="time_update"></span>
            </div>
        </div>

        <div class="row mt-3 therapists-block">
            <div class="col-md-12">
                <label class="form-label font-weight-bold">Choose Therapist</label>
                <div class="therapist-diary hide-elem">
                    <a href="javascript:resetDiary()">
                        <div class="alert alert-warning"></div>
                    </a>
                </div>
            </div>
            <div class="col-md-12">
                <div id="therapists-update"></div>
            </div>
        </div>

    </div>
</form>
@endsection


@push('pageScripts')
<script>

    let routeDays = "{{ route('getDays') }}";
    let routeTime = "{{ route('getTime') }}";
    let routeCheckPostal = "{{ route('checkPostcode') }}";

    $('#duration_amount').val($('#duration').find(':selected').data('amount'));

    // events
    $('#duration').change(function () {
        $('#duration_amount').val($('#duration').find(':selected').data('amount'));
    });

    $(document).on("click", '.calendar_date', function (event) {
        let selectedDate = $(this);
        $('.calendar_date').removeClass('active');
        selectedDate.addClass('active');
        $('#asap').val('no');
        let date = selectedDate.data('date');
        $('#date').val(date);
        $('#time').val("");
        if ($('#therapist_id').val()) {
            loadTime().then(function () {
                getTimeTherapist().then(function () {
                    scrollToNextSelection('date-block');
                })
            })
        } else {
            loadTime().then(function () {
                getFreeTherapists().then(function () {
                    scrollToNextSelection('date-block');
                })
            })
        }
    });

    $(document).on("click", '.calendar_time', function (event) {
        if (!$('#date').val()) {
            $('#modal_common .modal-body').empty();
            $('#modal_common .modal-body').append('Please select a date first');
            $('#modal_common').modal('show');
            return false;
        }
        let selectedTime = $(this);
        $('.calendar_time').removeClass('active');
        selectedTime.addClass('active');
        $('#asap').val('no');
        $('#time').val(selectedTime.data('time'));
        if ($('#therapist_id').val()) {
            scrollToNextSelection('focus-image-block');
        } else {
            getFreeTherapists().then(function () {
                scrollToNextSelection('time-block');
            });
        }
    });

    function loadDays() {
        return new Promise(function (resolve, reject) {
            $('.loading').show();
            $.post(routeDays, function (response) {
                $('#days_update').empty();
                $('#days_update').append(response.view);
                resolve();
            }).fail(function (xhr, status, error) {
                if (xhr.status == 419) {
                    alert(xhr.responseJSON.message);
                    window.location.reload();
                }
            }).always(function () {
                initOwlOnDate();
                if ($('#date').val()) {
                    let selector = $("input[data-date='" + $('#date').val() + "']");
                    selector.addClass('active');
                }
                $('.mmn-block').removeClass('hide-elem');
                $('.loading').hide();
            });
        });
    }

    function loadTime() {
        return new Promise(function (resolve, reject) {
            let date = $('#date').val();
            let id = $('#therapist_id').val();
            let duration = $('#duration').val();
            $('.loading').show();
            $.post(routeTime, {
                date: date,
                now: false,
                id: id,
                duration: duration
            }, function (response) {
                $('#time_update').empty();
                if (response) {
                    $('#time_update').empty();
                    $('#time_update').append(response);
                    resolve();
                }
            }).fail(function (xhr, status, error) {
                if (xhr.status == 419) {
                    alert(xhr.responseJSON.message);
                    window.location.reload();
                }
            }).always(function () {
                initOwlOnTime();
                if ($('#time').val()) {
                    let selector = $("input[data-time='" + $('#time').val() + "']");
                    selector.addClass('active');
                }
                $('.loading').hide();
            });
        });
    }

    function loadTherapists() {
        return new Promise(function (resolve, reject) {
            $('.loading').show();
            $.post(routeCheckPostal, {
                postcode: postcode,
            }, function (response) {
                $('#therapists-update').empty();
                $('#therapists-update').append(response.therapists);
            }).fail(function (xhr, status, error) {
                if (xhr.status == 419) {
                    alert(xhr.responseJSON.message);
                    window.location.reload();
                }
            }).always(function () {
                initOwlOnTherapists()
                $('.loading').hide();
                resolve();
            });
        });
    }

    function initOwlOnDate() {
        $('.owl-corousel-date').owlCarousel({
            navContainer: '.owl-corousel-container-date .custom-nav',
            nav: true,
            dots: false,
            mouseDrag: false,
            navText: [
                '<i class="fas fa-arrow-left" aria-hidden="true"></i>',
                '<i class="fas fa-arrow-right" aria-hidden="true"></i>'
            ],
            autoWidth: true,
        });
    }

    function initOwlOnTime() {
        $('.owl-corousel-time').owlCarousel({
            navContainer: '.owl-corousel-container-time .custom-nav',
            nav: true,
            dots: false,
            mouseDrag: false,
            navText: [
                '<i class="fa fa-arrow-left" aria-hidden="true"></i>',
                '<i class="fa fa-arrow-right" aria-hidden="true"></i>'
            ],
            slideBy: 3,
            autoWidth: true,
        });
    }

    loadDays().then(function () {
        loadTime().then(function () {
            loadTherapists();
        })
    })

    function getTimeTherapist() {
        return new Promise(function (resolve, reject) {
            $('.loading').show();
            var duration = $('#duration').val();
            var date = $('#date').val();
            var therapistId = $('#therapist_id').val();
            var time = $('#time').val();
            if (therapistId) {
                $.post(routeTherapistTime, {
                    id: therapistId,
                    date: date,
                    duration: duration
                }, function (response) {
                    $('.calendar_time').attr("disabled", false);
                    if (response) {
                        for (i = 0; i < response.length; i++) {
                            // if selected time is disabled time before selecting therapist
                            // unset it
                            if (time == response[i]) {
                                resetTime();
                                scrollToNextSelection();
                            }
                            $('.calendar_time[data-time="' + response[i] + '"]').attr("disabled", true);
                            $('.loading').hide();
                            resolve();
                        }
                    }
                }).fail(function (xhr, status, error) {
                    if (xhr.status == 419) {
                        alert(xhr.responseJSON.message);
                        window.location.reload();
                    }
                });
            }
        });
    }

    function getFreeTherapists() {
        $('.loading').show();

        return new Promise(function (resolve, reject) {
            var option, style, duration, mTable, zChair, soothing, strong, female, male;
            var asap;
            if ($('#mTable:checked').length) {
                mTable = 1;
            }
            if ($('#zChair:checked').length) {
                zChair = 1;
            }
            if ($('#soothing:checked').length) {
                soothing = 1;
            }
            if ($('#strong:checked').length) {
                strong = 1;
            }
            if ($('#female:checked').length) {
                female = 1;
            }
            if ($('#male:checked').length) {
                male = 1;
            }
            var date = $('#date').val() ? $('#date').val() : 'none';
            var time = $('#time').val() ? $('#time').val() : 'none';
            var asap = false;
            var style = $('#treatment').val();
            var duration = $('#duration').val()

            option = {
                date: date,
                time: time,
                style: style,
                duration: duration,
                asap: asap,
                postcode: postcode,
                fullPostcode: fullpostcode,
                mTable: mTable,
                zChair: zChair,
                soothing: soothing,
                strong: strong,
                female: female,
                male: male,
            };
            $.post(routeFreeTherapists, option, function (response) {
                $('#therapists-update').empty();
                $('#therapists-update').append(response.therapists);
                initOwlOnTherapists()
                resolve();
            }).fail(function (xhr, status, error) {
                if (xhr.status == 419) {
                    alert(xhr.responseJSON.message);
                    window.location.reload();
                }
            }).always(function () {
                $('.loading').hide();
            });
        });
    }

    function scrollToNextSelection(section = null) {
        let delay = 0;
        let scrollSpeed = 1000;
        if (section && section == 'focus-image-block') {
            setTimeout(() => {
                $([document.documentElement, document.body]).animate({
                    scrollTop: $("." + section).offset().top - 200
                }, scrollSpeed)
            }, delay);
        } else if (section) {
            setTimeout(() => {
                $([document.documentElement, document.body]).animate({
                    scrollTop: $("." + section).offset().top - 85
                }, scrollSpeed)
            }, delay);
        }
        let date = $('#date').val();
        let time = $('#time').val();
        let therapist_id = $('#therapist_id').val();
        if (date && time && therapist_id) {
            $('.focus-image-block').removeClass('hide-elem');
            $('.button-block').removeClass('hide-elem');
        } else {
            $('.focus-image-block').addClass('hide-elem');
            $('.button-block').addClass('hide-elem');
        }
    }

</script>
@endpush