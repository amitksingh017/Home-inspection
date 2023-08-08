<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 01.11.2019
 */

namespace Appus\Admin\Form\Fields;

use Appus\Admin\Exceptions\UnknownRelationException;
use Appus\Admin\Fields\FieldAbstract as FieldFormAbstract;
use Appus\Admin\Form\Traits\RulesTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

abstract class FieldAbstract extends FieldFormAbstract implements FieldInterface, FieldRuleInterface
{

    use RulesTrait;

    protected $saveAs;
    protected $help;

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
    public function getFieldForSave(): string
    {
        return str_replace('.', '_', $this->getField());
    }

    /**
     * @return string
     */
    public function getValidationField(): string
    {
        return $this->getFieldForSave();
    }

    /**
     * @param string $text
     * @return FieldInterface
     */
    public function help(string $text): FieldInterface
    {
        $this->help = $text;
        return $this;
    }

    /**
     * @param \Closure $callback
     * @return FieldInterface
     */
    public function saveAs(\Closure $callback): FieldInterface
    {
        $this->saveAs = $callback;
        return $this;
    }

    /**
     * @param Model $model
     * @return array
     * @throws UnknownRelationException
     */
    public function save(Model $model): array
    {
        $field = $this->getFieldForSave();
        if (null !== $this->saveAs) {
            $callback = $this->saveAs;
            $value = $callback($model);
            request()->merge([$field => $value]);
        }
        return $this->defaultSave($model, $field);
    }

    /**
     * @param Model $model
     * @param string $field
     * @return array
     * @throws UnknownRelationException
     */
    protected function defaultSave(Model $model, string $field): array
    {
        if ($this->fieldExists($model)) {
            $model->{$field} = request()->get($field) ?? null;
            return [
                get_class($model) => $model
            ];
        }
        if ($this->checkRelation()) {
            return $this->saveRelationValue($model);
        }
        return [];
    }

    /**
     * @param Model $model
     * @return bool
     */
    protected function fieldExists(Model $model): bool
    {
        return Schema::hasColumn($model->getTable(), $this->getFieldForSave());
    }

}
