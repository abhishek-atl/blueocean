@extends('frontend.layouts.default')

@section('content')

<section class="page-hero">
    <div class="container">
        <div class="row justify-content-center text-center">
            <div class="col-lg-8">
                <h1>Massage Information</h1>
            </div>
        </div>
    </div>
</section>

@if ($blockedIp)
<div class="container">
    <p>Sorry, we are currently experiencing technical problems. Please try again later.</p>
</div>
@else

<div class="page-section">

    <form name="frmMassageInfo" method="post" action="{{ route('bookingInfoSubmit') }}">

        @csrf
        <input type="hidden" id="date" name="date" value="@if(session('booking.date')){{ session('booking.date') }}@endif">
        <input type="hidden" id="time" name="time" value="@if(session('booking.time')){{ session('booking.time') }}@endif">
        <input type="hidden" id="therapist_id" name="therapist_id" value="@if(session('booking.therapist_id')){{ session('booking.therapist_id') }}@endif">

        <div class="container">

            <div class="row duration-block style-block">

                <div class="col-md-2">
                    <label for="duration" class="form-label font-weight-bold">Postcode</label>
                    <input type="text" class="form-control" value="{{ session('booking.postcode') }}" readonly>
                    <a href="{{ route('bookingPostcode') }}">Change</a>
                </div>

                <div class="col-md-2 mt-lg-0 mt-3">
                    <label for="duration" class="form-label font-weight-bold">Duration</label>
                    <select class="form-control" id="duration" name="duration">
                        @foreach ($durations as $duration)
                        @php $class= ''; @endphp
                        @if (session('booking.duration') == $duration->id)
                        @php $class = 'selected'; @endphp
                        @endif
                        <option value="{{ $duration->id }}" data-amount="£{{ number_format($duration->amount, 2) }}" {{ $class }}>
                            {{ $duration->duration }} minutes
                        </option>
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


            <div class="row mt-4 mt-lg-4 button-block hide-elem">
                <div class="col-md-12 d-flex justify-content-center justify-content-lg-start">
                    <button type="submit" class="btn btn-dark px-3 rounded">Continue</button>
                </div>
            </div>
        </div>
    </form>

</div>

<div class="modal fade" tabindex="-1" id="modal_common">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Information</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@endif

@endsection


@push('pageScripts')

