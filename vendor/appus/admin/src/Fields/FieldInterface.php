<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 30.10.2019
 */

namespace Appus\Admin\Fields;

interface FieldInterface
{

    /**
     * @param \Closure $callback
     * @return FieldInterface
     */
    public function displayAs(\Closure $callback): FieldInterface;

    /**
     * @param \Closure $callback
     * @return FieldInterface
     */
    public function valueAs(\Closure $callback): FieldInterface;

    /**
     * @return bool
     */
    public function isColumn(): bool;

    /**
     * @return string|null
     */
    public function render(): ?string;

}
