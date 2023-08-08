<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta http-equiv="X-UA-Compatible" content="IE=edge"/>

        <title>{{ config('app.name', config('app.name')) }}</title>

        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700|Roboto:300,400,500,600,700">

        <link href="{{ config('app.url', config('app.url')) }}/vendor/admin/themes/{{ _ADMIN_THEME_ }}/vendor/vendors.bundle.css" rel="stylesheet" type="text/css" />
        <link href="{{ config('app.url', config('app.url')) }}/vendor/admin/themes/{{ _ADMIN_THEME_ }}/css/admin.bundle.css" rel="stylesheet" type="text/css" />
        <link href="{{ config('app.url', config('app.url')) }}/vendor/admin/themes/{{ _ADMIN_THEME_ }}/css/login.min.css" rel="stylesheet" type="text/css" />
        <link href="{{ config('app.url', config('app.url')) }}/vendor/admin/css/app.css" rel="stylesheet" type="text/css" />
        
        @foreach(Admin::css() as $style)
            <link href="{{ config('app.url', config('app.url')) }}{{ $style }}" rel="stylesheet" type="text/css" />
        @endforeach

        
        @stack('css')

    </head>

    <body>
        <div class="kt-grid kt-grid--ver kt-grid--root kt-page">
            <div class="kt-grid kt-grid--hor kt-grid--root kt-login kt-login--v2 kt-login--signin" id="kt_login">
                <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" style="background-image: url({{ config('app.url', config('app.url')) }}/vendor/admin/themes/{{ _ADMIN_THEME_ }}/img/bg-1.jpg);">
                    <div class="kt-grid__item kt-grid__item--fluid kt-login__wrapper">
                        <div class="kt-login__container">
                            <div class="kt-login__logo">
                                <a style="width: 100%;">
                                    @if (config('admin.logo'))
                                        <img src="{{ config('admin.logo') }}" alt="Logo"  style="width: 100%;" />
                                    @endif
                                </a>
                            </div>
                            @yield('content')
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            var KTAppOptions = {"colors":{"state":{"brand":"#22b9ff","light":"#ffffff","dark":"#282a3c","primary":"#5867dd","success":"#34bfa3","info":"#36a3f7","warning":"#ffb822","danger":"#fd3995"},"base":{"label":["#c5cbe3","#a1a8c3","#3d4465","#3e4466"],"shape":["#f0f3ff","#d9dffa","#afb4d4","#646c9a"]}}};
        </script>

        <script src="/vendor/admin/themes/{{ _ADMIN_THEME_ }}/vendor/vendors.bundle.js" type="text/javascript"></script>
        <script src="/vendor/admin/themes/{{ _ADMIN_THEME_ }}/js/admin.bundle.js" type="text/javascript"></script>
        <script src="/vendor/admin/themes/{{ _ADMIN_THEME_ }}/js/login.js" type="text/javascript"></script>
        <script src="/vendor/admin/themes/{{ _ADMIN_THEME_ }}/js/forgot_password.js" type="text/javascript"></script>
        <script src="/vendor/admin/themes/{{ _ADMIN_THEME_ }}/js/reset_password.js" type="text/javascript"></script>
        <script src="/vendor/admin/themes/{{ _ADMIN_THEME_ }}/js/registration.js" type="text/javascript"></script>
        <script src="/vendor/admin/themes/{{ _ADMIN_THEME_ }}/js/login_general.js" type="text/javascript"></script>
        <script src="/vendor/admin/js/app.js" type="text/javascript"></script>
        
        @foreach(Admin::js() as $script)
            <script src="{{ $script }}" type="text/javascript"></script>
        @endforeach

        
        @stack('js')

    </body>

</html>
