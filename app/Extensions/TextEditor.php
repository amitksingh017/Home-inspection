<?php

namespace App\Extensions;

use Appus\Admin\Form\Fields\FieldAbstract;

class TextEditor extends FieldAbstract
{

    /**
     * @inheritDoc
     */
    public function getRowViewForString(string $value = null): ?string
    {
        return view('extensions.form-fields.text-editor')->with([
            'name' => $this->name,
            'field' => $this->field,
            'value' => $value,
            'validationName' => $this->getFieldForSave(), // применяется для валидации
        ]);
    }

    /**
     * @inheritDoc
     */
    public function getRowViewForArray(array $value = null): ?string
    {
        return null;
    }

}
