<div class="row mt-3">
    @foreach ($therapists as $therapist)
    <div class="col-6 col-md-4 mb-4">
        <div class="therapist-card" data-name="{{ $therapist->first_name }}" onclick="therapistClicked('{{ $therapist->id }}')" id="therapist_{{ $therapist->id }}">
            <div class="box team card border-0 text-center">
                <img class="card-img-top" src="{{ $therapist->user_profile->image }}" alt="{{ $therapist->first_name }}" title=" {{ $therapist->first_name }}" />
                <div class="card-body p-0">
                    <div class="d-flex flex-column">
                        <h5>{{ $therapist->first_name }} <a class="text-decoration-none" href="javascript:void(0)" onclick="showTherapistsInfo(event, '{{ $therapist->id }}', '{{ $therapist->first_name }}')"><i class="fa fa-info-circle"></i></a></h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>