<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 20.03.2020
 */

namespace Appus\Admin\Details\Fields;

use Appus\Admin\Fields\FieldAbstract;
use Appus\Admin\Fields\FieldInterface;

class ColorField extends FieldAbstract
{

    protected $withText;

    /**
     * @param string|null $value
     * @return string
     */
    public function getRowViewForString(string $value = null): string
    {
        return view('admin::details.fields.color')->with([
            'name' => $this->name,
            'value' => $value,
            'isWithText' => $this->isWithText(),
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

    /**
     * @param bool $value
     * @return FieldInterface
     */
    public function withText(bool $value = false): FieldInterface
    {
        $this->withText = $value;
        return $this;
    }

    /**
     * @return bool
     */
    protected function isWithText(): bool
    {
        if (null === $this->withText) {
            $this->withText();
        }
        return $this->withText;
    }

}
