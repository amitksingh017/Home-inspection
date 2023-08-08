<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 27.03.2020
 */

namespace Appus\Admin\Form\Fields;

class TextField extends FieldAbstract
{

    protected $symbolsCounter;
    protected $symbolsCountMin;
    protected $symbolsCountMax;

    /**
     * @param string|null $value
     * @return string
     */
    public function getRowViewForString(string $value = null): string
    {
        return view('admin::form.fields.text')->with([
            'name' => $this->name,
            'field' => $this->field,
            'value' => $value,
            'validationName' => $this->getFieldForSave(),
            'help' => $this->help,
            'symbolsCounter' => $this->symbolsCounter,
            'symbolsCountMin' => $this->symbolsCountMin,
            'symbolsCountMax' => $this->symbolsCountMax,
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
     * @param int|null $min
     * @param int|null $max
     * @return $this|FieldInterface
     */
    public function symbolsCounter(int $min = null, int $max = null): FieldInterface
    {
        $this->symbolsCounter = true;
        $this->symbolsCountMin = $min;
        $this->symbolsCountMax = $max;

        return $this;
    }

}
