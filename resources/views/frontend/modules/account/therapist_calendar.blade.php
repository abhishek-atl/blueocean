@extends('frontend.layouts.default')

@inject('format', 'App\Services\FormatService')

@section('title', 'Therapist Dashboard | My Calendar')

@section('content')

<section class="page-hero">
    <div class="container">
        <div class="row justify-content-center text-center">
            <div class="col-lg-8">
                <h1>Holidays</h1>
            </div>
        </div>
    </div>
</section>

<section class="page-section">

    <div class="container">

        <div class="row mb-3">
            <div class="col-9 text-right">
                <a class="btn btn-secondary" href="{{ route('holidays') }}">Booked</a>
                <a class="btn btn-primary" href="{{ route('calendar') }}">Book New</a>
            </div>
        </div>

        <div class="unselectable" id='calendar'></div>

        <div class="row mt-4">
            <div class="col-md-12">
                <p><b>Instructions</b></p>
                <p>In the calendar above, any days that have a light orange bar across the bottom, are those that you already have some time booked off.</p>
                <p><b>Booking one whole day off</b>: Press and hold the EMPTY space on that day until it turns blue. Then let go and confirm. You can only book full days off for tomorrow onwards.</p>
                <p><b>Booking several days off</b>: Press and hold the EMPTY space on the first day until it turns blue. Then still pressing, move your finger across until all the days you want are blue. Then let go and confirm.</p>
                <p><b>Booking just a few hours off</b>: Click the date at the top of the day. For example, on 6 June, you can click the '6'. Then, in the Day View, scroll to the time you want to start time off. Press and hold until a blue box appears and then move your finger down until the whole time you want off is selected. Let go and confirm.</p>
                <p>To change from Day View back to Month View, click the name of the Month above the calendar (eg Jun 2023).</p>
            </div>
        </div>


    </div>

</section>

@endsection

@push('headCss')
<style>
    .fc-timegrid-now-indicator-line {
        border-color: black;
        box-shadow: 0px -2000px 0px 2000px rgba(241, 241, 241, 1);
    }

    .unselectable {
        -webkit-touch-callout: none;
        -webkit-user-select: none;
        -khtml-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    .fc .fc-daygrid-day.fc-day-today {
        background-color: '#aef7a2';
    }

    .fc .fc-toolbar.fc-footer-toolbar {
        display: none;
    }

    .fc-toolbar-title {
        text-decoration: underline;
        cursor: pointer;
    }
</style>
@endpush

@push('headJs')
<script src="{{ asset('assets/js/moment.min.js') }}"></script>
<script src="{{ asset('assets/js/fullcalendar.global.min.js') }}"></script>
@endpush

@push('pageScripts')

<script>
    
    let jsonEvents = {!! $events !!};

    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            events: jsonEvents,
            height: 'auto',
            expandRows: true,
            headerToolbar: {
                start: 'prev',
                center: 'title',
                end: 'next'
            },
            footerToolbar: {
                end: 'dayGridMonth timeGridDay'
            },
            titleFormat: {
                year: 'numeric',
                month: 'short'
            },
            longPressDelay: 500,
            showNonCurrentDates: false,
            navLinks: true,
            eventDisplay: 'block',
            displayEventTime: false,
            selectOverlap: false,
            editable: false,
            eventOverlap: false,
            selectMirror: true,
            nowIndicator: true,
            allDaySlot: false,
            slotMinTime: '07:00',
            views: {
                timeGrid: {
                    dayHeaderContent: (args) => {
                        return moment(args.date).format('dddd, Do')
                    },
                }
            },
            selectable: true,
            select: function(arg) {
                let start_date = moment(arg.start).format(moment_date_time_format);
                if (moment(arg.start) < moment()) {
                    calendar.unselect();
                    return false;
                }
                let end_date;
                if (arg.allDay)
                    end_date = moment(arg.end).subtract(1, "days").set({
                        hour: 23,
                        minute: 59
                    }).format(moment_date_time_format);
                else
                    end_date = moment(arg.end).format(moment_date_time_format);
                var conf = confirm('Are you sure you want to add a holiday from ' + start_date + ' to ' + end_date + '?');
                if (conf) {
                    $('.loading').show();
                    $.post('{{ route("calendarPost") }}', {
                        'start_date': start_date,
                        'end_date': end_date,
                        'type': 'add'
                    }, function(response) {

                    }).always(function() {
                        $('.loading').hide();
                        toastr.success('Holiday added successfully', 'Event');
                        setTimeout(() => {
                            window.location = '{{ route("holidays") }}'
                        }, 1000);

                    });
                }
                calendar.unselect()
            },
            eventClick: function(arg) {},
            validRange: {
                start: new Date()
            },

        });

        calendar.render();

        $('.fc-toolbar-title').click(function() {
            calendar.changeView('dayGridMonth');
        })


    });
</script>
@endpush