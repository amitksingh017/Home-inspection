<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 19.03.2020
 */

namespace Appus\Admin\Form\Fields;

use Appus\Admin\Exceptions\InvalidFormatException;

class ColorField extends FieldAbstract
{

    protected $defaultColor;

    /**
     * @param string|null $value
     * @return string
     */
    public function getRowViewForString(string $value = null): string
    {
        return view('admin::form.fields.color')->with([
            'name' => $this->name,
            'field' => $this->field,
            'value' => $value ?? $this->defaultColor,
            'validationName' => $this->getFieldForSave(),
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
     * @param string $value
     * @return FieldInterface
     * @throws InvalidFormatException
     */
    public function defaultColor(string $value): FieldInterface
    {
        if (!$this->checkFormat($value)) {
            throw new InvalidFormatException('Value must be a valid hex-color and must be 7 symbols');
        }
        $this->defaultColor = $value;
        return $this;
    }

    /**
     * @param string $value
     * @return bool
     */
    protected function checkFormat(string $value): bool
    {
        if ('#' !== substr($value, 0, 1)) {
            return false;
        }
        if (7 !== strlen($value)) {
            return false;
        }
        return true;
    }

}
