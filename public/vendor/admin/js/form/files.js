$('body').on('change', '.file-field input[type=file]', function () {
    let file = this.files;
    const fileImageContainer = $(this).closest('.file-field').find('.file-image');
    const imgContainer = fileImageContainer.find('.img-container');
    const img = imgContainer.find('img');
    if (file.length > 0) {
        file = file[0];
        const ext = getExt(file.name);
        img.attr('src', imgContainer.attr('data-prefix') + ext + '.svg')
            .attr('data-new', 'true');
        fileImageContainer.show();
        const restoreButton = fileImageContainer.find('.restore-img');
        if ('none' !== restoreButton.css('display')) {
            restoreButton.trigger('click');
        }
    } else {
        img.removeAttr('data-new');
        const dataSrc = img.attr('data-src');
        console.log(dataSrc);
        if (dataSrc) {
            img.attr('src', dataSrc);
        } else {
            fileImageContainer.hide();
        }
    }
});

$('body').on('change', '.image-field input[type=file]', function () {
    let files = this.files;
    const $_this = $(this);
    const fileImageContainer = $_this.closest('.image-field').find('.file-image');
    const imgContainer = fileImageContainer.find('.img-container');
    const img = imgContainer.find('img');
    const field = fileImageContainer.attr('data-field');
    const cropper = $_this.attr('data-cropper');
    if (files.length > 0) {
        files = files[0];

        const reader = new FileReader();
        reader.onloadend = function () {
            const imgData = reader.result;
            if (cropper) {
                let html = '<div class="image-cropper" data-field="' + field + '">';

                html += '<div class="cropper-container">';
                html += '<img class="cropper-img" src="' + imgData + '" />';
                html += '</div>';

                html += '<button class="btn btn-success save modal-button">Save</button>';
                html += '<div class="text-center"><a class="cancel modal-button" onclick="closeCropper(`' + field + '`)">Cancel</a></div>';

                html += '</div>';
                getModal(html, function () {
                    let options = {};
                    const ratio = $_this.attr('data-ratio');
                    if (ratio) {
                        options.aspectRatio = ratio;
                    }
                    initCropper($('.cropper-img'), options);
                    $('.modal-shadow').attr('onclick', $('.modal-window').find('.cancel.modal-button').attr('onclick'));
                });
            } else {
                img.attr('src', imgData)
                    .attr('data-new', 'true');
                fileImageContainer.show();
                const restoreButton = fileImageContainer.find('.restore-img');
                if ('none' !== restoreButton.css('display')) {
                    restoreButton.trigger('click');
                }
            }
        };

        reader.readAsDataURL(files);

    } else {
        img.removeAttr('data-new');
        fileImageContainer.find('input[name="' + field + '"]').remove();
        const dataSrc = img.attr('data-src');
        if (dataSrc) {
            img.attr('src', dataSrc);
        } else {
            fileImageContainer.hide();
        }
    }
});

$('body').on('click', '.delete-img', function () {
    const confirmation = $(this).attr('data-confirmation');
    if (typeof confirmation !== 'undefined' && !confirm('Are you sure?')) {
        return false;
    }
    const container = $(this).closest('.file-image');
    const img = container.find('.img-container').find('img');
    if (img.attr('data-new')) {
        const fileElement = container.closest('.field-row').find('input[type=file]');
        fileElement.val(null).trigger('change');
    } else {
        container.addClass('deleted');
        const field = container.attr('data-field');
        container.find('input[name="' + field + '__delete"]').remove();
        container.append('<input type="hidden" name="' + field + '__delete" value="1" />');
    }
});

$('body').on('click', '.restore-img', function () {
    const container = $(this).closest('.file-image');
    container.removeClass('deleted');
    const field = container.attr('data-field');
    container.find('input[name="' + field + '__delete"]').remove();
});
