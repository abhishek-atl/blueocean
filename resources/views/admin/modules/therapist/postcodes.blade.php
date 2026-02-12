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
            <a class="nav-link active" href="{{ route('admin.therapists.postcodes', ['id' => $user->id]) }}">Postcodes</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.therapists.schedules', ['id' => $user->id]) }}">Schedules</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.therapists.fees', ['id' => $user->id]) }}">Fees</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.therapists.holidays', ['id' => $user->id]) }}">Holidays</a>
        </li>
    </ul>


    <form action="{{ route('admin.therapists.postcodesStore') }}" method="post">
        @csrf
        @if($isEdit)
        <input type="hidden" name="id" value="{{ $user->id }}">
        @endif

        <div class="row">

            <div class="col-12">
                <div class="card-style mb-30">

                    <div class="form-group row">
                        <div class="col-md-1 p-0">
                            <div class="form-check mx-3">
                                <input class="form-check-input checkAll" type="checkbox" id="checkAll">
                                <label class="form-check-label" for="checkAll">Choose All</label>
                            </div>
                        </div>
                        @foreach($zones as $zone)
                        <div class="col-md-1 p-0">
                            <div class="form-check mx-3">
                                <input class="form-check-input checkAllZone" type="checkbox" value="{{ $zone->id}}" id="zone{{ $zone->id}}">
                                <label class="form-check-label" for="zone{{ $zone->id}}">{{ $zone->name}}</label>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    @foreach($districts as $district)
                    <div class="form-group row border my-3 pb-3">
                        <div class="col-md-12 p-0">
                            <div class="bg-secondary p-2 text-white">{{ $district->postcode_area }} {{ $district->district }}</div>
                            <div class="form-check mx-3 my-3">
                                <input class="form-check-input checkThisZone" type="checkbox" id="checkAll{{ $district->id}}">
                                <label class="form-check-label" for="checkAll{{ $district->id}}">
                                    Choose All {{ $district->postcode_area }} {{ $district->district }} Postcodes
                                </label>
                            </div>
                        </div>
                        @foreach($district->postcodes as $postcode)
                        <div class="col-md-2">
                            <div class="form-check my-2">
                                @php $class = ''; @endphp
                                @if($user->therapist_profile && $user->therapist_profile->postcodes && $user->therapist_profile->postcodes->contains('postcode',$postcode->postcode))
                                @php $class = 'checked="checked"'; @endphp
                                @endif
                                <input class="form-check-input" type="checkbox" name="postcodes[]" value="{{$postcode->id}}" id="{{$postcode->id}}" data-zone="{{ $postcode->zone ? $postcode->zone->shortcust_id : 0 }}" {{ $class }}>
                                <label class="form-check-label" for="{{$postcode->id}}">
                                    {{ $postcode->postcode }}
                                </label>
                            </div>
                        </div>
                        @endforeach
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
        $('.checkThisZone').click(function (event) {
            let parentDiv = $(this).parents('.form-group');
            parentDiv.find('input:checkbox').prop('checked', this.checked);
        });
        $('.checkAll').click(function (event) {
            $('input:checkbox[name="postcodes[]"]').prop('checked', this.checked);
        });
        $('.checkAllZone').click(function (event) {
            let id = $(this).val();
            $('input:checkbox[data-zone="' + id + '"]').prop('checked', this.checked);
        });

        @if (Session:: has('success_msg'))
    toastr.success("{{ Session::get('success_msg') }}")
    @endif
    });
</script>
@endpush