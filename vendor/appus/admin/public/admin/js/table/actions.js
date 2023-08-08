$('body').on('click', '.actions .action', function (e) {
    const $_this = $(this);
    const form = $_this.find('form');
    if (form.length > 0) {
        e.preventDefault();
        form.attr('action', $_this.attr('href'));
        const confirmationMessage = form.attr('data-confirmation');
        const message = confirmMod(function () {
            form.submit();
        }, confirmationMessage ? confirmationMessage : 'undefined');
    }
});

async function confirmMod(successCallback, message) {

    if ('undefined' === message) {
        message = 'Do you want to delete?';
    }

    return await new Swal({
        title: 'Are you sure?',
        text: message,
        type: 'warning',
        confirmButtonText: 'Yes',
        cancelButtonText: 'No',
        showCloseButton: true,
        showCancelButton: true
    }).then((result) => {
        if (result.value) {
            successCallback();
        }
    });
}
