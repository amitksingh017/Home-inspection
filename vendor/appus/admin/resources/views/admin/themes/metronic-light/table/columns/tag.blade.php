@if (!empty($value))
    @foreach ($value as $tag)
        <span class="kt-badge kt-badge--primary  kt-badge--inline kt-badge--pill" style="background: {{ $color }};">
            {{ $tag }}
        </span>
    @endforeach
@endif