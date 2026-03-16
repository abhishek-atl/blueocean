<form method="post" action="{{ route('bookingPostcodePost') }}" id="postcode_form">
    @csrf
    <h1>Welcome to Blueocean</h1>
    <p class="lead">Relax: Our expert mobile massage service starts at just £59</p>
    <div class="search-box">
        <input type="text" name="input_postcode" id="input_postcode" class="form-control" placeholder="Enter your postcode..">
        <button class="btn btn-light postcode-button" disabled="disabled">Book Now</button>
    </div>
    <div id="postcode_error" class="hide-elem alert alert-danger mt-3"></div>
    <input type="hidden" name="postcode" id="postcode" />
    <input type="hidden" name="postcode_id" id="postcode_id" />
    <input type="hidden" name="travel_sup" id="travel_sup" />
    <input type="hidden" name="town" id="town" />
</form>