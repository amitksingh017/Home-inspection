<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 20.11.2019
 */

namespace Appus\Admin\Metrics;

abstract class BarMetric extends LineMetric
{

    /**
     * @param array $filter
     * @return string
     * @throws \Throwable
     */
    public function load(array $filter = []): string
    {
        return view('admin::metrics.bar')->with([
            'data' => $this->getData($filter),
            'key' => $this->getKey(),
            'name' => $this->getName(),
        ])->render();
    }

}
