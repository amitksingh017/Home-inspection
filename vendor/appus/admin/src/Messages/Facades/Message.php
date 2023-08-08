<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 22.01.2020
 */

namespace Appus\Admin\Messages\Facades;

use Illuminate\Support\Facades\Facade;

class Message extends Facade
{

    /**
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'message';
    }

}
