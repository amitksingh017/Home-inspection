$('body').on('click', '.kt-datatable__pager-link', function () {
    const $_this = $(this);
    const page = $_this.data('page');
    if ('undefined' !== typeof page) {
        //setUrl('page', page);
        const formElement = $_this.closest('.card').find('.content_form');
        formElement.find('input[name=page]').remove();
        if (page > 1) {
            formElement.append('<input type="hidden" name="page" value="' + page + '" />');
        }
        setTableParam('page', page, getHash($_this), true);
    }
});

$('body').on('click', '.item-per-page a', function () {
    const $_this = $(this);
    const listItem = $_this.closest('li');
    if (!listItem.hasClass('selected')) {
        const value = $_this.find('.text').text().trim();
        const listItems = $_this.closest('ul');
        $_this.closest('.item-per-page').find('.item-per-page-current').text(value);
        listItems.find('li').removeClass('selected');
        listItem.addClass('selected');
        setTableParam('itemPerPage', value, getHash($_this), true);
    }
});
