<div class="kt-section js-validation section-block">
    <h5>{{ $name }}</h5>
    <div class="kt-section__content">
        <div class="input-group">
            <textarea
                type="text"
                data-name="{{ $validationName }}"
                class="element_form form-control @if ($errors->has($field)) is-invalid @endif @if($symbolsCounter) symbols-counter-input @endif"
                name="{{ $field }}"
            >{{ old($validationName) ?? $value }}</textarea>
        </div>
    </div>
    @if($symbolsCounter)
        <span
            class="form-text text-muted symbols-counter"
            @if($symbolsCountMin)
                data-min="{{ $symbolsCountMin }}"
            @endif
            @if($symbolsCountMax)
                data-max="{{ $symbolsCountMax }}"
            @endif
        >
            Symbols:
            @if($symbolsCountMin)
                <span class="min">{{ $symbolsCountMin }}</span>
                /
            @endif
            <span class="current">{{ strlen(old($validationName) ?? $value) }}</span>
            @if($symbolsCountMax)
                /
                <span class="max">{{ $symbolsCountMax }}</span>
            @endif
        </span>
    @endif
    @if($help)
        <span class="form-text text-muted">{{ $help }}</span>
    @endif
    @if ($errors->has($validationName))
        <div class="invalid-feedback" style="display: block;">
            {{ $errors->first($validationName) }}
        </div>
    @endif
</div>
