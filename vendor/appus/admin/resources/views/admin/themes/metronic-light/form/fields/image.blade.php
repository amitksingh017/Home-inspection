<div class="field-row image-field js-validation">
    <div class="kt-section">
        <h5>{{ $name }}</h5>
        <div class="kt-form__group kt-form__group--inline">
            <div class="kt-form__control">
                <div class="custom-file input-group">
                    <input type="file"
                           accept="image/jpeg,image/jpg,image/png,image/gif"
                           class="custom-file-input @if ($errors->has($field)) is-invalid @endif"
                           id="customFile"
                           @if($cropper) data-cropper="true" @endif
                           @if(!$cropper) name="{{ $field }}" @endif
                           @if($cropperRatio) data-ratio="{{ $cropperRatio }}" @endif
                           data-name="{{ $validationName }}"
                    />
                    <label class="custom-file-label" for="customFile">Choose file</label>
                </div>
            </div>
        </div>

        @if($help)
            <span class="form-text text-muted">{{ $help }}</span>
        @endif

        <div class="file-image" style=" @if(!$value) display: none; @endif " data-field="{{ $field }}">
            <div class="img-container" data-prefix="/vendor/admin/themes/{{ _ADMIN_THEME_ }}/img/files/">
                <img data-src="@if($value){{ $value }}@endif"
                     src="@if($value){{ $value }}@endif"
                     alt="{{ $name }}"
                />
                <i class="far fa-trash-alt"></i>
            </div>
            <a class="delete-img" title="Delete">
                <i class="fas fa-times"></i>
            </a>
            <a class="restore-img" title="Restore">
                <i class="fas fa-redo-alt"></i>
            </a>
        </div>

        @if($downloadable && $value)
            <div class="download">
                <a href="{{ $value }}" target="_blank">
                    <i class="fas fa-download"></i>
                    Download
                </a>
            </div>
        @endif

    </div>

    @if ($errors->has($validationName))
        <div class="invalid-feedback" style="display: block;">
            {{ $errors->first($validationName) }}
        </div>
    @endif
</div>
