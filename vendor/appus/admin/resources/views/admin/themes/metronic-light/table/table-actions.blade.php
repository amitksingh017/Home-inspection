@if ($tableActions)
    @if ($isHiddenTableActions)
        <div class="dropdown dropdown-inline">
            <button type="button" class="btn btn-clean btn-sm btn-icon btn-icon-md" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="flaticon-more-1"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-right dropdown-menu-md dropdown-menu-fit" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-227px, 33px, 0px);">
                <ul class="kt-nav">
                    @foreach($tableActions as $action)
                        @if (!$action->isDisabled())
                            <li class="kt-nav__item">
                                <a
                                    @if($action->getUrl())
                                        href="{{ $action->getUrl() }}"
                                    @endif
                                    class="kt-nav__link {{ $action->getCssClasses() }}"
                                >
                                    {!! $action->render() !!}
                                    <span class="kt-nav__link-text">
                                        {{ $action->getName() }}
                                    </span>
                                </a>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </div>
        </div>
    @else
        @foreach($tableActions as $action)
            @if (!$action->isDisabled())
                <a
                    class="action {{ $action->getCssClasses() }}"
                    @if($action->getUrl())
                        href="{{ $action->getUrl() }}"
                    @endif
                    title="{{ $action->getName() }}"
                >
                    {!! $action->render() !!}
                </a>
            @endif
        @endforeach
    @endif
@endif
