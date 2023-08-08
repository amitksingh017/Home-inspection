<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 03.12.2019
 */

namespace Appus\Admin;

use Appus\Admin\Console\Commands\AdminController;
use Appus\Admin\Console\Commands\AdminFilter;
use Appus\Admin\Console\Commands\AdminInstall;
use Appus\Admin\Console\Commands\AdminMetric;
use Appus\Admin\Console\Commands\DocsInit;
use Appus\Admin\Http\Middleware\RedirectIfAuthenticated;
use Appus\Admin\Services\Admin\Admin;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Appus\Admin\Services\Admin\Facades\Admin as AdminFacade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any package services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->registerCommands();
        }
        $this->registerFunctions();
        $theme = config('admin.theme', 'default');
        define('_ADMIN_THEME_', $theme);
        $this->loadViewsFrom(__DIR__ . '/../resources/views/admin/themes/' . $theme, 'admin');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app['router']->aliasMiddleware('admin_guest', RedirectIfAuthenticated::class);
        $this->app->singleton(Admin::class);
        $this->app->bind('admin', function () {
            return $this->app->make(Admin::class);
        });
        $loader = AliasLoader::getInstance();
        $loader->alias('Admin', AdminFacade::class);
    }

    protected function registerCommands()
    {
        $this->commands([
            AdminInstall::class,
            AdminController::class,
            DocsInit::class,
            AdminFilter::class,
            AdminMetric::class,
        ]);
    }

    protected function registerFunctions()
    {
        if (!Collection::hasMacro('paginate')) {
            Collection::macro('paginate', function ($perPage = null, $columns = ['*'], $pageName = 'page', $page = null) {
                $page = $page ?: Paginator::resolveCurrentPage($pageName);
                $perPage = $perPage ?: 10;
                $res = $this->forPage($page, $perPage);
                return new LengthAwarePaginator($res, $this->count(), $perPage, $page);
            });
        }
    }

}
