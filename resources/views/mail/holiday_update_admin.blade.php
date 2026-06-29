@inject('format', 'App\Services\FormatService')

@if($action == 'add')
<p>{{ $holiday->therapist->first_name }} has booked the following time off:</p>
@else
<p>{{ $holiday->therapist->first_name }} has cancelled the following time off:</p>
@endif
<p>{{$format->time($holiday->start_date)}} on {{ $format->date($holiday->start_date) }} to {{ $format->time($holiday->end_date)}} on {{ $format->date($holiday->end_date) }}</p>