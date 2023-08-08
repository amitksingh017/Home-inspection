<div class="kt-section">

    @if(!$isLabelHidden)
        <h5>{{ $name }}</h5>
    @endif

    <div class="kt-section__content">

        @if (!empty($value))
            @if(is_array($value))
                @foreach($value as $index => $row)
                    @include('admin::details.fields.image_item', ['value' => $row])
                @endforeach
            @else
                @include('admin::details.fields.image_item')
            @endif
        @else
            No {{ $name }} yet
        @endif

    </div>
</div>
