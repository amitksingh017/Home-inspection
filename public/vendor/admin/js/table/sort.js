$('body').on('click', '.kt-datatable__cell--sort', function () {
    const $_this = $(this);
    const field = $_this.attr('data-sort-field');
    let direction = $_this.attr('data-current-direction');
    if ('' === direction) {
        direction = 'asc';
    } else if ('asc' === direction) {
        direction = 'desc';
    } else {
        direction = '';
    }
    const param = '' !== direction ? (field + '__' + direction) : '';
    //setUrl('sort', param);
    const formElement = $_this.closest('.card').find('.content_form');
    formElement.find('input[name=sort]').remove();
    formElement.append('<input type="hidden" name="sort" value="' + param + '" />');
    setTableParam('sort', param, getHash($_this), true);
});
