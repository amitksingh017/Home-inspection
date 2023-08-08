<ul class="kt-menu__nav">
    @foreach ($menuItems as $item)
        @if($item->if())
            @include('admin::layouts.menu.item')
        @endif
    @endforeach
</ul>
