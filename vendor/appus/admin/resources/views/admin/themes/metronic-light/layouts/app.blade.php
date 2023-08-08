<!DOCTYPE html>
<html lang="en" >
<!-- begin::Head -->
<head><!--begin::Base Path (base relative path for assets of this page) -->
    <base href="../"><!--end::Base Path -->
    <meta charset="utf-8"/>

    <title>@yield('title', env('APP_NAME'))</title>
    <meta name="description" content="Latest updates and statistic charts">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700|Roboto:300,400,500,600,700">

    <link href="{{ config('app.url', config('app.url')) }}/vendor/admin/themes/{{ _ADMIN_THEME_ }}/vendor/vendors.bundle.css" rel="stylesheet" type="text/css" />
    <link href="{{ config('app.url', config('app.url')) }}/vendor/admin/themes/{{ _ADMIN_THEME_ }}/css/admin.bundle.css" rel="stylesheet" type="text/css" />
    <link href="{{ config('app.url', config('app.url')) }}/vendor/admin/js/cropperjs/cropper.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ config('app.url', config('app.url')) }}/vendor/admin/css/app.css" rel="stylesheet" type="text/css" />

    @foreach(Admin::css() as $style)
        <link href="{{ config('app.url', config('app.url')) }}{{ $style }}" rel="stylesheet" type="text/css" />
    @endforeach

    @stack('css')

</head>
<!-- end::Head -->

<!-- begin::Body -->
<body  class="kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-subheader--enabled kt-subheader--transparent kt-aside--enabled kt-aside--fixed @if(config('admin.minimized_menu')) kt-aside--minimize @endif kt-page--loading"  >

<div id="kt_header_mobile" class="kt-header-mobile  kt-header-mobile--fixed " >
    <div class="kt-header-mobile__logo">
        <a href="{{ config('admin.home_page_url') ? (url(config('admin.prefix') . '/' . config('admin.home_page_url'))) : route('dashboard') }}" style="height: 80%; text-align: center;">
            @if(config('admin.logo'))
                <img src="{{ config('admin.logo') }}" alt="Logo" style="height: 100%;" />
            @else
                Logo
            @endif
        </a>
    </div>
    <div class="kt-header-mobile__toolbar">
        <button class="kt-header-mobile__toolbar-toggler kt-header-mobile__toolbar-toggler--left" id="kt_aside_mobile_toggler"><span></span></button>
        <button class="kt-header-mobile__toolbar-topbar-toggler" id="kt_header_mobile_topbar_toggler"><i class="flaticon-more"></i></button>
    </div>
</div>

<div class="kt-grid kt-grid--hor kt-grid--root">
    <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver kt-page">

        <!-- SIDEBAR -->
        <div class="kt-aside  kt-aside--fixed  kt-grid__item kt-grid kt-grid--desktop kt-grid--hor-desktop" id="kt_aside">
            <div class="kt-aside__brand kt-grid__item " id="kt_aside_brand" style="padding: 10px;">
                <div class="kt-aside__brand-logo" style="width: 100%;">
                    <a href="{{ config('admin.home_page_url') ? (url(config('admin.prefix') . '/' . config('admin.home_page_url'))) : route('dashboard') }}" style="width: 100%; text-align: center;">
                        @if(config('admin.logo'))
                            <img src="{{ config('admin.logo') }}" alt="Logo" style="width: 100%;" />
                        @else
                            Logo
                        @endif
                    </a>
                </div>
            </div>
            <div class="kt-aside-menu-wrapper kt-grid__item kt-grid__item--fluid" id="kt_aside_menu_wrapper">
                <div id="kt_aside_menu" class="kt-aside-menu  kt-aside-menu--dropdown " data-ktmenu-vertical="1" data-ktmenu-dropdown="1" data-ktmenu-scroll="0">
                    @include('admin::layouts.menu.side')
                </div>
            </div>
        </div>

        <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-wrapper" id="kt_wrapper">

            <!-- HEADER -->
            <div id="kt_header" class="kt-header kt-grid kt-grid--ver  kt-header--fixed " >

                <div class="menu-button" onmouseenter="hamburgerAnimation();">
                    <div class="mini-button" data-action="open">
                        <i class="fas fa-chevron-right"></i>
                    </div>
                    <div class="mini-button" data-action="close">
                        <i class="fas fa-chevron-left"></i>
                    </div>
                    <div class="full-button" data-action="open">
                        <i class="fas fa-chevron-right first-arrow"></i>
                        <i class="fas fa-chevron-right second-arrow"></i>
                    </div>
                    <div class="full-button" data-action="close">
                        <i class="fas fa-chevron-left second-arrow"></i>
                        <i class="fas fa-chevron-left first-arrow"></i>
                    </div>
                </div>

                <button class="kt-header-menu-wrapper-close" id="kt_header_menu_mobile_close_btn"><i class="la la-close"></i></button>

                <div class="kt-header-menu-wrapper kt-grid__item kt-grid__item--fluid" id="kt_header_menu_wrapper">
                    <div id="kt_header_menu" class="kt-header-menu kt-header-menu-mobile  kt-header-menu--layout- ">
                        @include('admin::layouts.menu.top')
                    </div>
                </div>

                @include('admin::layouts.profile')

            </div>

            <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">

                <div class="kt-subheader   kt-grid__item" id="kt_subheader">
                    <div class="kt-container  kt-container--fluid ">
                        <div class="kt-subheader__main">
                            <h3 class="kt-subheader__title">
                                @yield('title', env('APP_NAME'))
                            </h3>

                        </div>

                    </div>
                </div>

                <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
                    @yield('content')
                </div>
            </div>

            <div class="kt-footer  kt-grid__item kt-grid kt-grid--desktop kt-grid--ver-desktop"  id="kt_footer">
                <div class="kt-container  kt-container--fluid ">
                    <div class="kt-footer__copyright">
                        {{ date('Y') }}&nbsp;&copy;&nbsp;<a href="#" target="_blank" class="kt-link">{{ env('APP_NAME') }}</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<div id="kt_scrolltop" class="kt-scrolltop">
    <i class="fa fa-arrow-up"></i>
