<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 13.03.2020
 */

namespace Appus\Admin\Extensions\Facades;

use Illuminate\Support\Facades\Facade;

class FormFieldExtension extends Facade
{

    /**
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'form-field-extension';
    }

}
