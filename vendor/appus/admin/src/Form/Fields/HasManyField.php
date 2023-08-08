<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 01.04.2020
 */

namespace Appus\Admin\Form\Fields;

use Appus\Admin\Exceptions\InvalidFormatException;
use Appus\Admin\Exceptions\InvalidTypeException;
use Illuminate\Database\Eloquent\Model;

class HasManyField extends FieldAbstract
{

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
        return view('admin::form.fields.has-many', [
            'name' => $this->name,
            'field' => $this->field,
            'value' => $value,
            'validationName' => $this->getFieldForSave(),
            'help' => $this->help,
        ]);
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
        if ('HasMany' !== $this->getRelationType($this->model)) {
            throw new InvalidTypeException('Relation must be BelongsToMany');
        }
        $relationName = $this->getRelationName();
        $fieldName = $this->getRelationFieldName();
        $relation = $this->model->{$relationName}();
        return $this->model
            ->{$relationName}
            ->pluck($fieldName, $relation->getLocalKeyName())
            ->toArray();
    }

    /**
     * @return string
     */
    public function getValidationField(): string
    {
        return $this->getFieldForSave();
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
     */
    protected function defaultSave(Model $model, string $field): array
    {
        $values = request()->get($this->getFieldForSave());
        $values = $this->parseOldAndNewValues($values);

        $this->deletedRows($values['old'] ?? []);
        $this->updatedRows($values['old'] ?? []);
        $this->createdRows($values['new'] ?? []);

        return [];
    }

    /**
     * @param array $values
     * @return array
     */
    protected function parseOldAndNewValues(array $values): array
    {
        if (!empty($values)) {
            $res = [];
            foreach ($values as $key => $value) {
                if (is_numeric($key)) {
                    $res['new'][] = $value;
                    continue;
                }
                $id = explode('_', $key);
                $id = $id[1];
                $res['old'][$id] = $value;
            }
            $values = $res;
        }
        return $values;
    }

    /**
     * @param array $oldValues
     * @return bool
     */
    protected function deletedRows(array $oldValues): bool
    {
        $relationName = $this->getRelationName();
        $relation = $this->model->{$relationName}();
        $relationKey = $relation->getLocalKeyName();
        $issetKeys = $this->model
            ->{$relationName}
            ->pluck($relationKey)
            ->toArray();

        $deleteRows = array_diff($issetKeys, array_keys($oldValues));

        if (!empty($deleteRows)) {
            $this->model
                ->{$relationName}()
                ->whereIn($relationKey, $deleteRows)
                ->delete();
            return true;
        }
        return false;
    }

    /**
     * @param array $oldValues
     * @return bool
     */
    protected function updatedRows(array $oldValues): bool
    {
        if (empty($oldValues)) {
            return false;
        }
        $relationName = $this->getRelationName();
        $relation = $this->model->{$relationName}();
        $relationKey = $relation->getLocalKeyName();
        if (!empty($oldValues)) {
            foreach ($oldValues as $key => $value) {
                $this->model
                    ->{$relationName}()
                    ->where($relationKey, $key)
                    ->update([
                        $this->getRelationFieldName() => $value,
                    ]);
            }
        }
        return true;
    }

    /**
     * @param array $newValues
     * @return bool
     */
    public function createdRows(array $newValues): bool
    {
        if (empty($newValues)) {
            return false;
        }
        $relationName = $this->getRelationName();

        $res = [];
        foreach ($newValues as $row) {
            $res[] = [
                $this->getRelationFieldName() => $row,
            ];
        }
        $this->model->{$relationName}()->createMany($res);
        return true;
    }

}
