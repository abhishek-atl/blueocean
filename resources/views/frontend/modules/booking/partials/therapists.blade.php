<div class="row g-4">
    @foreach($therapists as $therapist)
    <div class="col-12 col-md-3">

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
                <h2>{{ $therapist->first_name }}</h2>

                <div class="custom-card-summary">
                    {!! Str::limit(strip_tags($therapist->therapist_profile->about), 50) !!}
                </div>

                <div class="custom-card-actions">
                    <div class="therapist-more-info">
                        <a href="javascript:void(0)"
                            onclick="showTherapistsInfo(event, '{{ $therapist->id }}', '{{ $therapist->first_name }}')"
                            class="">More About {{ $therapist->first_name }} </a>
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
    @endforeach
</div>