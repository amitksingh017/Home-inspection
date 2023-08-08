<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 19.11.2019
 */

namespace Appus\Admin\Metrics;

abstract class CountMetric extends MetricAbstract
{

    /**
     * @param array $filter
     * @return string
     * @throws \Throwable
     */
    public function load(array $filter = []): string
    {
        return view('admin::metrics.count')->with([
            'count' => $this->getCount($filter),
        ])->render();
    }

    /**
     * @param array $filter
     * @return int
     */
    abstract public function getCount(array $filter = []): int;

}
