<div class="kt-section js-validation">
    <div class="kt-section__content">
        <label class="kt-checkbox">
            <input
                data-name="{{ $validationName }}"
                class="element_form"
                type="checkbox"
                name="{{ $field }}"
                @if(!empty(old($validationName) ?? $value))
                    checked
                @endif
            />
            {{ $name }}
            <span></span>
        </label>
    </div>
    @if($help)
        <span class="form-text text-muted">{{ $help }}</span>
    @endif
    @if ($errors->has($validationName))
        <div class="invalid-feedback" style="display: block;">
            {{ $errors->first($validationName) }}
        </div>
    @endif

</div>
