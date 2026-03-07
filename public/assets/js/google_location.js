var autocomplete;

function initAutocomplete() {
    autocomplete = new google.maps.places.Autocomplete(
        (document.getElementById('input_postcode')), {
        componentRestrictions: {
            country: 'UK'
        },
        fields: ['address_components']
    });
    autocomplete.addListener('place_changed', fillInAddress);
}

var componentForm = {
    administrative_area_level_1: 'short_name',
    postal_town: 'long_name',
    country: 'long_name',
    postal_code: 'short_name',
};

function fillInAddress() {

    var place = autocomplete.getPlace();
    //console.log(place);
    var val = {};
    for (var i = 0; i < place.address_components.length; i++) {
        var addressType = place.address_components[i].types[0];
        if (componentForm[addressType]) {
            val[addressType] = place.address_components[i][componentForm[addressType]];
        }
    }
    if (val['postal_code']) {
        $('.loading').show();
        $('#postcode_error').removeClass("show-elem").addClass("hide-elem");

        $.post("/check-postal-code", {
            postcode: val['postal_code']
        }, function (response) {
            if (response.data.result == true) {
                $('#postcode').val(val['postal_code']);
                $('#postcode_id').val(response.data.postcode_id);
                $('#travel_sup').val(response.data.supplement);
                if (val['postal_town'] != undefined) {
                    $('#town').val(val['postal_town']);
                }
                $('.postcode-button').attr('disabled', false);

            } else {
                $('#postcode_error').html(response.data.message);
                $('#postcode_error').removeClass("hide-elem").addClass("show-elem");

                $('#postcode').val('');
                $('#postcode_id').val('');
                $('#travel_sup').val('');
                $('#town').val('');

                $('.postcode-button').attr('disabled', true);
            }
        }).fail(function (xhr, status, error) {
            if (xhr.status == 419) {
                alert(xhr.responseJSON.message);
                window.location.reload();
            }
        }).always(function () {
            $('.loading').hide();
        });
    } else {
        $('#postcode_error').text('Please enter your FULL postcode');
        $('#postcode_error').removeClass("hide-elem").addClass("show-elem");

        $('#postcode').val('');
        $('#postcode_id').val('');
        $('#travel_sup').val('');
        $('#town').val('');

        $('.postcode-button').attr('disabled', true);
    }
}

$("#input_postcode_clear").click(function () {
    $("#input_postcode").val('');
    $('#postcode_error').empty();
    $('#postcode_error').removeClass("show-elem").addClass("hide-elem");
    $('#postcode').val('');
    $('#postcode_id').val('');
    $('#travel_sup').val('');
    $('#town').val('');
    $('.postcode-button').attr('disabled', true);
});