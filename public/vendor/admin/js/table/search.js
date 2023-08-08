$('body').on('keyup', '.generalSearch', function () {
    const $_this = $(this);
    const search = $_this.val();
    if (typeof searchTimerId !== 'undefined') {
        clearTimeout(searchTimerId);
    }
    searchTimerId = setTimeout(function () {
        $_this.closest('form').find('input[name="page"]').val(1);
        setTableParam('search', search, getHash($_this), false);
    }, 500);
});
