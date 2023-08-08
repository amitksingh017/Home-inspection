<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 12.02.2020
 */

namespace Appus\Admin\Table\Columns;

class ColumnService
{

    /**
     * @param string $name
     * @param string $column
     */
    public static function extend(string $name, string $column)
    {
        config([
            'extensions.columns.' . $name => $column,
        ]);
    }

}
