<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 26.09.2019
 */

return [

    /**
     * Prefix for admin panel
     * You can change it
     */
    'prefix' => 'admin',

    /**
     * Theme for admin panel
     */
    'theme' => 'metronic-light',

    /**
     * Path for logo image
     */
    'logo' => null,

    /**
     * Path for login redirect and clicking by logo
     */
    'home_page_url' => null,

    /**
     * Auth parameters
     */
    'auth' => [

        /*
         * Using of custom or vendor auth routing
         * if true vendor auth routing will not work
         */
        'custom' => false,

        /**
         * Add registration form
         */
        'register' => false,

        /**
         * Add forgot password form
         */
        'forgot_password' => true,

        /**
         * Add path to terms and conditions page and add checkbox for registration
         */
        'terms_and_conditions_route' => null,

    ],

    /**
     * Default state of menu: minimized on start or not
     */
    'minimized_menu' => true,

    /**
     * There are urls to your menu configuration files
     *
     * You can add your own and add url in this array
     *
     */
    'menu' => [

        app_path('Menu/menu.php'),

    ],

];
