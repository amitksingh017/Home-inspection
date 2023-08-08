<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 30.10.2019
 */

namespace Appus\Admin\Details\Fields;

use Appus\Admin\Fields\FieldAbstract;

class StringField extends FieldAbstract
{

    /**
     * @param string|null $value
     * @return string
     */
    public function getRowViewForString(string $value = null): string
    {
        return view('admin::details.fields.string')->with([
            'name' => $this->name,
            'value' => $value,
        ]);
    }

    /**
     * @param array|null $value
     * @return string|null
     */
    public function getRowViewForArray(array $value = null): ?string
    {
        if (null === $value) {
            return $this->getRowViewForString(null);
        }
        return $this->getRowViewForString(implode("<br />", $value));
    }

}
