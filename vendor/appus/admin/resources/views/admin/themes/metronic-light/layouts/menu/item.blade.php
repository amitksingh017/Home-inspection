<li class="kt-menu__item kt-menu__item--submenu kt-menu__item--bottom kt-menu__item--open-dropdown kt-menu__item--rel @if($item->isActive()) kt-menu__item--here @endif main menu-item"
    aria-haspopup="true"
    data-ktmenu-submenu-toggle="hover"
    data-ktmenu-dropdown-toggle-class="kt-aside-menu-overlay--on"
>
    <a
        @if(!empty($item->getUrl()))
            href="{{ $item->getUrl() }}"
        @endif
        class="kt-menu__link menu-item-link"
        title="{{ $item->getName() }}"
    >
        <i class="kt-menu__link-icon {{ $item->getIcon() ?? 'fas fa-question' }} menu-item-link-icon"></i>
        <span class="kt-menu__link-text menu-item-link-text">{{ $item->getName() }}</span>

        @if(empty($top) && $item->isMinimizeText())
            <div class="menu-item-link-text-minimize">{{ $item->getName() }}</div>
        @endif

        @if($item->hasSub())
            <i class="kt-menu__ver-arrow la la-angle-right"></i>
            <i class="kt-menu__hor-arrow la la-angle-down"></i>
        @endif
    </a>

    @if($item->hasSub())
        @include('admin::layouts.menu.sub', ['parentItem' => $item, 'level' => 0])
    @endif

</li>
