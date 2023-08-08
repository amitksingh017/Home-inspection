<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 09.10.2019
 */

namespace Appus\Admin\Table\Columns;

use Appus\Admin\Exceptions\UnknownColumnException;
use Appus\Admin\Extensions\Facades\TableColumnExtension;

class ColumnFactory
{

    /**
     * @param string $type
     * @param $field
     * @param null $name
     * @return ColumnInterface
     * @throws UnknownColumnException
     */
    public static function factory(string $type, $field, $name = null): ColumnInterface
    {
        $className = __NAMESPACE__ . substr("\/", 0, 1) . ucfirst($type) . 'Column';
        if (!class_exists($className)) {
            $className = TableColumnExtension::getExtension($type);
        }
        if (null === $className) {
            throw new UnknownColumnException('Such Column Type does not exist');
        }
        $class = new $className($field, $name);
        return $class;
    }

}
