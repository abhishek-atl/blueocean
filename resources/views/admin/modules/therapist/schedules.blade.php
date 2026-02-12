@extends('admin.layouts.default')

@section('content')

<div class="container-fluid">
    <div class="row py-4">
        <div class="col-md-12">
            <div class="d-flex flex-wrap align-items-center justify-content-between">
                <div class="title">
                    @if(isset($postcode))
                    <h2>Edit Postcode</h2>
                    @else
                    <h2>Create Postcode</h2>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.therapists.edit', ['id' => $user->id]) }}">Therapist Information</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.therapists.treatments', ['id' => $user->id]) }}">Treatments</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.therapists.postcodes', ['id' => $user->id]) }}">Postcodes</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="{{ route('admin.therapists.schedules', ['id' => $user->id]) }}">Schedules</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.therapists.fees', ['id' => $user->id]) }}">Fees</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.therapists.holidays', ['id' => $user->id]) }}">Holidays</a>
        </li>
    </ul>

    <form action="{{ route('admin.therapists.schedulesStore') }}" method="post">
        @csrf
        @if($isEdit)
        <input type="hidden" name="id" value="{{ $user->id }}">
        @endif

        <div class="row">

            <div class="col-12">
                <div class="card-style mb-30">

                    <h4>Select Working Hours</h4>
                    <div class="form-group row">
                        <div class="col-md-12 p-0">
                            <div class="form-check mx-3">
                                <input class="form-check-input checkAll" type="checkbox" name="checkAll" value="" id="checkAll">
                                <label class="form-check-label" for="checkAll">
                                    Choose All
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12 p-0">
                            <div class="form-check mx-3">
                                <input class="form-check-input copyMonday" type="checkbox" name="copyMonday" value="" id="copyMonday">
                                <label class="form-check-label" for="copyMonday">
                                    Duplicate Mondays Schedule to every day?
                                </label>
                            </div>
                        </div>
                    </div>

                    @foreach($days as $key => $day)
                    <div class="form-group row border my-3 pb-3 day_{{ $day }}">
                        <div class="col-md-12 p-0">
                            <div class="bg-secondary p-2 text-white">{{ $day }}</div>
                            <div class="form-check mx-3 my-3">
                                <input class="form-check-input checkAll_{{ $day }} checkAllDay" type="checkbox" name="checkAll_{{ $day }}" value="{{ $day }}" id="checkAll_{{ $day }}">
                                <label class="form-check-label" for="checkAll_{{ $day }}">
                                    Choose All {{ $day }}
                                </label>
                            </div>
                        </div>
                        <div class="col">
                            <ul style="width: 150px; float: left;">
                                @foreach($timeSlots as $time)
                                <li>
                                    <div class="form-check my-2 days">
                                        @php $class = ''; @endphp
                                        @if($user->therapist_profile?->schedule && $user->therapist_profile?->schedule->$key && in_array($time,explode(',',$user->therapist_profile?->schedule->$key)))
                                        @php $class = 'checked'; @endphp
                                        @endif
                                        <input class="form-check-input" data-id="{{ $time }}" type="checkbox" name="{{ $key }}[]" value="{{$time}}" id="{{ $day }}_time_{{$time}}" {{$class}}>
                                        <label class="form-check-label" for="{{ $day }}_time_{{$time}}">{{ $time}}</label>
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


                    <div class="form-group row">
                        <div class="col-lg-8">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@endsection

@push('pageScripts')
<script>
    $(document).ready(function () {

        $('.copyMonday').click(function (event) {
            let checked = $('.day_Monday').find('input:checkbox:checked')
            $.each(checked, function (key, value) {
                let dataValue = $(value).data('id');
                $('input[type="checkbox"][data-id="' + dataValue + '"]').not($('.day_Monday').find('input:checkbox')).prop('checked', $('.copyMonday').prop('checked'));

            });
        })

        $('.checkAll').click(function (event) {
            $('.days').find('input:checkbox').prop('checked', this.checked);
        })
        $('.checkAllDay').click(function (event) {
            let parentDiv = $(this).parents('.form-group');
            parentDiv.find('input:checkbox').prop('checked', this.checked);
        })

        $(document).ready(function () {
            @if (Session:: has('success_msg'))
        toastr.success("{{ Session::get('success_msg') }}")
        @endif
    })


    });
</script>
@endpush