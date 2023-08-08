<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 31.03.2020
 */

namespace Appus\Admin\Form\Fields;

class DateRangeField extends FieldAbstract
{

    protected $showTime;

    /**
     * @param string|null $value
     * @return string
     */
    public function getRowViewForString(string $value = null): string
    {
        return view('admin::form.fields.date-range')->with([
            'name' => $this->name,
            'field' => $this->field,
            'value' => $value,
            'validationName' => $this->getFieldForSave(),
            'help' => $this->help,
            'showTime' => $this->isShowTime(),
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
     * @param bool $value
     * @return FieldInterface
     */
    public function showTime(bool $value = false): FieldInterface
    {
        $this->showTime = $value;
        return $this;
    }

    /**
     * @return bool
     */
    protected function isShowTime(): bool
    {
        if (null === $this->showTime) {
            $this->showTime();
        }
        return $this->showTime;
    }

}
