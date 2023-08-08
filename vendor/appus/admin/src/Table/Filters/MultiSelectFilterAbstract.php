<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 21.04.2020
 */

namespace Appus\Admin\Table\Filters;

abstract class MultiSelectFilterAbstract extends FilterAbstract
{

    /**
     * @return string
     * @throws \Throwable
     */
    public function render(): string
    {
        return view('admin::table.filters.multi-select')
            ->with([
                'name' => $this->getName(),
                'key' => $this->getKey(),
                'selected' => request()->get('filter')[$this->getKey()] ?? '',
                'options' => $this->options(),
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
        return $this->query($query, $value);
    }

    /**
     * @param $query
     * @param array $values
     * @return mixed
     */
    abstract public function query($query, array $values);

    /**
     * @return array
     */
    abstract public function options(): array;

}
