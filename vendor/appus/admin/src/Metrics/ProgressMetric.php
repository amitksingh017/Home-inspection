<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 16.04.2020
 */

namespace Appus\Admin\Metrics;

abstract class ProgressMetric extends MetricAbstract
{

    protected $color = '#22b9ff';
    protected $label;

    /**
     * @param array $filter
     * @return string
     * @throws \Throwable
     */
    public function load(array $filter = []): string
    {
        $data = $this->getData($filter);
        if (!is_array($data)) {
            $data = [$data];
        }
        if (!is_array($this->color)) {
            $this->color = [$this->color];
        }
        if (!is_array($this->label)) {
            $this->label = [$this->label];
        }
        return view('admin::metrics.progress')->with([
            'data' => $data,
            'color' => $this->color,
            'label' => $this->label,
            'key' => $this->getKey(),
            'name' => $this->getName(),
        ])->render();
    }

    /**
     * @param array $filter
     * @return mixed
     */
    abstract public function getData(array $filter = []);

}
