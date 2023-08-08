<div class="d-inline-block">

    <img src="{{ $value }}"
         alt="{{ $name }}"
         style="border-radius: 50%;
             @if($styles)
                 @foreach ($styles as $attr => $attrValue)
                    {{ $attr }}: {{ $attrValue }};
                 @endforeach
             @endif
         "
    />

    @if($displayWithUrl)
        <div class="url">
            {{ $value }}
        </div>
    @endif

    @if($downloadable)
        <div class="download">
            <a href="{{ $value }}">
                <i class="fas fa-download"></i>
                Download
            </a>
        </div>
    @endif

</div>
