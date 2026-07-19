<form method="post" action="{{ route('bookingPostcodeSubmit') }}" id="postcode_form" class="postcode-form">
    @csrf
    <div class="row g-2 postcode-search">
        <div class="col-12 col-sm postcode-input-wrap">

            <div class="form-group">
                <div id="autocomplete-container"></div>
            </div>
            <div id="status"></div>

        </div>
        <div class="col-12 col-sm-auto">
            <button class="btn btn-light btn-lg postcode-button w-100" disabled="disabled">Book Now</button>
        </div>
    </div>

    <div id="postcode_error" class="hide-elem alert alert-danger mt-3"></div>

    <input type="hidden" name="town" id="town" />
    <input type="hidden" name="postcode" id="postcode" />
    <input type="hidden" name="country" id="country" />

    <input type="hidden" name="postcode_id" id="postcode_id" />
    <input type="hidden" name="travel_sup" id="travel_sup" />


</form>

@push('pageScripts')
<script>
    function clearError() {
        $('#postcode_error').empty().removeClass('show-elem').addClass('hide-elem');
    }

    function showError(message) {
        $('#postcode_error').text(message).removeClass('hide-elem').addClass('show-elem');
    }

    function resetBookingFields() {
        $('#postcode').val('');
        $('#postcode_id').val('');
        $('#travel_sup').val('');
        $('#town').val('');
        $('.postcode-button').attr('disabled', true);
    }

    function checkPostcode(postcode) {
        $('.loading').show();
        clearError();
        $.post('/check-postal-code', {
            postcode: postcode
        }, function(response) {
            if (response.data.result === true) {
                $('#postcode_id').val(response.data.postcode_id);
                $('#travel_sup').val(response.data.supplement);
                $('.postcode-button').attr('disabled', false);
            } else {
                showError(response.data.message);
                resetBookingFields();
            }
        }).fail(function(xhr) {
            if (xhr.status === 419 && xhr.responseJSON) {
                alert(xhr.responseJSON.message);
                window.location.reload();
                return;
            }

            showError('Unable to check this postcode. Please try again.');
            resetBookingFields();
        }).always(function() {
            $('.loading').hide();
        });
    }

    async function initPlaces() {
        const {
            PlaceAutocompleteElement
        } = await google.maps.importLibrary('places');

        const autocomplete = new PlaceAutocompleteElement({
            includedRegionCodes: ['gb']
        });

        autocomplete.placeholder = 'Example: SW1A 1AA';

        document
            .getElementById('autocomplete-container')
            .appendChild(autocomplete);

        autocomplete.addEventListener('gmp-select', async (event) => {
            const status = document.getElementById('status');

            try {
                status.textContent = 'Loading address...';

                const place = event.placePrediction.toPlace();

                await place.fetchFields({
                    fields: [
                        'id',
                        'formattedAddress',
                        'addressComponents',
                        'location'
                    ]
                });

                populateAddress(place);

                status.textContent = '';
            } catch (error) {
                console.error(error);
                status.textContent =
                    'The address could not be loaded. Please try again.';
            }
        });
    }

    function getComponent(place, type, useShortText = false) {
        const component = place.addressComponents?.find(
            component => component.types.includes(type)
        );

        if (!component) {
            return '';
        }

        return useShortText ?
            component.shortText :
            component.longText;
    }

    function populateAddress(place) {

        const locality =
            getComponent(place, 'postal_town') ||
            getComponent(place, 'locality');

        const postcode =
            getComponent(place, 'postal_code');

        const country =
            getComponent(place, 'country');


        document.getElementById('town').value =
            locality;

        document.getElementById('postcode').value =
            postcode;

        document.getElementById('country').value =
            country;

        checkPostcode(postcode);
    }
</script>

<script
    async
    src="https://maps.googleapis.com/maps/api/js?key={{ config('custom.google_maps_api_key') }}&loading=async&callback=initPlaces">
</script>
@endpush