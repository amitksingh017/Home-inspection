<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 22.11.2019
 */

namespace Appus\Admin\Metrics\Filters;

abstract class FilterAbstract
{

    protected $name;

    protected $key;

    /**
     * FilterAbstract constructor.
     * @param string $name
     * @param string $key
     */
    public function __construct(string $name, string $key)
    {
        $this->name = $name;
        $this->key = $key;
    }

    /**
     * @return string
     */
    abstract public function render(): string;

}
