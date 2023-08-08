<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 20.11.2019
 */

namespace Appus\Admin\Metrics;

trait MetricsTrait
{

    protected $metrics;

    /**
     * @param \Closure $callback
     * @return $this
     */
    public function metrics(\Closure $callback)
    {
        $this->metrics = $callback();
        return $this;
    }

    /**
     * @return array|null
     */
    protected function getMetrics(): ?array
    {
        return $this->metrics;
    }

}
