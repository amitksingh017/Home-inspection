<div class="progress-container vertical-center">
    @foreach ($data as $key => $row)
        <div class="progress-metric">
            @if(!empty($label[$key]))
                <span class="kt-widget12__desc">
                    {{ $label[$key] }}
                </span>
            @endif
            <span class="kt-widget12__stat float-right">
                {{ $row }}%
            </span>
            <div class="kt-widget12__progress">
                <div class="progress kt-progress--sm">
                    <div
                        class="progress-bar kt-bg-brand"
                        role="progressbar"
                        style="width: {{ $row }}%; @if(!empty($color[$key])) background: {{ $color[$key] }} !important;  @endif"
                        aria-valuenow="100"
                        aria-valuemin="0"
                        aria-valuemax="100"
                    ></div>
                </div>
            </div>
        </div>
    @endforeach
</div>
