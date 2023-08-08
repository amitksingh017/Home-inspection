<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 27.11.2019
 */

namespace Appus\Admin\Relations;

abstract class RelationAbstract implements RelationInterface
{

    protected $field;

    protected $row;

    public function __construct(string $field, $row)
    {
        $this->field = $field;
        $this->row = $row;
    }

    /**
     * @return array
     */
    protected function getKeys(): array
    {
        return explode('.', $this->field);
    }

    /**
     * @return string
     */
    protected function getRelation(): string
    {
        $keys = $this->getKeys();
        return $keys[0];
    }

    /**
     * @return string
     */
    protected function getFieldName(): string
    {
        $keys = $this->getKeys();
        return $keys[1];
    }

    /**
     * @return string
     */
    protected function getFieldForSave(): string
    {
        return str_replace('.', '_', $this->field);
    }

}
