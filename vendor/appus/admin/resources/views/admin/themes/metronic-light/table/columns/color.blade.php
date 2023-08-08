@if (!empty($value))
    <span
        class="kt-badge kt-badge--primary  kt-badge--inline kt-badge--pill @if($isWithText) badge-with-text @endif"
        style="background: {{ $value }};"
    >
        @if($isWithText)
            {{ $value }}
        @endif
    </span>
@endif
