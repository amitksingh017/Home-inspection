<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 20.11.2019
 */

namespace Appus\Admin\Metrics;

abstract class DonutMetric extends PieMetric
{

    /**
     * @param array $filter
     * @return string
     * @throws \Throwable
     */
    public function load(array $filter = []): string
    {
        return view('admin::metrics.donut')->with([
            'data' => $this->getData($filter),
            'key' => $this->getKey(),
            'name' => $this->getName(),
        ])->render();
    }

}
