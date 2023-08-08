<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 30.03.2020
 */

namespace Appus\Admin\Form\Fields;

class BelongsToManySelectField extends BelongsToManyCheckboxField
{

    /**
     * @param array|null $value
     * @return string|null
     */
    public function getRowViewForArray(array $value = null): ?string
    {
        return view('admin::form.fields.belongs-to-many-select', [
            'name' => $this->name,
            'field' => $this->field,
            'value' => $value,
            'options' => $this->getOptions(),
            'validationName' => $this->getFieldForSave(),
            'help' => $this->help,
        ]);
    }

}
