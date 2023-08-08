<div class="kt-section js-validation section-block">
    <h5>{{ $name }}</h5>
    <div class="kt-section__content">
        <div class="input-group">
            <textarea
                type="text"
                id="editor"
                data-name="{{ $validationName }}"
                class="element_form form-control @if ($errors->has($field)) is-invalid @endif"
                name="{{ $field }}"
                cols="30"
                rows="5"
            >{{ old($validationName) ?? $value }}</textarea>
        </div>
    </div>
    @if ($errors->has($validationName))
        <div class="invalid-feedback" style="display: block;">
            {{ $errors->first($validationName) }}
        </div>
    @endif

    @push('js')
        <script>
            $('#editor').summernote({
                height: 150,
                width: '100%',
                toolbar: [
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['height', ['height']]
                ]
            });
        </script>
    @endpush
</div>
