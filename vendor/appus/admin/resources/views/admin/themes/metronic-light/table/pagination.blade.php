<div class="kt-datatable__pager kt-datatable--paging-loaded">

    <ul class="kt-datatable__pager-nav">
        @if ($paginator->hasPages())
            @if ($paginator->onFirstPage())
                <li>
                    <a title="First" class="kt-datatable__pager-link kt-datatable__pager-link--first kt-datatable__pager-link--disabled" disabled="disabled">
                        <i class="flaticon2-fast-back"></i>
                    </a>
                </li>
            @else
                <li>
                    <a title="First" class="kt-datatable__pager-link kt-datatable__pager-link--first" data-page="1">
                        <i class="flaticon2-fast-back"></i>
                    </a>
                </li>
            @endif

            @if ($paginator->onFirstPage())
                <li>
                    <a title="Previous" class="kt-datatable__pager-link kt-datatable__pager-link--prev kt-datatable__pager-link--disabled" disabled="disabled">
                        <i class="flaticon2-back"></i>
                    </a>
                </li>
            @else
                <li>
                    <a title="Previous" class="kt-datatable__pager-link kt-datatable__pager-link--prev" data-page="{{ $paginator->currentPage() - 1 }}">
                        <i class="flaticon2-back"></i>
                    </a>
                </li>
            @endif


            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li>
                        <span>{{ $element }}</span>
                    </li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li>
                                <a class="kt-datatable__pager-link kt-datatable__pager-link-number kt-datatable__pager-link--active" title="{{ $page }}">
                                    {{ $page }}
                                </a>
                            </li>
                        @else
                            <li>
                                <a class="kt-datatable__pager-link kt-datatable__pager-link-number" data-page="{{ $page }}" title="{{ $page }}">
                                    {{ $page }}
                                </a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <li>
                    <a title="Next" class="kt-datatable__pager-link kt-datatable__pager-link--next" data-page="{{ $paginator->currentPage() + 1 }}">
                        <i class="flaticon2-next"></i></a>
                </li>
            @else
                <li>
                    <a title="Next" class="kt-datatable__pager-link kt-datatable__pager-link--next kt-datatable__pager-link--disabled" disabled="disabled">
                        <i class="flaticon2-next"></i></a>
                </li>
            @endif

            @if ($paginator->hasMorePages())
                <li>
                    <a title="Last" class="kt-datatable__pager-link kt-datatable__pager-link--last" data-page="{{ $paginator->lastPage() }}">
                        <i class="flaticon2-fast-next"></i>
                    </a>
                </li>
            @else
                <li>
                    <a title="Last" class="kt-datatable__pager-link kt-datatable__pager-link--last kt-datatable__pager-link--disabled" disabled="disabled">
                        <i class="flaticon2-fast-next"></i>
                    </a>
                </li>
            @endif
        @endif
    </ul>

    <div class="kt-datatable__pager-info">

        <span class="kt-datatable__pager-detail">Showing {{ $paginator->firstItem() }} - {{ $paginator->lastItem() }} of {{ $paginator->total() }}</span>

        <div class="dropdown bootstrap-select item-per-page" style="width: 60px; margin-left: 25px;">
            <button type="button" class="btn dropdown-toggle btn-light" data-toggle="dropdown" role="combobox" aria-owns="bs-select-1" aria-haspopup="listbox" aria-expanded="false" title="Select page size">
                <div class="filter-option">
                    <div class="filter-option-inner">
                        <div class="filter-option-inner-inner item-per-page-current">{{ $paginator->perPage() }}</div>
                    </div>
                </div>
            </button>
            <div class="dropdown-menu" x-placement="top-start" style="max-height: 309.5px; overflow: hidden; min-height: 144px; position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, -1px, 0px);">
                <div class="inner show" role="listbox" id="bs-select-1" tabindex="-1" aria-activedescendant="bs-select-1-0" style="max-height: 283.5px; overflow-y: auto; min-height: 118px;">
                    <ul class="dropdown-menu inner show" role="presentation" style="margin-top: 0px; margin-bottom: 0px;">
                        @foreach ($itemPerPageOptions as $option)
                            <li class="@if($option == $paginator->perPage()) selected @endif">
                                <a role="option" class="dropdown-item" id="bs-select-1-0" tabindex="0" aria-setsize="5" aria-posinset="1" aria-selected="true">
                                    <span class="text">{{ $option }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

    </div>
</div>
