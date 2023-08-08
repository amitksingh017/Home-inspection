<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 19.03.2020
 */

namespace Appus\Admin\Form\Fields;

class HiddenField extends FieldAbstract
{

    protected $defaultValue;

    /**
     * @param string|null $value
     * @return string
     */
    public function getRowViewForString(string $value = null): string
    {
        return view('admin::form.fields.hidden')->with([
            'field' => $this->field,
            'value' => $value ?? $this->defaultValue,
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
     * @param string $value
     * @return FieldInterface
     */
    public function defaultValue(string $value): FieldInterface
    {
        $this->defaultValue = $value;
        return $this;
    }

}
