<div class="kt-section">
    <h5>{{ $name }}</h5>
    <div class="kt-section__content repeater-group">
        <div class="inputs-container-repeater">
            @if(!empty(old()))
                @foreach(old($validationName) as $key => $row)
                    <div class="input-group input-container-repeater js-validation">
                        <input
                            type="text"
                            data-name="{{ $validationName }}.{{ $key }}"
                            class="element_form form-control @if ($errors->has($validationName . '.' . $key)) is-invalid @endif"
                            name="{{ $field }}[{{ $key }}]"
                            value="{{ $row }}"
                        />
                        <a class="btn-sm btn btn-label-danger btn-bold repeater delete">
                            <i class="la la-trash-o"></i>
                            Delete
                        </a>
                        @if ($errors->has($validationName . '.' . $key))
                            <div class="invalid-feedback" style="display: block;">
                                {{ $errors->first($validationName . '.' . $key) }}
                            </div>
                        @endif
                    </div>
                @endforeach
            @elseif(!empty($value))
                @foreach($value as $key => $row)
                    <div class="input-group input-container-repeater">
                        <input
                            type="text"
                            data-name="{{ $validationName }}.id_{{ $key }}"
                            class="element_form form-control @if ($errors->has($field)) is-invalid @endif"
                            name="{{ $field }}[id_{{ $key }}]"
                            value="{{ old($validationName) ?? $row }}"
                        />
                        <a class="btn-sm btn btn-label-danger btn-bold repeater delete">
                            <i class="la la-trash-o"></i>
                            Delete
                        </a>
                    </div>
                @endforeach
            @else

                <div class="input-group input-container-repeater">
                    <input
                        type="text"
                        data-name="{{ $validationName }}.0"
                        data-new-id="0"
                        class="element_form form-control @if ($errors->has($field)) is-invalid @endif"
                        name="{{ $field }}[0]"
                        value="{{ old($validationName) ?? '' }}"
                    />
                    <a class="btn-sm btn btn-label-danger btn-bold delete">
                        <i class="la la-trash-o"></i>
                        Delete
                    </a>
                </div>
            @endif
        </div>
        <a class="btn btn-bold btn-sm btn-label-brand add">
            <i class="la la-plus"></i>
            Add
        </a>
    </div>
    @if($help)
        <span class="form-text text-muted">{{ $help }}</span>
    @endif

</div>
