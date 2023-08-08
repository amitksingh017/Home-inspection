<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 15.10.2019
 */

namespace Appus\Admin\Table\Traits;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

trait QueryableTrait
{

    protected $query;
    protected $with;
    protected $defaultSort;

    /**
     * @param \Closure $query
     * @return $this
     */
    public function query(\Closure $query)
    {
        $this->query = $query;
        return $this;
    }

    /**
     * @param string $field
     * @param string $direction
     * @return $this
     */
    public function defaultSort(string $field, string $direction = 'asc')
    {
        $this->defaultSort = $field . '__' . $direction;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function with($value)
    {
        $this->with = $value;
        return $this;
    }

    /**
     * @return LengthAwarePaginator
     */
    protected function getData(): LengthAwarePaginator
    {
        $query = $this->getQuery();
        return $this->paginate($query);
    }

    /**
     * @return Collection|null
     */
    protected function getQuery()
    {
        $query = $this->getNewQuery();

        if (null !== $this->with) {
            $this->initWithQuery($query);
        }

        if (null !== $this->query) {
            $callback = $this->query;
            $callback($query);
        }

        $search = request()->get('search', null);

        if ($search) {
            $query = $this->initSearchQuery($query, $search);
        }

        $sort = $this->getSort();

        if ($sort) {
            $sort = explode('__', $sort);
            $query = $this->initSortQuery($query, $sort[0], $sort[1]);
        }

        $filter = request()->get('filter');

        if ($filter && $this->filters) {
            $filter = array_keys($filter);
            foreach ($filter as $key) {
                if ($this->filters[$key]) {
                    $query = $this->filters[$key]->getQuery($query);
                }
            }
        }

        return $query;
    }

    /**
     * @return string|null
     */
    protected function getSort(): ?string
    {
        $sort = request()->get('sort');
        if (empty($sort)) {
            $sort = $this->defaultSort;
        }
        return $sort ?? null;
    }

    /**
     * @return Collection
     */
    protected function getNewQuery()
    {
        if ($this->model instanceof Collection) {
            return $this->model;
        }
        return $this->model->newQuery();
    }

    /**
     * @param $query
     * @return Collection
     */
    protected function initWithQuery($query)
    {
        if ($query instanceof Collection) {
            return $query->load($this->with);
        }
        return $query->with($this->with);
    }

    /**
     * @param $query
     * @param string $field
     * @param string $direction
     * @return Collection
     */
    protected function initSortQuery($query, string $field, string $direction = 'asc')
    {
        if (!isset($this->columns[$field]) || !$this->columns[$field]->isSortable()) {

            if ($this->defaultSort) {
                $sort = explode('__', $this->defaultSort);

                return $query->orderBy($sort[0], $sort[1]);
            }

            return $query;
        }
        if ($query instanceof Collection) {
            if ('asc' === $direction) {
                return $query->sortBy($field);
            }
            return $query->sortByDesc($field);
        }
        return $query->orderBy($field, $direction);
    }

    /**
     * @param $query
     * @param string $search
     * @return Collection|null
     */
    protected function initSearchQuery($query, string $search)
    {
        $searchable = $this->getSearchableColumns();
        if (!$searchable) {
            return $query;
        }
        if ($query instanceof Collection) {
            foreach ($searchable as $column) {
                $query = $query->where($column, $search);
            }
            return $query;
        }
        return $query->where(function ($q1) use ($searchable, $search) {
            foreach ($searchable as $column) {
                $q1->orWhere($column, 'like', "%$search%");
            }
        });
    }

}
