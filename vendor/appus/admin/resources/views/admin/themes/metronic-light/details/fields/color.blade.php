<div class="kt-section">
    <h5>{{ $name }}</h5>
    <div class="kt-section__content">
        @if (!empty($value))
            @if(is_array($value))
                @foreach ($value as $row)
                    <div>
                        <span
                            class="kt-badge kt-badge--primary  kt-badge--inline kt-badge--pill @if($isWithText) badge-with-text @endif"
                            style="background: {{ $row }};"
                        >
                            @if($isWithText)
                                {{ $row }}
                            @endif
                        </span>
                    </div>
                @endforeach
            @else
                <span
                    class="kt-badge kt-badge--primary  kt-badge--inline kt-badge--pill @if($isWithText) badge-with-text @endif"
                    style="background: {{ $value }};"
                >
                    @if($isWithText)
                        {{ $row }}
                    @endif
                </span>
            @endif
        @endif
    </div>
</div>