</div>

@include('admin::layouts.notifications')

<script>
    var KTAppOptions = {"colors":{"state":{"brand":"#22b9ff","light":"#ffffff","dark":"#282a3c","primary":"#5867dd","success":"#34bfa3","info":"#36a3f7","warning":"#ffb822","danger":"#fd3995"},"base":{"label":["#c5cbe3","#a1a8c3","#3d4465","#3e4466"],"shape":["#f0f3ff","#d9dffa","#afb4d4","#646c9a"]}}};
</script>

<script src="{{ config('app.url', config('app.url')) }}/vendor/admin/themes/{{ _ADMIN_THEME_ }}/vendor/vendors.bundle.js" type="text/javascript"></script>
<script src="{{ config('app.url', config('app.url')) }}/vendor/admin/themes/{{ _ADMIN_THEME_ }}/js/admin.bundle.js" type="text/javascript"></script>
<script src="{{ config('app.url', config('app.url')) }}/vendor/admin/js/cropperjs/cropper.min.js" type="text/javascript"></script>
<script src="{{ config('app.url', config('app.url')) }}/vendor/admin/js/app.js" type="text/javascript"></script>
<script src="{{ config('app.url', config('app.url')) }}/vendor/admin/js/table/actions.js" type="text/javascript"></script>
<script src="{{ config('app.url', config('app.url')) }}/vendor/admin/js/table/addition-info.js" type="text/javascript"></script>
<script src="{{ config('app.url', config('app.url')) }}/vendor/admin/js/table/filter.js" type="text/javascript"></script>
<script src="{{ config('app.url', config('app.url')) }}/vendor/admin/js/table/modal.js" type="text/javascript"></script>
<script src="{{ config('app.url', config('app.url')) }}/vendor/admin/js/table/multi-actions.js" type="text/javascript"></script>
<script src="{{ config('app.url', config('app.url')) }}/vendor/admin/js/table/pagination.js" type="text/javascript"></script>
<script src="{{ config('app.url', config('app.url')) }}/vendor/admin/js/table/search.js" type="text/javascript"></script>
<script src="{{ config('app.url', config('app.url')) }}/vendor/admin/js/table/sort.js" type="text/javascript"></script>
<script src="{{ config('app.url', config('app.url')) }}/vendor/admin/js/table/table.js" type="text/javascript"></script>
<script src="{{ config('app.url', config('app.url')) }}/vendor/admin/js/form/fields.js" type="text/javascript"></script>
<script src="{{ config('app.url', config('app.url')) }}/vendor/admin/js/form/files.js" type="text/javascript"></script>
<script src="{{ config('app.url', config('app.url')) }}/vendor/admin/js/form/form.js" type="text/javascript"></script>
<script src="{{ config('app.url', config('app.url')) }}/vendor/admin/js/metrics.js" type="text/javascript"></script>
<script src="{{ config('app.url', config('app.url')) }}/vendor/admin/js/notifications.js" type="text/javascript"></script>

@foreach(Admin::js() as $script)
    <script src="{{ config('app.url', config('app.url')) }}{{ $script }}" type="text/javascript"></script>
@endforeach

@stack('js')

</body>

</html>
