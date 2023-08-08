@if ($filters)
    <div class="col-md-6 filters" style="display: inline-block;">
        @if (!$isHiddenFilterToMenu)
            @foreach ($filters as $filter)
                <div class="col-md-4 kt-margin-b-20-tablet-and-mobile card-filter filter inline filter-element" data-key="{{ $filter->getClassNameHash() }}">
                    {!! $filter->render() !!}
                </div>
            @endforeach
        @else
            <div class="kt-portlet__head-toolbar show  card-filter filter block float-right" style="position: relative;">
                <a class="btn btn-label-brand btn-bold btn-sm dropdown-toggle filter-button" title="Filter">
                    <i class="fas fa-filter"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-fit dropdown-menu-right filter-list" x-placement="right-end" style="position: absolute; will-change: transform; top: 100%; right: 0px; left: unset;">
                    <ul class="kt-nav">
                        <li class="kt-nav__head">
                            Filters
                        </li>
                        <li class="kt-nav__separator"></li>
                        @foreach ($filters as $filter)
                            <div class="filter-row filter-element" data-key="{{ $filter->getClassNameHash() }}">
                                {!! $filter->render() !!}
                            </div>
                            <li class="kt-nav__separator"></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
    </div>
@endif
