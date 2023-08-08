<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 31.10.2019
 */

namespace Appus\Admin\Form\Fields;

class StringField extends FieldAbstract
{

    protected $rightPrefix;
    protected $leftPrefix;
    protected $symbolsCounter;
    protected $symbolsCountMin;
    protected $symbolsCountMax;

    /**
     * @param string|null $value
     * @return string
     */
    public function getRowViewForString(string $value = null): string
    {
        return view('admin::form.fields.string')->with([
            'name' => $this->name,
            'field' => $this->field,
            'value' => $value,
            'validationName' => $this->getFieldForSave(),
            'rightPrefix' => $this->getRightPrefix(),
            'leftPrefix' => $this->getLeftPrefix(),
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
     * @param string $value
     * @return FieldAbstract
     */
    public function rightPrefix(string $value): FieldAbstract
    {
        $this->rightPrefix = $value;
        return $this;
    }

    /**
     * @param string $value
     * @return FieldAbstract
     */
    public function leftPrefix(string $value): FieldAbstract
    {
        $this->leftPrefix = $value;
        return $this;
    }

    /**
     * @return string|null
     */
    protected function getRightPrefix(): ?string
    {
        return $this->rightPrefix;
    }

    /**
     * @return string|null
     */
    protected function getLeftPrefix(): ?string
    {
        return $this->leftPrefix;
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
