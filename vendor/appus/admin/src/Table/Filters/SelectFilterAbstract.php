<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 23.10.2019
 */

namespace Appus\Admin\Table\Filters;

abstract class SelectFilterAbstract extends FilterAbstract
{

    /**
     * @return string
     * @throws \Throwable
     */
    public function render(): string
    {
        return view('admin::table.filters.select')
            ->with([
                'name' => $this->getName(),
                'options' => $this->options(),
                'key' => $this->getKey(),
                'selected' => request()->get('filter')[$this->getKey()] ?? ''
            ])->render();
    }

    /**
     * @param $query
     * @return mixed
     */
    public function getQuery($query)
    {
        $value = $this->getValue();
        if (null === $value) {
            return $query;
        }
        return $this->query($query, $value);
    }

    /**
     * @param $query
     * @param string $value
     * @return mixed
     */
    abstract public function query($query, string $value);

    /**
     * @return array
     */
    abstract public function options(): array;

}
