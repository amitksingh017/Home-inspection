<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 01.11.2019
 */

namespace Appus\Admin;

use Appus\Admin\Fields\ColumnField;
use Illuminate\View\View;

interface FormInterface
{

    /**
     * @param string $value
     * @return FormInterface
     */
    public function setTitle(string $value): FormInterface;

    /**
     * @param \Closure $callback
     * @return ColumnField
     */
    public function column(\Closure $callback): ColumnField;

    /**
     * @param bool $render
     * @param string $template
     * @return string
     */
    public function render(bool $render = false, string $template = ''): string;

}
