<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 31.10.2019
 */

namespace Appus\Admin\Details\Fields;

use Appus\Admin\Fields\FieldAbstract;

class UrlField extends FieldAbstract
{

    /**
     * @param string|null $value
     * @return string
     */
    public function getRowViewForString(string $value = null): string
    {
        return $this->getView($value);
    }

    /**
     * @param array|null $value
     * @return string|null
     */
    public function getRowViewForArray(array $value = null): ?string
    {
        return $this->getView($value);
    }

    /**
     * @param null $value
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    protected function getView($value = null)
    {
        return view('admin::details.fields.url')->with([
            'name' => $this->name,
            'value' => $value,
        ]);
    }

}
