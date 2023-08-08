<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 12.03.2020
 */

namespace Appus\Admin\Extensions;

use Illuminate\Support\ServiceProvider;

class ExtensionServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap any package services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('table-column-extension', function () {
            return TableColumnExtension::getInstance();
        });
        $this->app->bind('details-field-extension', function () {
            return DetailsFieldExtension::getInstance();
        });
        $this->app->bind('form-field-extension', function () {
            return FormFieldExtension::getInstance();
        });
    }

}
