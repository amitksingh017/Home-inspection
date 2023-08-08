<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 31.10.2019
 */

namespace Appus\Admin\Details\Fields;

class AvatarField extends ImageField
{

    /**
     * @param null $value
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    protected function getView($value = null)
    {
        return view('admin::details.fields.avatar')->with([
            'name' => $this->name,
            'value' => $value,
            'downloadable' => $this->isDownloadable(),
            'displayWithUrl' => $this->isDisplayWithUrl(),
            'styles' => $this->styles,
            'isLabelHidden' => $this->isLabelHidden(),
        ]);
    }

}
