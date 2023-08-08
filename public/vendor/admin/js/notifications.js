$('body').on('mouseenter', '.notifications .alert', function () {
    const $_this = $(this);
    const intervalId = $_this.attr('data-id');
    clearTimeout(intervalId);
});

$('body').on('mouseleave', '.notifications .alert', function () {
    const $_this = $(this);
    const intervalId = $_this.attr('data-id');
    if (intervalId) {
        const intervalId = setTimeout(function () {
            $_this.fadeOut(1000, function () {
                $_this.remove();
            });
        }, 1500);
        $_this.attr('data-id', intervalId);
    }
});

function notification(text, type) {
    if ('undefined' === typeof type) {
        type = 'success';
    }
    const notificationsContainer = $('.notifications');
    let html = '<div role="alert" class="alert alert-dismissible alert-' + type + '">';
    html += text;
    html += '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
    html += '</div>';
    notificationsContainer.append(html);
    const message = notificationsContainer.find('.alert:last-child');
    const intervalId = setTimeout(function () {
        message.fadeOut(1000, function () {
            message.remove();
        });
    }, 3000);
    message.attr('data-id', intervalId);
}

function notifications(messages) {
    if (messages) {
        $.each(messages, function (key, val) {
            notification(val.text, val.type);
        });
    }
}
