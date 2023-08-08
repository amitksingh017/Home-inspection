<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 25.03.2020
 */

namespace Appus\Admin\Form\Fields;

use Appus\Admin\Exceptions\UnknownRelationException;
use Illuminate\Database\Eloquent\Model;

class DateTimeField extends FieldAbstract
{

    protected $savingFormat;
    protected $onlyDate;
    protected $onlyTime;
    protected $defaultDateFormat = 'Y-m-d';
    protected $defaultTimeFormat = 'H:i:s';

    /**
     * @param string|null $value
     * @return string
     */
    public function getRowViewForString(string $value = null): string
    {
        return view('admin::form.fields.date-time')->with([
            'name' => $this->name,
            'field' => $this->field,
            'value' => $value,
            'validationName' => $this->getFieldForSave(),
            'isOnlyDate' => $this->isOnlyDate(),
            'isOnlyTime' => $this->isOnlyTime(),
            'help' => $this->help,
        ]);
    }

    /**
     * @param array|null $value
     * @return string|null
     */
    public function getRowViewForArray(array $value = null): ?string
    {
        return null;
    }

    /**
     * @param Model $model
     * @param string $field
     * @return array
     * @throws UnknownRelationException
     */
    protected function defaultSave(Model $model, string $field): array
    {
        $value = request()->get($field);
        $value = date($this->getSavingFormat(), strtotime($value));
        request()->merge([$field => $value]);
        return parent::defaultSave($model, $field);
    }

    /**
     * @param string $value
     * @return FieldInterface
     */
    public function savingFormat(string $value): FieldInterface
    {
        $this->savingFormat = $value;
        return $this;
    }

    /**
     * @param bool $value
     * @return FieldInterface
     */
    public function onlyDate(bool $value = false): FieldInterface
    {
        $this->onlyDate = $value;
        return $this;
    }

    /**
     * @param bool $value
     * @return FieldInterface
     */
    public function onlyTime(bool $value = false): FieldInterface
    {
        $this->onlyTime = $value;
        return $this;
    }

    /**
     * @return bool
     */
    protected function isOnlyDate(): bool
    {
        if (null === $this->onlyDate) {
            $this->onlyDate();
        }
        return $this->onlyDate;
    }

    /**
     * @return bool
     */
    protected function isOnlyTime(): bool
    {
        if (null === $this->onlyTime) {
            $this->onlyTime();
        }
        return $this->onlyTime;
    }

    /**
     * @return string
     */
    protected function getSavingFormat(): string
    {
        if (null !== $this->savingFormat) {
            return $this->savingFormat;
        }
        if ($this->isOnlyDate()) {
            return $this->defaultDateFormat;
        }
        if ($this->isOnlyTime()) {
            return $this->defaultTimeFormat;
        }
        return $this->defaultDateFormat . ' ' . $this->defaultTimeFormat;
    }

}
