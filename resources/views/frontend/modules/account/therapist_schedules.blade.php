@extends('frontend.layouts.default')

@inject('format', 'App\Services\FormatService')

@section('title', 'Therapist Dashboard | My Schedule')

@section('content')

<div class="container pt50 mb40">

    <div class="row">
        <div class="col-3">
            <h1 class="text-primary mb-4">Profile</h1>
        </div>
        <div class="col-9 text-right">
            <a class="btn btn-secondary" href="{{ route('profile') }}">Personal</a>
            <a class="btn btn-secondary" href="{{ route('postcodes') }}">Postcode</a>
            <a class="btn btn-primary" href="{{ route('schedules') }}">Schedule</a>
            <a class="btn btn-secondary" href="{{ route('mandates') }}">Mandates</a>
        </div>
    </div>


    <form action="{{ route('schedulesPost') }}" method="post">
        @csrf
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card mb-3">
                    <div class="card-body">
                        <h2 class="mb-3">Regular Schedule</h2>
                        <p>To book time off for specific days click <a href="{{ route('holidays') }}">HERE</a>.</p>
                        <p class="text-danger"><b>ONLY</b> use this page to add or remove hours from your <b>regular weekly availability</b>.</p>
                        <p>When you are done, you must press the <span class="text-danger"><b>SAVE</b></span> button at the bottom of this page.</p>

                        @foreach($days as $key => $day)
                        <div class="form-group row border my-3 pb-3 day_{{ $key }}">
                            <div class="col-md-12 p-0">
                                <div class="bg-secondary p-2">{{ $day }}</div>
                                <div class="form-check mx-3 my-3">
                                    <input class="form-check-input checkAll_{{ $day }} checkAllDay" type="checkbox" name="checkAll_{{ $day }}" value="{{ $day }}" id="checkAll_{{ $day }}">
                                    <label class="form-check-label" for="checkAll_{{ $day }}">
                                        Select All
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <p>You currently work the following hours on this day:</p>
                                <p class="schedule_summary_{{ $key }}"></p>
                            </div>
                            <div class="col">
                                <ul style="width: 150px; float: left;">
                                    @foreach($timeSlots as $time)
                                    <li style="list-style: none;">
                                        <div class="form-check my-2 days">
                                            @php $class = ''; @endphp
                                            @if($therapist->schedule && $therapist->schedule->$key && in_array($time,explode(',',$therapist->schedule->$key)))
                                            @php $class = 'checked'; @endphp
                                            @endif
                                            <input class="form-check-input checkday" data-id="{{ $time }}" type="checkbox" name="{{ $key }}[]" value="{{$time}}" id="{{ $key }}_time_{{$time}}" {{$class}}>
                                            <label class="form-check-label" for="{{ $key }}_time_{{$time}}">{{ $time}}</label>
                                        </div>
                                    </li>
                                    @if($loop->iteration % 6 == 0)
                                </ul>
                                <ul style="width: 150px; float: left;">
                                    @endif
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-8">
                        <button type="submit" onclick="javascript:return confirm('Are you sure you want to update your regular weekly schedule with these new times?')" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>


@endsection

@push('footerJs')
<script>

    $('.checkAllDay').click(function (event) {
        $('.loading').show();
        let parentDiv = $(this).parents('.form-group');
        parentDiv.find('input:checkbox').prop('checked', this.checked);
        setTimeout(() => {
            changeWorkingTexts();
        }, 1000);

    });

    $('.loading').show();
    let dayArray = [
        'mon',
        'tue',
        'wed',
        'thu',
        'fri',
        'sat',
        'sun',
    ];

    function changeWorkingTexts(day = null) {

        let array = [];
        dayArray.forEach(element => {
            array[element] = [];
        });

        dayArray.forEach(element => {
            if (day && day != element) {
                return;
            }

            let key = 'day_' + element;
            let checkboxes = $('.' + key).find('input:checkbox[name="' + element + '[]"]');

            let arrayIndex = 0;
            let newset = false;
            for (let index = 0; index < checkboxes.length; index++) {
                let checkbox = $(checkboxes[index]);
                if (checkbox.prop('checked')) {
                    if (newset) {
                        arrayIndex++;
                        newset = false;
                    }
                    if (!array[element][arrayIndex]) {
                        array[element][arrayIndex] = [];
                    }
                    array[element][arrayIndex].push(checkbox.val());

                } else {
                    newset = true;
                }
            }
        });

        dayArray.forEach(element => {
            let slot = '';
            if (day && day != element) {
                return;
            }
            $('.schedule_summary_' + element).empty();
            if (!array[element].length) {
                slot += '<p><b>NONE</b></p>';
            } else {
                array[element].forEach(slots => {
                    if (!slot.length) {
                        slot += '<p><table><tr><td><b>START</b></td><td>-</td><td><b>END</b></td></tr>';
                    }
                    slot += '<tr><td>' + slots[0] + '</td><td>-</td><td>' + slots[slots.length - 1] + '</td></tr>';
                })
            }
            if (array[element].length) {
                slot += '</table></p>';
                slot += '<p>START: Earliest booking time available.</p>';
                slot += '<p>END: Bookings must finish by this time.</p>'
            }
            $('.schedule_summary_' + element).append(slot);
        });

        // hide in all cases
        $('.loading').hide();
    }
    changeWorkingTexts();


    setTimeout(() => {
        $('.loading').hide();
    }, 500);

    $('.checkday').click(function () {
        let checkbox = $(this);
        let nameParts = checkbox.attr('id').split('_');
        let day = nameParts[0];
        changeWorkingTexts(day)
    })

    $(document).ready(function () {
        @if (Session:: has('success_msg'))
    toastr.success("{{ Session::get('success_msg') }}")
    @endif
    });
</script>

@endpush