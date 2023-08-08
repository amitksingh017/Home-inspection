<div class="kt-section">
    <h5>{{ $name }}</h5>
    <div class="kt-section__content">
        @if (!empty($value))
            @if(is_array($value))
                @foreach($value as $index => $row)
                    @include('admin::details.fields.file_item', ['value' => $row, 'ext' => $ext[$index]])
                @endforeach
            @else
                @include('admin::details.fields.file_item')
            @endif
        @else
            No {{ $name }} yet
        @endif
    </div>
</div>
