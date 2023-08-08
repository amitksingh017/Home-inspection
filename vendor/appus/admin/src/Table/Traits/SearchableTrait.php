<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 15.10.2019
 */

namespace Appus\Admin\Table\Traits;

trait SearchableTrait
{

    protected $searchable;

    /**
     * @param bool $searchable
     * @return $this
     */
    public function searchable(bool $searchable = true)
    {
        $this->searchable = $searchable;
        return $this;
    }

    /**
     * @return array
     */
    protected function getSearchableColumns(): array
    {
        if (empty($this->columns) || !$this->searchable) {
            return [];
        }
        $columns = [];
        foreach ($this->columns as $column) {
            if ($column->isSearchable()) {
                $columns[] = $column->getField();
            }
        }
        return $columns;
    }

}
