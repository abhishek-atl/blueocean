<div class="row g-4">


    @forelse($therapists as $therapist)
    <div class="col-12 col-md-4">

        <article class="custom-card h-100 therapist-card" id="therapist_{{ $therapist->id }}" data-name="{{ $therapist->first_name }}">

            @if($therapist->user_profile->image)
            <a href="" class="custom-card-image">
                <img
                    src="{{ $therapist->user_profile->image }}"
                    title="{{ $therapist->first_name }}"
                    class="img-fluid">
            </a>
            @endif

            <div class="custom-card-body">
                <h2 >{{ $therapist->first_name }}</h2>

                <div class="custom-card-actions">
                    <div class="therapist-more-info">
                        <a href="javascript:void(0)"
                            onclick="showTherapistsInfo(event, '{{ $therapist->id }}', '{{ $therapist->first_name }}')"
                            class="">More Details</a>
                    </div>
                    <div class="therapist-more-info">
                        <a href="javascript:void(0)"
                            onclick="therapistClicked('{{ $therapist->id }}')"
                            class="btn btn-primary">Select</a>
                    </div>
                </div>
            </div>
        </article>
    </div>
    @empty
    <div class="col-12 col-md-4">
        Sorry! No therapists available at selected timeslot. Please select another one.
    </div>
    @endforelse
</div>