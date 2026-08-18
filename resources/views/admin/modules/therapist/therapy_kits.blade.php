@extends('admin.layouts.default')

@section('title', 'Therapist Therapy Kit')

@section('content')
<div class="container-fluid">
    <div class="row py-4">
        <div class="col-md-12">
            <div class="card-style d-flex flex-wrap align-items-center justify-content-between">
                <div class="title">
                    <h2>Therapy Kit: {{ $user->first_name }}</h2>
                    <div class="breadcrumb-wrapper">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('admin.therapists.index') }}">Therapists</a></li>
                                <li class="breadcrumb-item active">Therapy Kit</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <ul class="nav nav-tabs">
        <li class="nav-item"><a class="nav-link" href="{{ route('admin.therapists.edit', ['id' => $user->id]) }}">User Profile</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('admin.therapists.profile', ['id' => $user->id]) }}">Therapist Profile</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('admin.therapists.treatments', ['id' => $user->id]) }}">Treatments</a></li>
        <li class="nav-item"><a class="nav-link active" href="{{ route('admin.therapists.therapy_kits', ['id' => $user->id]) }}">Therapy Kit</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('admin.therapists.postcodes', ['id' => $user->id]) }}">Postcodes</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('admin.therapists.schedules', ['id' => $user->id]) }}">Schedules</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('admin.therapists.fees', ['id' => $user->id]) }}">Fees</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('admin.therapists.holidays', ['id' => $user->id]) }}">Holidays</a></li>
    </ul>

    <form action="{{ route('admin.therapists.therapy_kits.store', ['id' => $user->id]) }}" method="post">
        @csrf
        <div class="row">
            <div class="col-12">
                <div class="card-style mb-30">
                    @forelse($therapyKits->groupBy('type') as $type => $kits)
                        <h4 class="mt-3 mb-2">{{ ucfirst($type) }}</h4>
                        <div class="form-group row mb-3">
                            @foreach($kits as $therapyKit)
                                <div class="col-md-4 col-lg-3">
                                    <div class="form-check my-2">
                                        <input class="form-check-input" type="checkbox" name="therapy_kits[]" value="{{ $therapyKit->id }}" id="therapy-kit-{{ $therapyKit->id }}" @checked($user->therapyKits->contains('id', $therapyKit->id))>
                                        <label class="form-check-label" for="therapy-kit-{{ $therapyKit->id }}">
                                            {{ $therapyKit->name }}
                                            @if(!$therapyKit->active)<span class="text-muted">(Inactive)</span>@endif
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @empty
                        <p class="mb-0">No therapy kits are available. <a href="{{ route('admin.therapy_kits.create') }}">Add a therapy kit</a>.</p>
                    @endforelse
                    @error('therapy_kits')<div class="text-danger">{{ $message }}</div>@enderror
                    @error('therapy_kits.*')<div class="text-danger">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="col-lg-12 mb-30">
                <button type="submit" class="btn btn-primary">Save</button>
                <a href="{{ route('admin.therapists.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </div>
    </form>
</div>
@endsection
