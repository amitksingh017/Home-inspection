$('body').on('click', '.modal-window .cancel', function () {
    const callback = $(this).closest('.modal-window').attr('data-callback');
    hideModal(callback);
});

$('body').on('click', '.modal-shadow', function () {
    const callback = $(this).next('.modal-window').attr('data-callback');
    hideModal(callback);
});

function getModal(html, callback, closeCallback) {
    let modal = '<div class="modal-shadow"></div>';
    modal += '<div class="modal-window" ' + (closeCallback ? ('data-callback="' + closeCallback + '"') : '') + ' >';
    modal += html;
    modal += '</div>';
    $('body').append(modal);
    if (callback) {
        callback();
    }
}

function hideModal(callback) {
    $('.modal-window').remove();
    $('.modal-shadow').remove();
    if (callback) {
        if (typeof callback === 'function') {
            callback();
        } else {
            console.log(callback + ' is not a function');
        }
    }
}
