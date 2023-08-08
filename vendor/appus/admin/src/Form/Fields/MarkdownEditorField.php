<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 27.03.2020
 */

namespace Appus\Admin\Form\Fields;

class MarkdownEditorField extends FieldAbstract
{

    /**
     * @param string|null $value
     * @return string
     */
    public function getRowViewForString(string $value = null): string
    {
        return view('admin::form.fields.markdown-editor')->with([
            'name' => $this->name,
            'field' => $this->field,
            'value' => $value,
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

}
