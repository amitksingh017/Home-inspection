<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 22.11.2019
 */

namespace Appus\Admin\Metrics\Filters;

class SelectFilter extends FilterAbstract
{

    protected $options;

    /**
     * SelectFilter constructor.
     * @param string $name
     * @param string $key
     * @param array $options
     */
    public function __construct(string $name, string $key, array $options)
    {
        parent::__construct($name, $key);
        $this->options = $options;
    }

    /**
     * @return string
     * @throws \Throwable
     */
    public function render(): string
    {
        return view('admin::metrics.filters.select')->with([
            'name' => $this->name,
            'key' => $this->key,
            'options' => $this->options,
        ])->render();
    }

}
