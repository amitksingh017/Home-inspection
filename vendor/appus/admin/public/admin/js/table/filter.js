$('body').on('change', '.card-filter select', function () {
    const $_this = $(this);
    const value = $_this.val();
    const name = $_this.attr('name');
    setTableParam('name', value, getHash($_this), false);
});

$('body').on('click', '.filter-button', function () {
    const select = $(this).next('.filter-list');
    if (select.hasClass('show')) {
        select.removeClass('show');
    } else {
        select.addClass('show');
    }
});

initDateRange();

function initDateRange() {
    let options = {
        timePicker: false,
        timePicker24Hour: true,
        timePickerSeconds: true,
        showDropdowns: true,
        autoUpdateInput: false,
        locale: {
            cancelLabel: 'Clear'
        },
        drops: 'up'
    };
    const element = $('.filter-item .daterangepicker-input');

    element.daterangepicker(options);
    element.on('apply.daterangepicker', function(ev, picker) {
        const $_this = $(this);
        let format = $_this.attr('data-format');
        if (!format) {
            format = 'MM/DD/YYYY';
        }
        $_this.val(picker.startDate.format(format) + ' - ' + picker.endDate.format(format));
        setTableParam($_this.attr('name'), $_this.val(), getHash($_this), false);
    });
    element.on('cancel.daterangepicker', function(ev, picker) {
        const $_this = $(this);
        $_this.val('');
        setTableParam($_this.attr('name'), '', getHash($_this), false);
    });
}


