<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 15.01.2020
 */

namespace Appus\Admin\Services\Admin\Facades;

use Illuminate\Support\Facades\Facade;

class Admin extends Facade
{

    /**
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'admin';
    }

}
