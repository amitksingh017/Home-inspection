<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 31.03.2020
 */

namespace Appus\Admin\Form\Fields;

class RangeField extends FieldAbstract
{

    protected $min;
    protected $max;
    protected $step;

    /**
     * @param string|null $value
     * @return string
     */
    public function getRowViewForString(string $value = null): string
    {
        return view('admin::form.fields.range')->with([
            'name' => $this->name,
            'field' => $this->field,
            'value' => $value,
            'validationName' => $this->getFieldForSave(),
            'help' => $this->help,
            'min' => $this->getMin(),
            'max' => $this->getMax(),
            'step' => $this->getStep(),
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
     * @param int $value
     * @return FieldInterface
     */
    public function min($value = 0): FieldInterface
    {
        $this->min = $value;
        return $this;
    }

    /**
     * @param int $value
     * @return FieldInterface
     */
    public function max($value = 100): FieldInterface
    {
        $this->max = $value;
        return $this;
    }

    /**
     * @param int $value
     * @return FieldInterface
     */
    public function step($value = 1): FieldInterface
    {
        $this->step = $value;
        return $this;
    }

    /**
     * @return mixed
     */
    protected function getMin()
    {
        if (null === $this->min) {
            $this->min();
        }
        return $this->min;
    }

    /**
     * @return mixed
     */
    protected function getMax()
    {
        if (null === $this->max) {
            $this->max();
        }
        return $this->max;
    }

    /**
     * @return mixed
     */
    protected function getStep()
    {
        if (null === $this->step) {
            $this->step();
        }
        return $this->step;
    }

}
