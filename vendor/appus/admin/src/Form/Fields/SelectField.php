<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 19.11.2019
 */

namespace Appus\Admin\Form\Fields;

class SelectField extends FieldAbstract
{

    protected $options;

    /**
     * @param string|null $value
     * @return string
     */
    public function getRowViewForString(string $value = null): string
    {
        return view('admin::form.fields.select')->with([
            'name' => $this->name,
            'field' => $this->field,
            'value' => $value,
            'options' => $this->getOptions(),
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
     * @param array $options
     * @return FieldAbstract
     */
    public function options(array $options = []): FieldAbstract
    {
        $this->options = $options;
        return $this;
    }

    /**
     * @return array|null
     */
    protected function getOptions(): ?array
    {
        return $this->options;
    }

}
