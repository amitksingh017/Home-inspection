<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 16.04.2020
 */

namespace Appus\Admin\Table\Filters;

abstract class DateRangeFilterAbstract extends FilterAbstract
{

    protected $format = 'MM/DD/YYYY';

    /**
     * @return string
     * @throws \Throwable
     */
    public function render(): string
    {
        return view('admin::table.filters.date-range')
            ->with([
                'name' => $this->getName(),
                'key' => $this->getKey(),
                'selected' => request()->get('filter')[$this->getKey()] ?? '',
                'format' => $this->format ?? null,
            ])->render();
    }

    /**
     * @param $query
     * @return mixed
     */
    public function getQuery($query)
    {
        $value = $this->getValue();
        if (empty($value)) {
            return $query;
        }
        $value = explode(' - ', $value);
        return $this->query($query, $value[0], $value[1]);
    }

    /**
     * @param $query
     * @param string $from
     * @param string $to
     * @return mixed
     */
    abstract public function query($query, string $from, string $to);

}
