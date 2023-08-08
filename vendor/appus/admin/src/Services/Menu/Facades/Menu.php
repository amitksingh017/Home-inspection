<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 15.01.2020
 */

namespace Appus\Admin\Services\Menu\Facades;

use Illuminate\Support\Facades\Facade;

class Menu extends Facade
{

    /**
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'menu';
    }

}
