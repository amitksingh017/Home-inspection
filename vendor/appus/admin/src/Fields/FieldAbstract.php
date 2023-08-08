<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 30.10.2019
 */

namespace Appus\Admin\Fields;

use Appus\Admin\Exceptions\UnknownRelationException;
use Appus\Admin\Relations\Traits\RelationTrait;

abstract class FieldAbstract implements FieldInterface
{

    use RelationTrait;

    protected $model;

    protected $field;

    protected $name;

    protected $displayAs;

    protected $valueAs;

    public function __construct($model, string $field, string $name = null)
    {
        $this->model = $model;
        $this->field = $field;
        $this->name = $this->getDisplayName($field, $name);
    }

    /**
     * @param \Closure $callback
     * @return FieldInterface
     */
    public function displayAs(\Closure $callback): FieldInterface
    {
        $this->displayAs = $callback;
        return $this;
    }

    /**
     * @param \Closure $callback
     * @return FieldInterface
     */
    public function valueAs(\Closure $callback): FieldInterface
    {
        $this->valueAs = $callback;
        return $this;
    }

    /**
     * @return bool
     */
    public function isColumn(): bool
    {
        return false;
    }

    /**
     * @return string|null
     * @throws UnknownRelationException
     */
    public function render(): ?string
    {
        if (null !== $this->displayAs) {
            $callback = $this->displayAs;
            return $callback($this->model);
        }
        if (null !== $this->valueAs) {
            $callback = $this->valueAs;
            return $this->getRowView($callback($this->model));
        }
        return $this->getRowView($this->getValue());
    }

    /**
     * @param null $value
     * @return string|null
     */
    public function getRowView($value = null): ?string
    {
        if (is_array($value)) {
            return $this->getRowViewForArray($value);
        }
        return $this->getRowViewForString($value);
    }

    /**
     * @param string|null $value
     * @return string|null
     */
    abstract public function getRowViewForString(string $value = null): ?string;

    /**
     * @param array|null $value
     * @return string|null
     */
    abstract public function getRowViewForArray(array $value = null): ?string;


    /**
     * @return mixed
     * @throws UnknownRelationException
     */
    protected function getValue()
    {
        if (!$this->checkRelation()) {
            return $this->model->{$this->field};
        }
        return $this->getRelationValue($this->model);
    }

    /**
     * @return string
     */
    public function getField(): string
    {
        return $this->field;
    }

    /**
     * @param string $field
     * @param string|null $name
     * @return string
     */
    protected function getDisplayName(string $field, string $name = null): string
    {
        if (null === $name) {
            $name = str_replace('_', ' ', $field);
            $name = ucfirst($name);
        }
        return $name;
    }

}
