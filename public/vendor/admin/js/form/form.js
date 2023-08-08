$('body').on('click', '.save_form', function (e) {
    e.preventDefault();
    const formElement = $(this).closest('form');
    const url = formElement.attr('action');
    //const form = formElement.serialize();
    let form = new FormData(this.closest('form'));
    formElement.find('.element_form').removeClass('is-invalid');
    formElement.find('.invalid-feedback').remove();

    $.ajax({
        url: url,
        method: 'POST',
        data: form,
        contentType: false,
        processData: false,
        success: function (response) {
            if (response.success) {
                if (typeof formElement.attr('data-confirmation')) {
                    window.onbeforeunload = null;
                }
                if (response.url) {
                    window.location.href = response.url;
                }
                if (response.messages) {
                    notifications(response.messages);
                }
            } else {
                const errors = response.errors;
                if (errors) {
                    $.each(errors, function (key, val) {
                        const element = formElement.find('[data-name="' + key + '"]');
                        element.addClass('is-invalid');
                        element.closest('.input-group').append('<div class="invalid-feedback" style="display: block;">' + val[0] + '</div>');
                    });
                }
            }
        },
        error: function (response) {
            if (422 === response.status) {
                const errors = response.responseJSON.errors;
                if (errors) {
                    $.each(errors, function (key, val) {
                        const element = formElement.find('[data-name="' + key + '"]');
                        element.addClass('is-invalid');
                        element.closest('.input-group').append('<div class="invalid-feedback" style="display: block;">' + val[0] + '</div>');
                    });
                }
            }
        }
    });

});

$('body').on('change', 'form[data-confirmation] input, form[data-confirmation] select', function () {
    if (typeof $(this).closest('form').attr('data-confirmation')) {
        window.onbeforeunload = function() {
            return "Are You sure?";
        };
    }
});

$('body').on('click', '.modal-window .image-cropper .save', function (e) {
    const $_this = $(this);
    const cropperImg = $_this.closest('.image-cropper').find('.cropper-container').find('.cropper-img');
    const imgData = cropperImg.cropper('getCroppedCanvas').toDataURL();
    const field = $_this.closest('.image-cropper').attr('data-field');
    const fileImageContainer = $('.file-image[data-field="' + field + '"]');
    const imgContainer = fileImageContainer.find('.img-container');
    const img = imgContainer.find('img');
    img.attr('src', imgData)
        .attr('data-new', 'true');
    fileImageContainer.show();
    fileImageContainer.find('input[name="' + field + '"]').remove();
    fileImageContainer.append('<input type="hidden" name="' + field + '" value="' + imgData + '" />');
    const restoreButton = fileImageContainer.find('.restore-img');
    if ('none' !== restoreButton.css('display')) {
        restoreButton.trigger('click');
    }
    hideModal();
});

function closeCropper(field) {
    $('.file-image[data-field="' + field + '"]').closest('.field-row')
        .find('input[type=file]')
        .val(null)
        .trigger('change');
}

function initCropper(element, options) {
    if (!options) {
        options = {};
    }
    element.cropper(options);
    $(document.body).on('keydown', function (e) {
        if (!element.data('cropper') || this.scrollTop > 300) {
            return;
        }

        switch (e.which) {
            case 37:
                e.preventDefault();
                element.cropper('move', -1, 0);
                break;

            case 38:
                e.preventDefault();
                element.cropper('move', 0, -1);
                break;

            case 39:
                e.preventDefault();
                element.cropper('move', 1, 0);
                break;

            case 40:
                e.preventDefault();
                element.cropper('move', 0, 1);
                break;
        }
    });
}

function getExt(filename) {
    let ext = filename.split('.');
    ext = ext.reverse();
    return ext[0];
}
