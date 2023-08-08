<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 25.06.2020
 */

namespace Appus\Admin\Services\Admin;

use Appus\Admin\Exceptions\InvalidFormatException;

class Admin
{

    protected $css = [];

    protected $js = [];

    /**
     * @param null $styles
     * @return array
     * @throws InvalidFormatException
     */
    public function css($styles = null): array
    {
        if (null === $styles) {
            return $this->css;
        }

        if (is_string($styles)) {
            $this->css[] = $styles;

            return $this->css;
        }

        if (is_array($styles)) {
            $this->css = array_merge($this->css, $styles);

            return $this->css;
        }

        throw new InvalidFormatException('Argument must be a string or an array');
    }

    /**
     * @param null $scripts
     * @return array
     * @throws InvalidFormatException
     */
    public function js($scripts = null): array
    {
        if (null === $scripts) {
            return $this->js;
        }

        if (is_string($scripts)) {
            $this->js[] = $scripts;

            return $this->js;
        }

        if (is_array($scripts)) {
            $this->js = array_merge($this->js, $scripts);

            return $this->js;
        }

        throw new InvalidFormatException('Argument must be a string or an array');
    }

}
