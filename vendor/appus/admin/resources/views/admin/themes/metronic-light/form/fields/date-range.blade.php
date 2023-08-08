<div class="kt-section js-validation">
    <h5>{{ $name }}</h5>
    <div class="kt-section__content">
        <div class="input-group">
            <input
                type="text"
                data-name="{{ $validationName }}"
                class="element_form daterangepicker-input form-control @if ($errors->has($field)) is-invalid @endif"
                name="{{ $field }}"
                value="{{ old($validationName) ?? $value }}"
                readonly
            />
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
        $('.daterangepicker-input[name="' + {!! json_encode($field) !!} + '"]').daterangepicker({
            timePicker: {!! json_encode($showTime) !!},
            timePicker24Hour: true,
            timePickerSeconds: true,
            showDropdowns: true
        });
    </script>
@endpush
