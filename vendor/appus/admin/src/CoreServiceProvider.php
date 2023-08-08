<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 02.12.2019
 */

namespace Appus\Admin;

use Appus\Admin\Extensions\ExtensionServiceProvider;
use Illuminate\Support\ServiceProvider;

class CoreServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any package services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/admin.php' => config_path('admin.php'),
        ], 'config');
        $this->publishes([
            __DIR__.'/../public' => public_path('vendor'),
        ], 'public');
        $this->publishes([
            __DIR__.'/Menu' => app_path('Menu'),
        ], 'menu');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(AppServiceProvider::class);
        $this->app->register(RouteServiceProvider::class);
        $this->app->register(MenuServiceProvider::class);
        $this->app->register(MessageServiceProvider::class);
        $this->app->register(ExtensionServiceProvider::class);
    }
}
