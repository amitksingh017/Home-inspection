$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$('body').on('click', '.menu-button', function () {
    const bodyElement = $('body');
    if (bodyElement.hasClass('kt-aside--minimize')) {
        bodyElement.removeClass('kt-aside--minimize');
    } else {
        bodyElement.addClass('kt-aside--minimize');
    }
});

function hamburgerAnimation() {
    const openButton = $('.menu-button .full-button[data-action="open"]');
    const closeButton = $('.menu-button .full-button[data-action="close"]');
    const openButtonVisibility = openButton.css('display') !== 'none';
    const closeButtonVisibility = closeButton.css('display') !== 'none';
    if (!openButtonVisibility && !closeButtonVisibility) {
        return false;
    }
    let firstElement,
        secondElement;
    if (openButtonVisibility) {
        firstElement = openButton.find('.first-arrow');
        secondElement = openButton.find('.second-arrow');
    } else if (closeButtonVisibility) {
        firstElement = closeButton.find('.first-arrow');
        secondElement = closeButton.find('.second-arrow');
    }
    firstElement.css('color', '#000');
    setTimeout(function () {
        firstElement.css('color', 'inherit');
        secondElement.css('color', '#000');
        setTimeout(function () {
            secondElement.css('color', 'inherit');
            hamburgerAnimation();
        }, 400);
    }, 400);
}

function alertMod(title, text) {
    new Swal({
        title: title,
        text: text,
        confirmButtonText: 'Ok'
    });
}

function getSpinner(container) {
    const html = '<div class="kt-spinner kt-spinner--sm kt-spinner--brand custom_spinner"></div>';
    container.append('<table class="full-size"><tr><td>' + html + '</td></tr></table>');
}

function setUrl(name, value) {
    const location = window.location;
    const url = location.origin + location.pathname;
    let params = location.search;
    let newParams = [];
    let searched = false;
    if ('' !== params) {
        params = params.slice(1);
        params = params.split('&');

        $.each(params, function (key, val) {
            let param = val.split('=');
            let paramName = param[0];
            let paramValue = param[1];
            if (name === paramName) {
                searched = true;

                if ('' !== value) {
                    paramValue = value;
                } else {
                    paramValue = '';
                }

            }

            if ('' !== paramValue) {
                newParams.push(paramName + '=' + paramValue);

            }

        });
    }

    newParams = newParams.join('&');

    if (!searched) {
        newParams += (newParams.length > 0) ? ('&' + name + '=' + value) : (name + '=' + value);
    }

    history.pushState(null, null, url + (newParams !== '' ? '?' + newParams : ''));
}
