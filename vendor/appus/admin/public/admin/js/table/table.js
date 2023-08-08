$('body').on('submit', '.content_form', function (e) {
    e.preventDefault();
});

function getHash(element)  {
    return element.closest('.card')
        .find('form.content_form')
        .attr('data-hash');
}
function getContent(hash) {
    let url = location.href;
    const formElement = $('.content_form[data-hash=' + hash + ']');
    const form = formElement.serialize();
    $.get(url, form, function (response) {
        formElement.closest('.card').find('.content_body').html(response);
    });
}
function setTableParam(name, value, hash, isHidden) {
    if (isHidden) {
        const formElement = $('.content_form[data-hash=' + hash + ']');
        formElement.find('input[name="' + name + '"]').remove();
        formElement.append('<input type="hidden" name="' + name + '" value="' + value + '" />');
    }
    getContent(hash);
}


