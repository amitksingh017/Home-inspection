<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 20.11.2019
 */

namespace Appus\Admin\Metrics;

abstract class LineMetric extends MetricAbstract
{

    /**
     * @param array $filter
     * @return string
     * @throws \Throwable
     */
    public function load(array $filter = []): string
    {
        return view('admin::metrics.line')->with([
            'data' => $this->getData($filter),
            'key' => $this->getKey(),
            'name' => $this->getName(),
        ])->render();
    }

    /**
     * @param array $filter
     * @return array
     */
    abstract public function getData(array $filter = []): array;

}
