<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 10.10.2019
 */

namespace Appus\Admin\Table\Columns;

interface ColumnInterface
{

    /**
     * ColumnInterface constructor.
     * @param $field
     * @param $name
     */
    public function __construct($field, $name);

    /**
     * @return string
     */
    public function getField(): string;

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @param $row
     * @return null|string
     */
    public function getCell($row): ?string;

    /**
     * @param \Closure $callback
     * @return ColumnInterface
     */
    public function valueAs(\Closure $callback): ColumnInterface;

    /**
     * @param \Closure $callback
     * @return ColumnInterface
     */
    public function displayAs(\Closure $callback): ColumnInterface;

    /**
     * @param bool $value
     * @return ColumnInterface
     */
    public function searchable(bool $value = false): ColumnInterface;

    /**
     * @return bool
     */
    public function isSearchable(): bool;

}
