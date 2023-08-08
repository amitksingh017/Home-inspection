<div class="kt-section">
    <h5>{{ $name }}</h5>
    <div class="kt-section__content">
        @if (!empty($value))
            @if(is_array($value))
                @foreach ($value as $row)
                    <div>
                        <a class="kt-link kt-font-bolder" href="{{ $row }}" target="_blank">
                            {{ $row }}
                        </a>
                    </div>
                @endforeach
            @else
                <a class="kt-link kt-font-bolder" href="{{ $value }}" target="_blank">
                    {{ $value }}
                </a>
            @endif
        @endif
    </div>
</div>
