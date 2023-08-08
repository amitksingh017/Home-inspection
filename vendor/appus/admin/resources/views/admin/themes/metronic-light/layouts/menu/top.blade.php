<ul class="kt-menu__nav">
    @foreach ($topMenuItems as $item)
        @if($item->if())
            @include('admin::layouts.menu.item', ['top' => true])
        @endif
    @endforeach
</ul>
