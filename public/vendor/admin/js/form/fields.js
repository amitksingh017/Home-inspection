$('body').on('click', '.repeater-group .add', function () {
    const container = $(this).closest('.repeater-group').find('.inputs-container-repeater');
    const inputElement = container.find('.input-container-repeater').first();
    const inputCopy = inputElement.clone();
    const element = inputCopy.find('.element_form');
    const newElements = container.find('.element_form[data-new-id]');
    let newIndex = 0;
    if (newElements.length > 0) {
        newElements.each(function () {
            const newId = parseInt($(this).attr('data-new-id'));
            if (newId > newIndex) {
                newIndex = newId;
            }
        });
        newIndex++;
    }
    element.attr('name', element.attr('name').substr(0, element.attr('name').indexOf('[')) + '[' + newIndex + ']');
    let validationName = element.attr('data-name');
    validationName = validationName.split('.').reverse();
    validationName[0] = newIndex;
    validationName = validationName.reverse().join('.');
    element.attr('data-name', validationName);
    element.attr('data-new-id', newIndex);
    element.val('');
    container.append(inputCopy);
});

$('body').on('click', '.repeater-group .delete', function () {
    if (typeof $(this).attr('data-confirmation') && !confirm('Are you sure?')) {
        return false;
    }
    const container = $(this).closest('.input-container-repeater');
    const fieldsCount = container.closest('.inputs-container-repeater')
        .find('.input-container-repeater')
        .length;
    if (fieldsCount < 2) {
        notification('You can not delete last row', 'warning');
        return false;
    }
    
    container.remove();
});

$('body').on('keyup', '.symbols-counter-input', function () {
    const counter = $(this).closest('.section-block').find('span.symbols-counter');
    const symbolsCounterCurrent = counter.find('.current');
    const currentCount = $(this).val().length;
    symbolsCounterCurrent.text(currentCount);
    const maxCount = counter.attr('data-max');
    if (typeof maxCount !== 'undefined') {
        if (parseInt(maxCount) < parseInt(currentCount)) {
            counter.addClass('exceeded-limit');
        } else {
            counter.removeClass('exceeded-limit');
        }
    }
    const minCount = counter.attr('data-min');
    if (typeof minCount !== 'undefined') {
        if (parseInt(minCount) > parseInt(currentCount)) {
            counter.addClass('exceeded-limit');
        } else {
            if (typeof maxCount !== 'undefined') {
                if (parseInt(maxCount) >= parseInt(currentCount)) {
                    counter.removeClass('exceeded-limit');
                }
            } else {
                counter.removeClass('exceeded-limit');
            }
        }
    }
});
