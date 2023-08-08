<div class="kt-section js-validation">
    <h5>{{ $name }}</h5>
    <div class="kt-section__content">
        <div class="input-group">
            <textarea
                type="text"
                data-name="{{ $validationName }}"
                class="element_form md-input form-control @if ($errors->has($field)) is-invalid @endif"
                data-provide="markdown"
                name="{{ $field }}"
            >{{ old($validationName) ?? $value }}</textarea>
        </div>
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
