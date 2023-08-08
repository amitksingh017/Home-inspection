<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 14.01.2020
 */

namespace Appus\Admin;

use Appus\Admin\Services\Menu\Adapters\FileMenuAdapter;
use Appus\Admin\Services\Menu\Facades\Menu;
use Appus\Admin\Services\Menu\MenuAdapterInterface;
use Appus\Admin\ViewComposers\SideMenuComposer;
use Appus\Admin\ViewComposers\TopMenuComposer;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class MenuServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any package services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('admin::layouts.menu.side', SideMenuComposer::class);
        View::composer('admin::layouts.menu.top', TopMenuComposer::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(MenuAdapterInterface::class, FileMenuAdapter::class);
        $this->app->bind('menu', function () {
            return $this->app->make(MenuAdapterInterface::class);
        });
        $loader = AliasLoader::getInstance();
        $loader->alias('Menu', Menu::class);
    }
}
