@extends('frontend.layouts.default')

@inject('format', 'App\Services\FormatService')

@section('title', 'Therapist Dashboard | My Postcodes')

@section('content')

<div class="container pt50 mb40">

    <div class="row">
        <div class="col-3">
            <h1 class="text-primary mb-4">Profile</h1>
        </div>
        <div class="col-9 text-right">
            <a class="btn btn-secondary" href="{{ route('profile') }}">Personal</a>
            <a class="btn btn-primary" href="{{ route('postcodes') }}">Postcode</a>
            <a class="btn btn-secondary" href="{{ route('schedules') }}">Schedule</a>
            <a class="btn btn-secondary" href="{{ route('mandates') }}">Mandates</a>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card mb-3">
                <div class="card-body">
                    <h2 class="mb-3">Your Postcode Coverage</h2>
                    <p>Below are the postcodes we cover and those that you have selected. If you would like to add or remove any postcodes, please contact the office and we will process for you</p>
                    @foreach($districts as $district)
                    <div class="form-group row border my-3 pb-3">
                        <div class="col-md-12 p-0">
                            <div class="bg-secondary p-2">{{ $district->postcode_area }} {{ $district->district }}</div>
                        </div>
                        @foreach($district->postcodes as $postcode)
                        <div class="col-md-2">
                            <div class="form-check my-2">
                                @php $class = ''; @endphp
                                @if($therapist && $therapist->postcodes && $therapist->postcodes->contains('postcode',$postcode->postcode))
                                @php $class = 'checked="checked"'; @endphp
                                @endif
                                <input class="form-check-input" type="checkbox" {{ $class }} disabled>
                                <label class="form-check-label" for="{{$postcode->id}}">{{ $postcode->postcode }}</label>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

    </div>
</div>


@endsection

@push('footerJs')
<script>
</script>
@endpush