@if ($multiActions)
    <div
        class="kt-portlet__head-toolbar show multi-actions-container card-filter filter block float-left @if($isHiddenMultiActionsToMenu) minimized @endif @if($isHiddenMultiActionsWhenUnselected) hidden-multi-actions @endif"
        style="position: relative;"
    >
        <a class="btn btn-label-brand btn-bold btn-sm dropdown-toggle filter-button" title="Multi Actions">
            <i class="fas fa-play"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-fit dropdown-menu-right filter-list"
             x-placement="right-end"
             style=" will-change: transform; top: 100%; left: 0px; left: unset;"
        >
            <ul class="kt-nav multi-actions" data-type="page" data-action="{{ route('multi-action.run') }}">
                <li class="kt-nav__head">
                    Multi Actions
                </li>
                <li class="kt-nav__separator"></li>
                @foreach ($multiActions as $multiAction)
                    <li class="kt-nav__item multi-action"
                        data-id="{{ $multiAction->getKey() }}"
                        data-key="{{ $multiAction->getModelName() }}"
                        data-title="{{ $multiAction->getName() }}"
                    >
                        {!! $multiAction->render() !!}
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endif
