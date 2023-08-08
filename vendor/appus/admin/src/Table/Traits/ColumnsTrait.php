<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 15.10.2019
 */

namespace Appus\Admin\Table\Traits;

use Appus\Admin\Exceptions\UnknownColumnException;
use Appus\Admin\Table\Columns\ColumnFactory;
use Appus\Admin\Table\Columns\ColumnInterface;

trait ColumnsTrait
{

    protected $columns;

    /**
     * @param string $field
     * @param string|null $name
     * @return ColumnInterface
     */
    public function column(string $field, string $name = null): ColumnInterface
    {
        return $this->string($field, $name);
    }

    /**
     * @param string $method
     * @param array $arguments
     * @return ColumnInterface
     * @throws UnknownColumnException
     */
    public function __call(string $method, array $arguments): ColumnInterface
    {
        $field = $arguments[0];
        $name = $arguments[1] ?? null;
        $column = ColumnFactory::factory($method, $field, $name);
        $this->columns[$field] = $column;
        return $column;
    }

}
