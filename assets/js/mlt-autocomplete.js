jQuery(document).ready(function ($) {
    $('.mlt-autocomplete').each(function () {
        const input = $(this);
        const hiddenField = $(input.data('target'));

        // Clear hidden field when text is deleted
        input.on('input', function () {
            if (input.val().trim().length === 0) {
                hiddenField.val('');
            }
        });

        input.autocomplete({
            source: function (request, response) {
                $.get(mltAjax.ajax_url, {
                    action: 'mlt_autocomplete',
                    term: request.term,
                    current_post_id: mltAjax.current_post_id,
                    source_type: input.data('source'),
                    nonce: mltAjax.nonce
                }, function (data) {
                    response(data);
                });
            },
            minLength: 3,
            select: function (event, ui) {
                input.val(ui.item.label);
                hiddenField.val(ui.item.value);
                return false;
            }
        });
    });
});
