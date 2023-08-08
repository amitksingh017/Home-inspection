<div class="kt-section js-validation">
    <h5>{{ $name }}</h5>
    <div class="kt-section__content">
        <div class="input-group">
            <input type="color" class="form-control" name="{{ $field }}" value="{{ $value }}" />
        </div>
    </div>
    @if($help)
        <span class="form-text text-muted">{{ $help }}</span>
    @endif
    @if ($errors->has($validationName))
        <div class="invalid-feedback" style="display: block;">{{ $errors->first($validationName) }}</div>
    @endif
</div>

