<div class="kt-portlet kt-portlet--mobile metric-item" style="width: {{ $width }}%;" data-key="{{ $key  }}">
    <form method="POST" action="{{ route('metric') }}" class="metric-form">
        @if(!empty($filters))
            <div class="metric-filter filter">
                <a class="btn btn-label-brand btn-bold btn-sm dropdown-toggle filter-button">
                    <i class="fas fa-filter"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-fit dropdown-menu-right filter-list" x-placement="right-end" style="position: absolute; will-change: transform; top: 100%; right: 0px; left: unset;">
                    <ul class="kt-nav">
                        <li class="kt-nav__head">
                            Filters
                        </li>
                        <li class="kt-nav__separator"></li>
                        @foreach ($filters as $filter)
                            <div class="filter-row">
                                {!! $filter->render() !!}
                            </div>
                            <li class="kt-nav__separator"></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
        <input type="hidden" name="key" value="{{ $key  }}" />
    </form>

    <h5>{{ $name }}</h5>
    <div class="content">
        @push('js')
            <script>
                $(document).ready(function () {
                    getMetric(<?=json_encode($key); ?>);
                });
            </script>
        @endpush
    </div>
</div>
