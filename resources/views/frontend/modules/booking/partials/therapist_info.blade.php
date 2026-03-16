<div class="bg-white" id="insert_terapists">

    <div class="row">
        <div class="col-md-12 d-lg-none d-md-block">
            <img src="{{ $therapist->user_profile->image }}" alt="{{ $therapist->altImg }}" class="img-fluid w-100 pb40">
            <p>{!! $therapist->description !!}</p>
        </div>
        <div class="col-md-12 d-none d-lg-block">
            <img src="{{ $therapist->user_profile->image }}" alt="{{ $therapist->altImg }}" width="400" class="float-left pb-3 pr-3">
            {!! $therapist->therapist_profile->about !!}
        </div>

        <div class="col-md-12">
            <p class="h4">Treatments</p>
            @foreach ($therapist->treatments as $treatment)
            {{ $treatment->name }} @if(!$loop->last) | @endif
            @endforeach
            </ul>
        </div>
    </div>
</div>