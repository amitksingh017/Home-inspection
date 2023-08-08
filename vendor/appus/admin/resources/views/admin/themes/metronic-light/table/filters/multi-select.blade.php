<div class="kt-form__group kt-form__group--inline" style="min-width: 220px;">
    <div class="kt-form__label filter-label">
        <label>{{ $name }}:</label>
    </div>
    <div class="kt-form__control filter-item">
        <select
            multiple
            name="filter[{{ $key }}][]"
            class="multiselect"
            style="width: 100%;"
        >
            @if($options)
                @foreach ($options as $key => $option)
                    <option
                        @if ($key === $selected)
                            selected
                        @endif
                        value="{{ $key }}">{{ $option }}
                    </option>
                @endforeach
            @endif
        </select>
    </div>
</div>

@push('js')
    <script>
        $('.multiselect').select2({
            placeholder: "All"
        });
    </script>
@endpush
