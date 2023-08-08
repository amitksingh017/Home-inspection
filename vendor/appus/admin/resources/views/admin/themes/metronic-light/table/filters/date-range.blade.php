<div class="kt-form__group kt-form__group--inline">
    <div class="kt-form__label filter-label">
        <label>{{ $name }}:</label>
    </div>
    <div class="kt-form__control filter-item">
        <input
            type="text"
            class="daterangepicker-input form-control"
            name="filter[{{ $key }}]"
            value="{{ $selected ?? '' }}"
            @if(!empty($format))
                data-format="{{ $format }}"
            @endif
            readonly
        />
    </div>
</div>
