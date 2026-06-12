<form method="post" action="{{ route('bookingPostcodePost') }}" id="postcode_form" class="postcode-form">
    @csrf
    <span class="hero-eyebrow">Mobile massage across London</span>
    <h1>Professional massage, brought to your door.</h1>
    <p class="lead">Book trusted mobile therapists for home and hotel treatments from &pound;59.</p>

    <div class="row g-2 postcode-search">
        <div class="col-12 col-sm">
            <label for="input_postcode" class="visually-hidden">Enter your postcode</label>
            <input type="text" name="input_postcode" id="input_postcode" class="form-control form-control-lg" placeholder="Enter your postcode">
        </div>
        <div class="col-12 col-sm-auto">
            <button class="btn btn-light btn-lg postcode-button w-100" disabled="disabled">Book Now</button>
        </div>
    </div>

    <div id="postcode_error" class="hide-elem alert alert-danger mt-3"></div>
    <input type="hidden" name="postcode" id="postcode" />
    <input type="hidden" name="postcode_id" id="postcode_id" />
    <input type="hidden" name="travel_sup" id="travel_sup" />
    <input type="hidden" name="town" id="town" />
</form>
