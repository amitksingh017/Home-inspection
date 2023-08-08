<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 01.10.2019
 */

namespace Appus\Admin\Table\Columns;

class StringColumn extends ColumnAbstract
{

    /**
     * @param string|null $value
     * @return string|null
     */
    public function getCellViewForString(string $value = null): ?string
    {
        return $value;
    }

    /**
     * @param array|null $value
     * @return string|null
     */
    public function getCellViewForArray(array $value = null): ?string
    {
        return implode("<br />", $value);
    }

}
