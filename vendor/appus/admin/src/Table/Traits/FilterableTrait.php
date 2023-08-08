<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 19.11.2019
 */

namespace Appus\Admin\Table\Traits;

trait FilterableTrait
{

    protected $filters;

    protected $hideFilterToMenu;

    /**
     * @param \Closure $callback
     * @return $this
     */
    public function filters(\Closure $callback)
    {
        $filters = $callback();
        if (!empty($filters)) {
            foreach ($filters as $filter) {
                $this->filters[$filter->getKey()] = $filter;
            }
        }
        return $this;
    }

    /**
     * @param bool $value
     * @return $this
     */
    public function hideFilterToMenu(bool $value = true)
    {
        $this->hideFilterToMenu = $value;
        return $this;
    }

    /**
     * @return bool
     */
    public function isHiddenFilterToMenu(): bool
    {
        if (null === $this->hideFilterToMenu) {
            $this->hideFilterToMenu();
        }
        return $this->hideFilterToMenu;
    }

}
