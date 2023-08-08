<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 15.10.2019
 */

namespace Appus\Admin\Table\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

trait PaginationTrait
{

    protected $itemPerPage;
    protected $itemPerPageOptions = [10, 20, 50, 100, 500];
    protected $disabledPagination;

    /**
     * @param int $itemPerPage
     * @return $this
     */
    public function itemPerPage(int $itemPerPage = 10)
    {
        if (request('itemPerPage')) {
            $itemPerPage = request('itemPerPage');
        }
        $this->itemPerPage = $itemPerPage;

        return $this;
    }

    /**
     * @param array $options
     * @return $this
     */
    public function itemPerPageOptions(array $options = [])
    {
        if (!empty($options)) {
            $this->itemPerPageOptions = $options;
        }
        return $this;
    }

    /**
     * @param bool $value
     * @return $this
     */
    public function disablePagination(bool $value = false)
    {
        $this->disabledPagination = $value;
        return $this;
    }

    /**
     * @return bool
     */
    protected function isDisabledPagination(): bool
    {
        if (null === $this->disabledPagination) {
            $this->disablePagination();
        }
        return $this->disabledPagination;
    }

    /**
     * @param $query
     * @return LengthAwarePaginator
     */
    protected function paginate($query): LengthAwarePaginator
    {
        $itemPerPage = $this->itemPerPage;
        if ($this->isDisabledPagination()) {
            $itemPerPage = $query->count();
        }
        return $query->paginate($itemPerPage);
    }

}
