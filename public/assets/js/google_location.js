(function ($) {
    'use strict';

    var $input = $('#input_postcode');
    var $suggestions = $('#postcode_suggestions');
    var sessionToken = createSessionToken();
    var activeRequest = null;
    var selectedIndex = -1;

    if (!$input.length || !$suggestions.length) {
        return;
    }

    function createSessionToken() {
        if (window.crypto && window.crypto.randomUUID) {
            return window.crypto.randomUUID();
        }

        return Math.random().toString(36).slice(2) + Date.now().toString(36);
    }

    function resetBookingFields() {
        $('#postcode').val('');
        $('#postcode_id').val('');
        $('#travel_sup').val('');
        $('#town').val('');
        $('.postcode-button').attr('disabled', true);
    }

    function showError(message) {
        $('#postcode_error').text(message).removeClass('hide-elem').addClass('show-elem');
    }

    function clearError() {
        $('#postcode_error').empty().removeClass('show-elem').addClass('hide-elem');
    }

    function hideSuggestions() {
        $suggestions.empty().addClass('d-none');
        selectedIndex = -1;
    }

    function renderSuggestions(suggestions) {
        $suggestions.empty();

        suggestions.forEach(function (suggestion) {
            var prediction = suggestion.placePrediction;
            if (!prediction || !prediction.placeId) {
                return;
            }

            $('<button>', {
                type: 'button',
                class: 'postcode-suggestion list-group-item list-group-item-action',
                text: prediction.text && prediction.text.text ? prediction.text.text : '',
                'data-place-id': prediction.placeId
            }).appendTo($suggestions);
        });

        if ($suggestions.children().length) {
            $suggestions.removeClass('d-none');
        } else {
            hideSuggestions();
        }
    }

    function findAddressComponent(components, type) {
        return (components || []).find(function (component) {
            return component.types && component.types.indexOf(type) !== -1;
        });
    }

    function componentValue(component) {
        if (!component) {
            return '';
        }

        return component.shortText || component.longText || component.short_name || component.long_name || '';
    }

    function checkPostcode(postcode, town) {
        $('.loading').show();
        clearError();

        $.post('/check-postal-code', {
            postcode: postcode
        }, function (response) {
            if (response.data.result === true) {
                $('#postcode').val(postcode);
                $('#postcode_id').val(response.data.postcode_id);
                $('#travel_sup').val(response.data.supplement);
                $('#town').val(town || '');
                $('.postcode-button').attr('disabled', false);
            } else {
                showError(response.data.message);
                resetBookingFields();
            }
        }).fail(function (xhr) {
            if (xhr.status === 419 && xhr.responseJSON) {
                alert(xhr.responseJSON.message);
                window.location.reload();
                return;
            }

            showError('Unable to check this postcode. Please try again.');
            resetBookingFields();
        }).always(function () {
            $('.loading').hide();
        });
    }

    function loadSuggestions() {
        var postcode = $.trim($input.val());

        clearError();
        resetBookingFields();

        if (postcode.length < 2) {
            hideSuggestions();
            return;
        }

        if (activeRequest) {
            activeRequest.abort();
        }

        activeRequest = $.post('/google-places', {
            postcode: postcode,
            sessionToken: sessionToken
        }, function (response) {
            renderSuggestions(response.suggestions || []);
        }).fail(function (xhr) {
            if (xhr.statusText !== 'abort') {
                hideSuggestions();
            }
        });
    }

    function selectSuggestion($suggestion) {
        var placeId = $suggestion.data('place-id');

        if (!placeId) {
            return;
        }

        $input.val($suggestion.text());
        hideSuggestions();
        $('.loading').show();

        $.get('/google-places/details', {
            placeId: placeId,
            sessionToken: sessionToken
        }, function (place) {
            var postcode = componentValue(findAddressComponent(place.addressComponents, 'postal_code'));
            var town = componentValue(findAddressComponent(place.addressComponents, 'postal_town'));

            if (!town) {
                town = componentValue(findAddressComponent(place.addressComponents, 'locality'));
            }

            if (!postcode) {
                showError('Please enter your FULL postcode');
                resetBookingFields();
                return;
            }

            $input.val(postcode);
            checkPostcode(postcode, town);
            sessionToken = createSessionToken();
        }).fail(function () {
            showError('Unable to load postcode details. Please try again.');
            resetBookingFields();
        }).always(function () {
            $('.loading').hide();
        });
    }

    var loadSuggestionsDebounced = (function () {
        var timeout = null;

        return function () {
            clearTimeout(timeout);
            timeout = setTimeout(loadSuggestions, 250);
        };
    })();

    $input.on('input', loadSuggestionsDebounced);

    $input.on('keydown', function (event) {
        var $items = $suggestions.children();

        if (!$items.length || $suggestions.hasClass('d-none')) {
            return;
        }

        if (event.key === 'ArrowDown') {
            event.preventDefault();
            selectedIndex = Math.min(selectedIndex + 1, $items.length - 1);
        } else if (event.key === 'ArrowUp') {
            event.preventDefault();
            selectedIndex = Math.max(selectedIndex - 1, 0);
        } else if (event.key === 'Enter' && selectedIndex >= 0) {
            event.preventDefault();
            selectSuggestion($items.eq(selectedIndex));
            return;
        } else if (event.key === 'Escape') {
            hideSuggestions();
            return;
        } else {
            return;
        }

        $items.removeClass('active').eq(selectedIndex).addClass('active');
    });

    $suggestions.on('click', '.postcode-suggestion', function () {
        selectSuggestion($(this));
    });

    $(document).on('click', function (event) {
        if (!$(event.target).closest('#input_postcode, #postcode_suggestions').length) {
            hideSuggestions();
        }
    });

    $('#input_postcode_clear').on('click', function () {
        $input.val('');
        clearError();
        resetBookingFields();
        hideSuggestions();
    });
})(jQuery);
