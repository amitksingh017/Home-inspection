<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 23.10.2019
 */

namespace Appus\Admin\Table\Filters;

use Appus\Admin\EncryptionService;
use Illuminate\Database\Eloquent\Builder;

abstract class FilterAbstract
{

    protected $name;

    protected $key;

    /**
     * @return string
     */
    protected function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getKey(): string
    {
        if (null === $this->key) {
            $this->key = mb_strtolower(str_replace(' ', '-', $this->name));
        }
        return $this->key;
    }

    /**
     * @return string
     */
    public function getClassNameHash()
    {
        return EncryptionService::encrypt(get_class($this));
    }

    /**
     * @return mixed
     */
    protected function getValue()
    {
        return request()->get('filter')[$this->getKey()];
    }

    /**
     * @param $query
     * @return mixed
     */
    abstract public function getQuery($query);

    /**
     * @return string
     */
    abstract public function render(): string;

}
