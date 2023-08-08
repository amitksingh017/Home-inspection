<div class="d-inline-block">
    <img src="/vendor/admin/themes/{{ _ADMIN_THEME_ }}/img/files/{{ $ext }}.svg" alt="{{ $name }}" />

    @if($displayWithUrl)
        <div class="url">
            {{ $value }}
        </div>
    @endif

    @if($downloadable)
        <div class="download">
            <a href="{{ $value }}">
                <i class="fas fa-download"></i>
                Download
            </a>
        </div>
    @endif
</div>
