<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 27.03.2020
 */

namespace Appus\Admin\Form\Fields;

use Appus\Admin\Exceptions\InvalidFormatException;
use Appus\Admin\Exceptions\InvalidTypeException;
use Appus\Admin\Exceptions\UnknownRelationException;
use Illuminate\Database\Eloquent\Model;

class BelongsToManyCheckboxField extends FieldAbstract
{

    protected $options;

    /**
     * @param string|null $value
     * @return string
     */
    public function getRowViewForString(string $value = null): ?string
    {
        return null;
    }

    /**
     * @param array|null $value
     * @return string|null
     */
    public function getRowViewForArray(array $value = null): ?string
    {
        return view('admin::form.fields.belongs-to-many-checkboxes', [
            'name' => $this->name,
            'field' => $this->field,
            'value' => $value,
            'options' => $this->getOptions(),
            'validationName' => $this->getFieldForSave(),
            'help' => $this->help,
        ]);
    }

    /**
     * @param array $options
     * @return FieldInterface
     */
    public function options(array $options): FieldInterface
    {
        $this->options = $options;
        return $this;
    }

    /**
     * @return array
     */
    protected function getOptions(): array
    {
        if (null !== $this->options) {
            return $this->options;
        }
        $relationName = $this->getRelationName();
        $fieldName = $this->getRelationFieldName();
        $relation = $this->model->{$relationName}();
        return $relation->getModel()
            ->pluck($fieldName, $relation->getRelatedKeyName())
            ->toArray();
    }

    /**
     * @return mixed
     * @throws InvalidTypeException
     * @throws InvalidFormatException
     */
    protected function getValue(): array
    {
        if (!$this->checkRelation()) {
            throw new InvalidFormatException('Field name must be in format relationName.fieldName');
        }
        if ('BelongsToMany' !== $this->getRelationType($this->model)) {
            throw new InvalidTypeException('Relation must be BelongsToMany');
        }
        $relationName = $this->getRelationName();
        $relation = $this->model->{$relationName}();
        return $this->model
            ->{$relationName}
            ->pluck($relation->getRelatedKeyName())
            ->toArray();
    }

    /**
     * @return string
     */
    protected function getRelationFieldName(): string
    {
        return explode('.', $this->getField())[1];
    }

    /**
     * @param Model $model
     * @param string $field
     * @return array
     * @throws UnknownRelationException
     */
    protected function defaultSave(Model $model, string $field): array
    {
        $values = request()->get($this->getFieldForSave());
        $relationName = $this->getRelationName();
        $this->model->{$relationName}()->detach();
        if (!empty($values)) {
            $this->model->{$relationName}()->attach($values);
        }
        return [];
    }

}
