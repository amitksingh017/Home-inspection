<div
    class="dropdown action-button"
    data-type="select"
    style="height: 35px;"
    data-confirmation="{{ $confirmation }}"
>
    <button
        class="btn btn-secondary dropdown-toggle  @if($hideName || $hideInfo) has-title @endif"
        type="button"
        id="dropdownMenuButton"
        data-toggle="dropdown"
        aria-haspopup="true"
        aria-expanded="false"
        @if($hideName || $hideInfo)
            title="{{ $name }} On This Page"
        @endif
        style="{{ $style }}"
    >
        @if(!$hideIcon)
            <i class="{{ $icon }}"></i>
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
    </button>
    @if(!empty($options))
        <div class="dropdown-menu options" aria-labelledby="dropdownMenuButton">
            @foreach($options as $optionKey => $optionName)
                <a
                    class="dropdown-item option"
                    data-option="{{ $optionKey }}"
                    href="#"
                    data-toggle="kt-tooltip"
                    title=""
                    data-placement="right"
                    data-skin="dark"
                    data-container="body"
                    data-original-title="Tooltip title"
                >
                    {{ $optionName }}
                </a>
            @endforeach
        </div>
    @endif
</div>
