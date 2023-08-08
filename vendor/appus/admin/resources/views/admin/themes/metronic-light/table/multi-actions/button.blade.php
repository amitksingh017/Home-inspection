<a
    class="kt-nav__link action-button @if($hideName || $hideInfo) has-title @endif"
    @if($hideName || $hideInfo)
        title="{{ $name }} On This Page"
    @endif
    data-confirmation="{{ $confirmation }}"
    style="{{ $style }}"
>
    @if(!$hideIcon)
        <i class="kt-nav__link-icon {{ $icon }}"></i>
    @endif
    <span class="kt-nav__link-text text">
        @if(!$hideName)
            <span class="name">{{ $name }}</span>
        @endif
        @if(!$hideInfo)
            <span class="page">On This Page</span>
            <span class="selected">Selected</span>
        @endif
    </span>
</a>
