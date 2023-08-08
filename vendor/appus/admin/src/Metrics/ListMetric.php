<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 17.04.2020
 */

namespace Appus\Admin\Metrics;

abstract class ListMetric extends MetricAbstract
{

    protected $header;

    /**
     * @param array $filter
     * @return string
     * @throws \Throwable
     */
    public function load(array $filter = []): string
    {
        return view('admin::metrics.list')->with([
            'data' => $this->buildData($filter),
            'header' => $this->buildHeader(),
        ])->render();
    }

    /**
     * @param array $filter
     * @return array
     */
    protected function buildData(array $filter = []): array
    {
        $data = $this->getData($filter);
        if (empty($data)) {
            return [];
        }
        foreach ($data as &$row) {
            if (!is_array($row)) {
                $row = [$row];
            }
        }
        unset($row);
        return $data;
    }

    /**
     * @return array
     */
    protected function buildHeader(): array
    {
        $data = $this->header;
        if (empty($data)) {
            return [];
        }
        if (!is_array($data)) {
            $data = [$data];
        }
        return $data;
    }

    /**
     * @param array $filter
     * @return array
     */
    abstract public function getData(array $filter = []): array;

}
