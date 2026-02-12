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
            <a class="nav-link" href="{{ route('admin.therapists.schedules', ['id' => $user->id]) }}">Schedules</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.therapists.fees', ['id' => $user->id]) }}">Fees</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="{{ route('admin.therapists.holidays', ['id' => $user->id]) }}">Holidays</a>
        </li>
    </ul>

    <div class="card">
        <div class="card-header mt-3">
            <h4 class="ml-2">Therapist Holidays</h4>
        </div>
        <div class="table-responsive" v-if="items && items.length > 0">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Requested At</th>
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
                            <td>{{ $format->date($holiday->created_at, config('custom.format.date_time')) }}</td>
                            <td>
                                <a href="javascript:void(0)" type="button" data-id="{{ $holiday->id}}" class="btn mb-1 ml-3 btn-rounded btn-outline-danger btn-sm btnDeleteHoliday">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </td>
                            </tr>
                            @endforeach
                </tbody>
            </table>
            {{ $holidays->onEachSide(0)->links() }}
        </div>
    </div>

</div>

@endsection