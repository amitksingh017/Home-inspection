<div class="kt-section js-validation">
    <h5>{{ $name }}</h5>
    <div class="kt-section__content">
        <div class="input-group">
            <input
                type="range"
                data-name="{{ $validationName }}"
                class="element_form custom-range @if ($errors->has($field)) is-invalid @endif"
                name="{{ $field }}"
                value="{{ old($validationName) ?? ($value ?? $min) }}"
                min="{{ $min }}"
                max="{{ $max }}"
                step="{{ $step }}"
            />
            <span class="range-value">
                {{ old($validationName) ?? ($value ?? $min) }}
            </span>
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

@push('js')
    <script>
        $('body').on('change', '.custom-range[name="' + {!! json_encode($field) !!} + '"]', function () {
            $(this).next('.range-value').text($(this).val());
        });
    </script>
@endpush
