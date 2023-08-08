<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 30.03.2020
 */

namespace Appus\Admin\Form\Fields;

use Appus\Admin\Exceptions\InvalidFormatException;
use Appus\Admin\Exceptions\InvalidTypeException;

class BelongsToField extends SelectField
{

    protected $relationName;
    protected $relationFieldName;

    public function __construct($model, string $field, string $name = null)
    {
        $this->field = $field;
        if (!$this->checkRelation()) {
            throw new InvalidFormatException('Field name must be in format relationName.fieldName');
        }
        if ('BelongsTo' !== $this->getRelationType($model)) {
            throw new InvalidTypeException('Relation must be BelongsTo');
        }
        $this->relationName = $this->getRelationName();
        $this->relationFieldName = $this->getRelationFieldName();
        $relation = $model->{$this->relationName}();
        $field = $relation->getForeignKeyName();
        parent::__construct($model, $field, $name);
    }

    /**
     * @return array
     */
    protected function getOptions(): ?array
    {
        if (null !== $this->options) {
            return $this->options;
        }
        $relation = $this->model->{$this->relationName}();
        return $relation->getModel()
            ->pluck($this->relationFieldName, $relation->getOwnerKeyName())
            ->toArray();
    }

    /**
     * @return string
     */
    protected function getRelationFieldName(): string
    {
        return explode('.', $this->getField())[1];
    }

}
