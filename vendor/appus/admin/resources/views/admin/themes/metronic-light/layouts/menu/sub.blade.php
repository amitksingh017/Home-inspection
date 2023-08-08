<div class="kt-menu__submenu kt-menu__submenu--{{ $level ? 'right' : 'left' }} kt-menu__submenu--classic" style="width: 275px;">
    <span class="kt-menu__arrow"></span>
    <ul class="kt-menu__subnav">

        @if(empty($top))
            <li class="kt-menu__item  kt-menu__item--parent" aria-haspopup="true">
                <span class="kt-menu__link kt-menu__link--title">
                    <span class="kt-menu__link-text">{{ $parentItem->getName() }}</span>
                </span>
            </li>
        @endif

        @foreach ($parentItem->getSub() as $item)

            @if(!$item->if())
                @continue
            @endif

            <li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--bottom kt-menu__item--open-dropdown @if($item->isActive()) kt-menu__item--here kt-menu__item--open @endif"
                aria-haspopup="true"
                data-ktmenu-submenu-toggle="hover"
                data-ktmenu-dropdown-toggle-class="kt-aside-menu-overlay--on"
                style="text-align: center;"
            >
                <a
                    @if(!empty($item->getUrl()))
                        href="{{ $item->getUrl() }}"
                    @endif class="kt-menu__link"
                >
                    @if($item->getIcon())
                        <i class="kt-menu__link-icon {{ $item->getIcon() }}"></i>
                    @endif
                    <span class="kt-menu__link-text">{{ $item->getName() }}</span>
                    @if($item->hasSub())
                        <i class="kt-menu__ver-arrow la la-angle-right"></i>
                    @endif
                </a>

                @if($item->hasSub())
                    @include('admin::layouts.menu.sub', ['parentItem' => $item, 'level' => ++$level])
                @endif

            </li>
        @endforeach

    </ul>
</div>
