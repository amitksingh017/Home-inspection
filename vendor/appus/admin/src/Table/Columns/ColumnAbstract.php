<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 09.10.2019
 */

namespace Appus\Admin\Table\Columns;

use Appus\Admin\Exceptions\UnknownRelationException;
use Appus\Admin\Relations\Traits\RelationTrait;
use Appus\Admin\Traits\AdditionalModalTrait;
use Appus\Admin\Traits\AdditionalRowTrait;

abstract class ColumnAbstract implements ColumnInterface
{

    use RelationTrait,
        AdditionalRowTrait,
        AdditionalModalTrait;

    protected $field;
    protected $name;
    protected $valueAs;
    protected $displayAs;
    protected $searchable;
    protected $sortable;

    public function __construct($field, $name)
    {
        $this->field = $field;
        $this->name = $this->getDisplayName($field, $name);
    }

    /**
     * @return string
     */
    public function getField(): string
    {
        return $this->field;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param \Closure $callback
     * @return ColumnInterface
     */
    public function valueAs(\Closure $callback): ColumnInterface
    {
        $this->valueAs = $callback;
        return $this;
    }

    /**
     * @param \Closure $callback
     * @return ColumnInterface
     */
    public function displayAs(\Closure $callback): ColumnInterface
    {
        $this->displayAs = $callback;
        return $this;
    }

    /**
     * @param bool $value
     * @return ColumnInterface
     */
    public function searchable(bool $value = false): ColumnInterface
    {
        $this->searchable = $value;
        return $this;
    }

    /**
     * @param bool $value
     * @return ColumnInterface
     */
    public function sortable(bool $value = false): ColumnInterface
    {
        $this->sortable = $value;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getSort(): ?string
    {
        $sort = request()->get('sort');
        if (!empty($sort)) {
            $sort = explode('__', $sort);
            if ($sort[0] === $this->getField()) {
                return $sort[1];
            }
        }
        return null;
    }

    /**
     * @param $row
     * @return string|null
     * @throws UnknownRelationException
     */
    public function getCell($row): ?string
    {
        if (null !== $this->displayAs) {
            $callback = $this->displayAs;
            return $callback($row);
        }
        if (null !== $this->valueAs) {
            $callback = $this->valueAs;
            return $this->getCellView($callback($row));
        }
        return $this->getCellView($this->getValue($row));
    }

    /**
     * @param $row
     * @return mixed
     * @throws UnknownRelationException
     */
    public function getValue($row)
    {
        if (!$this->checkRelation()) {
            return $row[$this->getField()];
        }
        return $this->getRelationValue($row);
    }

    /**
     * @return bool
     */
    public function isSearchable(): bool
    {
        if (null === $this->searchable) {
            $this->searchable();
        }
        return $this->searchable;
    }

    /**
     * @return bool
     */
    public function isSortable(): bool
    {
        if (null === $this->sortable) {
            $this->sortable();
        }
        return $this->sortable;
    }

    /**
     * @param null $value
     * @return string|null
     */
    public function getCellView($value = null): ?string
    {
        if (is_array($value)) {
            return $this->getCellViewForArray($value);
        }
        return $this->getCellViewForString($value);
    }

    /**
     * @param string|null $value
     * @return string|null
     */
    abstract public function getCellViewForString(string $value = null): ?string;

    /**
     * @param array|null $value
     * @return string|null
     */
    abstract public function getCellViewForArray(array $value = null): ?string;

    /**
     * @param string $column
     * @param string|null $name
     * @return string
     */
    protected function getDisplayName(string $column, string $name = null): string
    {
        if (null === $name) {
            $name = str_replace('_', ' ', $column);
            $name = ucfirst($name);
        }
        return $name;
    }

}
