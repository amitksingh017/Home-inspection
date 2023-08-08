$('body').on('click', '.multi-actions .multi-action', function () {
    const $_this = $(this);
    const actionButton = $_this.find('.action-button');
    let confirmation = actionButton.attr('data-confirmation');
    const actionType = actionButton.attr('data-type');

    if ('select' !== actionType) {

        if (confirmation) {
            confirmation = (1 == confirmation) ? 'Are you sure?' : confirmation;
            if (!confirm(confirmation)) {
                return false;
            }
        }

        const id = $_this.attr('data-id');
        const key = $_this.attr('data-key');
        const url = $_this.closest('.multi-actions').attr('data-action');
        let form = $_this.closest('form').serialize();
        form += '&_id=' + id;
        form += '&_key=' + key;
        const card = $_this.closest('.card');
        sendMultiAction(card, form, url);
    }
});

$('body').on('click', '.multi-actions .multi-action .action-button[data-type="select"] .options .option', function (e) {
    e.preventDefault();
    const $_this = $(this);
    let confirmation = $_this.closest('.action-button').attr('data-confirmation');

    if (confirmation) {
        confirmation = (1 == confirmation) ? 'Are you sure?' : confirmation;
        if (!confirm(confirmation)) {
            return false;
        }
    }

    const container = $_this.closest('.multi-action');
    const id = container.attr('data-id');
    const key = container.attr('data-key');
    const selected = $_this.attr('data-option');
    const url = container.closest('.multi-actions').attr('data-action');
    let form = $_this.closest('form').serialize();
    form += '&_id=' + id;
    form += '&_key=' + key;
    form += '&_selected=' + selected;
    const card = $_this.closest('.card');
    sendMultiAction(card, form, url);
});

$('body').on('change', '.checkbox-row', function () {
    checkSelectedRows($(this).closest('.card'));
});

$('body').on('change', '.kt-checkbox--all input[type=checkbox]', function () {
    const cardContainer = $(this).closest('.card');
    const checkboxes = cardContainer.find('.kt-checkbox--single input[type=checkbox]');
    const formElement = cardContainer.find('.content_form');
    if ($(this).is(':checked')) {
        checkboxes.prop('checked', true);
        checkboxes.each(function () {
            const name = $(this).attr('name');
            if (name) {
                formElement.append('<input type="hidden" name="' + name + '" class="form-id" value="' + $(this).val() + '" />');
            }
        });
    } else {
        checkboxes.prop('checked', false);
        formElement.find('.form-id').remove();
    }
    checkSelectedRows($(this).closest('.card'));
});

function sendMultiAction(cardElement, form, url) {
    cardElement.find('.content_body table thead tr th').each(function () {
        const field = $(this).attr('data-field');
        if (field) {
            form += '&_fields[]=' + field;
            if ($(this).hasClass('searchable')) {
                form += '&_searchable[]=' + field;
            }
        }
    });
    cardElement.find('.filters .filter-element').each(function () {
        const filterKey = $(this).attr('data-key');
        if (filterKey) {
            form += '&_filters[]=' + filterKey;
        }
    });
    $.post(url, form, function (response) {
        if (response.success) {
            if (response.reloadPageAfterAction) {
                location.reload();
            } else if (response.redirectUrl) {
                window.location.href = response.redirectUrl;
            } else if (response.jsCallback) {
                const callback = window[response.jsCallback];
                callback(response.customData);
            }
        }
    });
}

function checkSelectedRows(container) {
    const multiActions = container.find('.multi-actions');
    const checkboxes = container.find('.checkbox-row:checked');
    const formElement = container.find('.content_form');
    if (checkboxes.length > 0) {
        multiActions.attr('data-type', 'selected');
        formElement.find('.form-id').remove();
        checkboxes.each(function () {
            const name = $(this).attr('name');
            if (name) {
                formElement.append('<input type="hidden" name="' + name + '" class="form-id" value="' + $(this).val() + '" />');
            }
        });
        $('.hidden-multi-actions').fadeIn();
    } else {
        multiActions.attr('data-type', 'page');
        formElement.find('.form-id').remove();
        $('.hidden-multi-actions').hide();
    }
    const type = multiActions.attr('data-type');
    multiActions.find('.has-title').each(function () {
        const $_this = $(this);
        const multiActionName = $_this.closest('.multi-action').attr('data-title');
        if ('selected' === type) {
            $_this.attr('title', multiActionName + ' Selected');
        } else if ('page' === type) {
            $_this.attr('title', multiActionName + ' On This Page');
        }
    });
}

function deleteRows(response) {
    $.each(response.ids, function (key, val) {
        $('.checkbox-row[value=' + val + ']').closest('tr').remove();
    });
}
