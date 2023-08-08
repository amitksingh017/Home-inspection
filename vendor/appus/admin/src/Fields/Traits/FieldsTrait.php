<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 31.10.2019
 */

namespace Appus\Admin\Fields\Traits;

use Appus\Admin\Fields\FieldInterface;
use Appus\Admin\Exceptions\UnknownFieldException;

trait FieldsTrait
{

    protected $fields;

    /**
     * @param string $field
     * @param string|null $name
     * @return FieldInterface
     */
    public function field(string $field, string $name = null): FieldInterface
    {
        return $this->string($field, $name);
    }

    /**
     * @param string $method
     * @param array $arguments
     * @return FieldInterface
     * @throws UnknownFieldException
     */
    public function __call(string $method, array $arguments): FieldInterface
    {
        $field = $arguments[0];
        $name = $arguments[1] ?? null;
        $column = $this->getFieldsFactory()::factory($method, $this->model, $field, $name);
        $this->fields[$field] = $column;
        return $column;
    }

    /**
     * @return array
     */
    public function getFields(): array
    {
        return $this->fields;
    }

}