<script>
    let routeDays = "{{ route('getDays') }}";
    let routeTime = "{{ route('getTime') }}";
    let routeCheckPostal = "{{ route('checkPostcode') }}";
    let routeFreeTherapists = "{{ route('getFreeTherapists') }}";
    let routeTherapistInfo = "{{ route('therapistInfo') }}";

    let postcode = "{{ session('booking.postcode') }}";

    function loadDays() {
        return new Promise(function(resolve, reject) {
            $('.loading').show();
            $.post(routeDays, function(response) {
                $('#days_update').empty();
                $('#days_update').append(response.view);
                resolve();
            }).fail(function(xhr, status, error) {
                if (xhr.status == 419) {
                    alert(xhr.responseJSON.message);
                    window.location.reload();
                }
            }).always(function() {
                initOwlOnDate();
                if ($('#date').val()) {
                    let selector = $("input[data-date='" + $('#date').val() + "']");
                    selector.addClass('active');
                }
                $('.loading').hide();
            });
        });
    }

    function loadTime() {
        return new Promise(function(resolve, reject) {
            let date = $('#date').val();
            let therapist_id = $('#therapist_id').val();
            let duration = $('#duration').val();
            $('.loading').show();
            $.post(routeTime, {
                date: date,
                id: therapist_id,
                duration: duration
            }, function(response) {
                $('#time_update').empty();
                if (response) {
                    $('#time_update').empty();
                    $('#time_update').append(response);
                    resolve();
                }
            }).fail(function(xhr, status, error) {
                if (xhr.status == 419) {
                    alert(xhr.responseJSON.message);
                    window.location.reload();
                }
            }).always(function() {
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
        return new Promise(function(resolve, reject) {
            $('.loading').show();
            $.post(routeFreeTherapists, {
                date: $('#date').val(),
                time: $('#time').val(),
                treatment: $('#treatment').val(),
            }, function(response) {
                $('#therapists-update').empty();
                $('#therapists-update').append(response.therapists);
            }).fail(function(xhr, status, error) {
                if (xhr.status == 419) {
                    alert(xhr.responseJSON.message);
                    window.location.reload();
                }
            }).always(function() {
                initOwlOnTherapists()
                $('.loading').hide();
                resolve();
            });
        });
    }

    loadDays().then(function() {
        loadTime().then(function() {
            loadTherapists();
        })
    })

    function showTherapistsInfo(e, id, firstName) {
        e.preventDefault();
        $('#modal_common .modal-body').empty();
        $.post(routeTherapistInfo, {
            therapist_id: id
        }, function(response) {
            if (response) {
                $('#modal_common .modal-title').html(firstName);
                $('#modal_common .modal-body').append(response.view);
                $('#modal_common .modal-footer').html(
                    '<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button><button data-dismiss="modal" onclick=\' therapistClicked("' +
                    id + '");\' class="btn btn-primary" type="submit">SELECT</button>');
                $('#modal_common').modal('show');
            }
        }).fail(function(xhr, status, error) {
            if (xhr.status == 419) {
                alert(xhr.responseJSON.message);
                window.location.reload();
            }
        });
    }

    function therapistClicked(id) {
        // hide modal if selected from therapist modal popup
        $('#modal_common').modal('hide');
        if ($('#therapist_' + id).hasClass('therapist-active')) {
            $('#therapist_' + id).removeClass('therapist-active');
            $('#therapist_id').val("");
            $('.therapist-diary').addClass('hide-elem');
            $('.therapist-diary').find('.alert').html('');
            loadTime();
            return false;
        } else {
            $('.therapist-card').removeClass('therapist-active');
            $('#therapist_' + id).addClass('therapist-active');
            $('#therapist_id').val(id);
            $('.therapist-diary').removeClass('hide-elem');
            $('.therapist-diary').find('.alert').html($('#therapist_' + id).attr('data-name') + ' Selected. Click To Reset.');
        }
        if (!$('#date').val()) {
            scrollToNextSelection('date-block');
        } else {
            loadTime().then(function() {
                scrollToNextSelection('focus-image-block');
            });
        }
    }

    function resetDiary() {
        $('.therapist-card').removeClass('therapist-active');
        $('#therapist_id').val("");
        $('.therapist-diary').addClass('hide-elem');
        $('.therapist-diary').find('.alert').html('');
        $('.button-block').addClass('hide-elem');
        loadTime();
    }

    function scrollToNextSelection(section = null) {
        let delay = 0;
        let scrollSpeed = 1000;
        if (section) {
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
            $('.button-block').removeClass('hide-elem');
        } else {
            $('.button-block').addClass('hide-elem');
        }
    }
</script>

<script>
    @if(!session('booking.duration'))
    $('#duration option:eq(1)').prop('selected', true);
    @endif
    $('#duration_amount').val($('#duration').find(':selected').data('amount'));

    // events
    $('#duration').change(function() {
        $('#duration_amount').val($('#duration').find(':selected').data('amount'));
        resetDiary();
        loadTherapists().then(function() {
            scrollToNextSelection('duration-block');
        });
    });
    $('#treatment').change(function() {
        resetDiary();
        loadTherapists().then(function() {
            scrollToNextSelection('style-block');
        });
    });

    $(document).on("click", '.calendar_date', function(event) {
        let selectedDate = $(this);
        $('.calendar_date').removeClass('active');
        selectedDate.addClass('active');
        let date = selectedDate.data('date');
        $('#date').val(date);
        $('#time').val("");
        loadTime().then(function() {
            loadTherapists().then(function() {
                scrollToNextSelection('date-block');
            })
        })
    });

    $(document).on("click", '.calendar_time', function(event) {
        if (!$('#date').val()) {
            $('#modal_common .modal-body').empty();
            $('#modal_common .modal-body').append('Please select a date first');
            $('#modal_common').modal('show');
            return false;
        }
        let selectedTime = $(this);
        $('.calendar_time').removeClass('active');
        selectedTime.addClass('active');
        $('#time').val(selectedTime.data('time'));
        if ($('#therapist_id').val()) {
            scrollToNextSelection('button-block');
        } else {
            loadTherapists().then(function() {
                scrollToNextSelection('time-block');
            });
        }
    });

    function initOwlOnDate() {
        $('.owl-corousel-date').owlCarousel({
            navContainer: '.owl-corousel-container-date .custom-nav',
            nav: true,
            dots: false,
            mouseDrag: false,
            navText: [
                '<i class="fa fa-arrow-left" aria-hidden="true"></i>',
                '<i class="fa fa-arrow-right" aria-hidden="true"></i>'
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

    function initOwlOnTherapists() {
        $('.owl-corousel-therapists').owlCarousel({
            nav: true,
            dots: false,
            mouseDrag: false,
            navText: ["<div class='nav-btn prev-slide'></div>", "<div class='nav-btn next-slide'></div>"],
            slideBy: 3,
            margin: 15,
            responsive: {
                1000: {
                    items: 4,
                }
            }
        });
    }
</script>

@endpush