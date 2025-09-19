jQuery(document).ready(function ($) {
    function fetchAutocompleteData(input, request, response) {
        $.get(mltAjax.ajax_url, {
            action: 'mlt_autocomplete',
            term: request.term,
            current_post_id: mltAjax.current_post_id,
            source_type: input.data('source'),
            nonce: mltAjax.nonce
        }, function (data) {
            response(data);
        });
    }

    // Single autocomplete setup
    function setupSingleAutocomplete(input) {
        const hiddenField = $(input.data('target'));

        input.autocomplete({
            source: (request, response) => fetchAutocompleteData(input, request, response),
            minLength: 3,
            select: (event, ui) => {
                event.preventDefault();
                input.val(ui.item.label);
                hiddenField.val(ui.item.value);
            }
        });

        input.on('input', () => {
            if (input.val().trim() === '') {
                hiddenField.val('');
            }
        });
    }

    // Multi autocomplete setup
    function setupMultiAutocomplete(input) {
        const hiddenField = $(input.data('target'));
        const tagContainer = $('#' + input.attr('id') + '_tags');

        let selectedIDs = hiddenField.val()
            ? hiddenField.val().split(',').map(id => id.trim())
            : [];

        function updateHiddenField() {
            hiddenField.val(selectedIDs.join(','));
        }

        function addTag(id, label) {
            if (selectedIDs.includes(id.toString())) return;
            selectedIDs.push(id.toString());
            updateHiddenField();

            const tag = $(`<span class="mlt-tag" data-id="${id}">${label} <a href="#" class="mlt-remove-tag">×</a></span>`);
            tagContainer.append(tag);
        }

        tagContainer.on('click', '.mlt-remove-tag', function (e) {
            e.preventDefault();
            const tag = $(this).closest('.mlt-tag');
            const id = tag.data('id').toString();
            selectedIDs = selectedIDs.filter(i => i !== id);
            updateHiddenField();
            tag.remove();
        });

        input.autocomplete({
            source: (request, response) => {
                fetchAutocompleteData(input, request, function (data) {
                    const filtered = data.filter(user => !selectedIDs.includes(user.value.toString()));
                    response(filtered);
                });
            },
            minLength: 2,
            select: (event, ui) => {
                event.preventDefault();
                addTag(ui.item.value, ui.item.label);
                input.val('');
            }
        });

        input.on('input', () => {
            if (input.val().trim().length === 0 && selectedIDs.length === 0) {
                hiddenField.val('');
            }
        });
    }

    // Initialize all autocomplete inputs
    $('.mlt-autocomplete').each(function () {
        setupSingleAutocomplete($(this));
    });

    $('.mlt-autocomplete-multi').each(function () {
        setupMultiAutocomplete($(this));
    });
});
