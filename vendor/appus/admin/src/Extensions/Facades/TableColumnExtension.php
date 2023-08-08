<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 12.03.2020
 */

namespace Appus\Admin\Extensions\Facades;

use Illuminate\Support\Facades\Facade;

class TableColumnExtension extends Facade
{

    /**
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'table-column-extension';
    }

}
