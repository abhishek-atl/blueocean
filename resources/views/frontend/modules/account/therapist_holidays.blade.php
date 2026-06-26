@extends('frontend.layouts.default')

@inject('format', 'App\Services\FormatService')

@section('title', 'Therapist Dashboard | My Holidays')

@section('content')

<div class="container pt50 mb40">


    <div class="row mb-3">
        <div class="col-3">
            <h1 class="text-primary mb-4">Holidays</h1>
        </div>
        <div class="col-9 text-right">
            <a class="btn btn-primary" href="{{ route('holidays') }}">Booked</a>
            <a class="btn btn-secondary" href="{{ route('calendar') }}">Book New</a>
        </div>
    </div>

    <div class="row">
        <div class="card-body">
            <div class="table-responsive" v-if="items && items.length > 0">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Start</th>
                            <th>End</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($holidays as $holiday)
                        @php
                        $color = '';
                        if($holiday->start_date > now())
                        $color = 'lightyellow';
                        elseif($holiday->start_date < now() && $holiday->end_date > now())
                            $color = 'lightgreen';
                            elseif($holiday->end_date < now()) $color='lightgray' ; @endphp <tr style="background-color: {{ $color }}">
                                <td>{{ $format->date($holiday->start_date, config('custom.format.date_time')) }}</td>
                                <td>{{ $format->date($holiday->end_date, config('custom.format.date_time')) }}</td>
                                <td>
                                    @if($color == 'lightyellow' || $color == 'lightgreen')
                                    <a href="javascript:void(0)" type="button" data-id="{{ $holiday->id}}" class="btn mb-1 ml-3 btn-rounded btn-outline-danger btn-sm btnDeleteHoliday">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                    @else

                                    @endif
                                </td>
                                </tr>
                                @endforeach
                    </tbody>
                </table>
                {{ $holidays->onEachSide(0)->links() }}
            </div>
        </div>
    </div>
</div>
@endsection


@push('footerJs')
<script>

    $('.btnDeleteHoliday').click(function (e) {
        e.preventDefault();
        let btn = $(this);
        if (confirm("Are you sure you want to delete?")) {
            $('.loading').show();
            $.post('{{ route("calendarPost") }}', {
                'id': $(this).attr('data-id'),
                'type': 'delete'
            }, function (response) {
                btn.parents('tr').remove();
                toastr.success('Holiday Cancelled', 'Event');
            }).always(function () {
                setTimeout(() => {
                    $('.loading').hide();
                    location.reload();
                }, 1000);
            });
        }
    });
</script>
@endpush