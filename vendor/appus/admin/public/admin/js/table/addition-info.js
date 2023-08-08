$('body').on('click', '.additional-row-button, .additional-modal-button', function (e) {
    e.preventDefault();
    const $_this = $(this);
    const field = $_this.closest('.additional-button-container').data('field');
    const index = $_this.data('index');
    const row = $_this.closest('table').find('tr[data-index="' + index + '"][data-field="' + field + '"]');

    if ($_this.hasClass('additional-row-button')) {
        if ('none' === row.css('display')) {
            row.slideDown();
        } else {
            row.slideUp();
        }
    }
    if ($_this.hasClass('additional-modal-button')) {
        getModal(row.html());
    }

});
