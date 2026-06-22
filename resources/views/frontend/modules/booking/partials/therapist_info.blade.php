<div class="row">

    <div class="col-md-12">
        <img src="{{ $therapist->user_profile->image }}" alt="{{ $therapist->altImg }}" class="img-fluid">
    </div>

    <div class="page-section">
        <div class="col-md-12">
            {!! $therapist->therapist_profile->about !!}
        </div>
    </div>

    <div class="col-md-12">
        <p class="h4">Treatments</p>
        @foreach ($therapist->treatments as $treatment)
        <span class="badge text-primary">{{ $treatment->name }}</span>
        @endforeach

    </div>
</div>