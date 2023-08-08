<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 31.10.2019
 */

namespace Appus\Admin\Details\Fields;

use Appus\Admin\Fields\FieldInterface;

class ImageField extends FileField
{

    protected $styles;

    protected $isLabelHidden;

    /**
     * @param null $value
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    protected function getView($value = null)
    {
        return view('admin::details.fields.image')->with([
            'name' => $this->name,
            'value' => $value,
            'downloadable' => $this->isDownloadable(),
            'displayWithUrl' => $this->isDisplayWithUrl(),
            'styles' => $this->styles,
            'isLabelHidden' => $this->isLabelHidden(),
        ]);
    }

    /**
     * @param int $value
     * @return FieldInterface
     */
    public function width(int $value): FieldInterface
    {
        $this->styles['width'] = $value . 'px';

        return $this;
    }

    /**
     * @param int $value
     * @return FieldInterface
     */
    public function height(int $value): FieldInterface
    {
        $this->styles['height'] = $value . 'px';

        return $this;
    }

    /**
     * @param array $options
     * @return FieldInterface
     */
    public function styles(array $options): FieldInterface
    {
        $this->styles = array_merge($this->styles ?? [], $options);

        return $this;
    }

    /**
     * @param bool $value
     * @return $this|FieldInterface
     */
    public function hideLabel(bool $value = false): FieldInterface
    {
        $this->isLabelHidden = $value;

        return $this;
    }

    /**
     * @return bool
     */
    protected function isLabelHidden(): bool
    {
        if (null === $this->isLabelHidden) {
            $this->hideLabel();
        }

        return $this->isLabelHidden;
    }

}
