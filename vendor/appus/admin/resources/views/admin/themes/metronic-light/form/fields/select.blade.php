<div class="field-row js-validation">
    <div class="kt-section">
        <h5>{{ $name }}</h5>
        <div class="kt-form__group kt-form__group--inline">
            <div class="kt-form__control">
                <select
                    name="{{ $field }}"
                    class="selectpicker"
                    data-name="{{ $validationName }}"
                >
                    @if($options)
                        @foreach ($options as $key => $option)
                            <option
                                @if($key == $value)
                                    selected
                                @endif
                                value="{{ $key }}">
                                {{ $option }}
                            </option>
                        @endforeach
                    @endif
                </select>
            </div>

            @if($help)
                <span class="form-text text-muted">{{ $help }}</span>
            @endif

        </div>
    </div>

    @if ($errors->has($validationName))
        <div class="invalid-feedback" style="display: block;">
            {{ $errors->first($validationName) }}
        </div>
    @endif
</div>
