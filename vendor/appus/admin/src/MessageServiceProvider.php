<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 22.01.2020
 */

namespace Appus\Admin;

use Appus\Admin\Messages\Message;
use Appus\Admin\Messages\Facades\Message as MessageFacade;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

class MessageServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any package services.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('message', function () {
            return $this->app->make(Message::class);
        });
        $loader = AliasLoader::getInstance();
        $loader->alias('Message', MessageFacade::class);
    }
}
