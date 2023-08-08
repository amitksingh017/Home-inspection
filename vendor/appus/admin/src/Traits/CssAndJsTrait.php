<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 15.04.2020
 */

namespace Appus\Admin\Traits;

use Appus\Admin\Exceptions\InvalidFormatException;

trait CssAndJsTrait
{

    protected $css;
    protected $js;

    /**
     * @param $value
     * @return $this
     * @throws InvalidFormatException
     */
    public function css($value)
    {
        $this->checkCssAndJsFormat($value);
        $this->css = $this->getCssOrJsValue($value);
        return $this;
    }

    /**
     * @param $value
     * @return $this
     * @throws InvalidFormatException
     */
    public function js($value)
    {
        $this->checkCssAndJsFormat($value);
        $this->js = $this->getCssOrJsValue($value);
        return $this;
    }

    /**
     * @param $value
     * @throws InvalidFormatException
     */
    private function checkCssAndJsFormat($value)
    {
        if (!$value instanceof \Closure && !is_array($value)) {
            throw new InvalidFormatException('Value must be an instance of ' . \Closure::class . ' or an array');
        }
    }

    /**
     * @param $value
     * @return array
     */
    private function getCssOrJsValue($value): array
    {
        if ($value instanceof \Closure) {
            $value = $value();
        }
        return $value;
    }

}
