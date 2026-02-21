@extends('admin.layouts.default')

@section('title', 'Therapist Treatments')

@section('content')

<div class="container-fluid">
    <div class="row py-4">
        <div class="col-md-12">
            <div class="card-style d-flex flex-wrap align-items-center justify-content-between">
                <div class="title">
                    <h2>Select Treatments</h2>
                    <div class="breadcrumb-wrapper">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('admin.dashboard')}}">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="{{ route('admin.therapists.index') }}">Therapists</a>
                                </li>
                                <li class="breadcrumb-item active">Therapist Treatments</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <ul class="nav nav-tabs">
       <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.therapists.edit', ['id' => $user->id]) }}">User Profile</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.therapists.profile', ['id' => $user->id]) }}">Therapist Profile</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="{{ route('admin.therapists.treatments', ['id' => $user->id]) }}">Treatments</a>
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
            <a class="nav-link" href="{{ route('admin.therapists.holidays', ['id' => $user->id]) }}">Holidays</a>
        </li>
    </ul>


    <form action="{{ route('admin.therapists.treatmentsStore') }}" method="post" id="storeTreatmentForm" enctype="multipart/form-data">

        @csrf

        @isset($user)
        <input type="hidden" name="id" value="{{ $user->id }}" />
        @endisset

        <div class="row">

            <div class="col-12">
                <div class="card-style mb-30">

                    <div class="form-group row my-3 pb-3">
                        @foreach($treatments as $treatment)
                        <div class="col-3">
                            <div class="form-check my-2">
                                @php $class = ''; @endphp
                                @if($user && $user->treatments && $user->treatments->contains('id', $treatment->id))
                                @php $class = 'checked'; @endphp
                                @endif
                                <input class="form-check-input" type="checkbox" name="treatments[]" value="{{$treatment->id}}" id="{{$treatment->id}}" {{ $class }}>
                                <label class="form-check-label" for="{{$treatment->id}}">
                                    {{ $treatment->name }}
                                </label>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="mb-30">
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <a href="{{ route('admin.therapists.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </div>
            </div>

        </div>

    </form>
</div>

@endsection