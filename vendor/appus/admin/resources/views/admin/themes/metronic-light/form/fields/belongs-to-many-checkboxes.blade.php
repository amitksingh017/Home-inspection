<div class="kt-section js-validation">
    <h5>{{ $name }}</h5>
    <div class="kt-section__content">
        <div class="field" data-name="{{ $validationName }}">
            @if(!empty($options))
                @foreach($options as $key => $option)
                    <label class="kt-checkbox">
                        <input
                            class="element_form"
                            type="checkbox"
                            name="{{ $field }}[{{ $key }}]"
                            @if(!empty(old($validationName)[$key] ?? in_array($key, $value)))
                                checked
                            @endif
                            value="{{ $key }}"
                        />
                        {{ $option }}
                        <span></span>
                    </label>
                    <br />
                @endforeach
            @endif
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
