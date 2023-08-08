<div class="kt-section js-validation">
    <h5>{{ $name }}</h5>
    <div class="kt-section__content">
        <div class="field" data-name="{{ $validationName }}">
            <select
                class="form-control kt-select2 select2-hidden-accessible"
                multiple
                name="{{ $field }}"
                style="width: 100%;"
            >
                @if(!empty($options))
                    @foreach($options as $key => $option)
                        <option
                            value="{{ $key }}"
                            @if(!empty(old($validationName)[$key] ?? in_array($key, $value)))
                                selected
                            @endif
                        >
                            {{ $option }}
                        </option>
                    @endforeach
                @endif
            </select>
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
        $('select[name="' + {!! json_encode($field) !!} + '"]').select2();
    </script>
@endpush
