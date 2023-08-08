<div class="kt-form__group kt-form__group--inline">
    <div class="kt-form__label filter-label">
        <label>{{ $name }}:</label>
    </div>
    <div class="kt-form__control filter-item">
        <select name="filter[{{ $key }}]" class="selectpicker">
            <option value>All</option>
            @if($options)
                @foreach ($options as $key => $option)
                    <option value="{{ $key }}">{{ $option }}</option>
                @endforeach
            @endif
        </select>
    </div>
</div>
