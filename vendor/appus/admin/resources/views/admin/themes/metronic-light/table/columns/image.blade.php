<div class="table-img">
    <img src="{{ $value }}" style="
        @if($styles)
            @foreach ($styles as $attr => $attrValue)
                {{ $attr }}: {{ $attrValue }};
            @endforeach
        @endif
            " />
</div>