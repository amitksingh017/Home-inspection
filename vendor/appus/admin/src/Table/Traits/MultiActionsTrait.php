<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 11.02.2020
 */

namespace Appus\Admin\Table\Traits;

use Appus\Admin\Exceptions\InvalidTypeException;
use Appus\Admin\Table\MultiActions\DeleteMultiAction;
use Appus\Admin\Table\MultiActions\MultiActionInterface;
use Illuminate\Database\Eloquent\Model;

trait MultiActionsTrait
{

    protected $multiActions;
    protected $disableMultiActions;
    protected $hideMultiActionsToMenu;
    protected $hideMultiActionsWhenUnselected;

    /**
     * @param $callback
     * @return $this
     * @throws InvalidTypeException
     */
    public function multiActions($callback)
    {
        if (false === $callback) {
            $this->disableMultiActions = true;
            return $this;
        }
        if (!$callback instanceof \Closure && !is_array($callback)) {
            throw new InvalidTypeException('Argument must be an instance of ' . \Closure::class . ' or array');
        }
        if ($callback instanceof \Closure) {
            $multiActions = $callback();
        }
        if (is_array($callback)) {
            $multiActions = $callback();
        }
        foreach ($multiActions as $multiAction) {
            $this->addMultiAction($multiAction);
        }
        return $this;
    }

    /**
     * @return array
     */
    public function getMultiActions(): array
    {
        if ($this->disableMultiActions) {
            return [];
        }
        return $this->multiActions ?? [];
    }

    public function disableMultiDelete()
    {
        if (!empty($this->multiActions)) {
            foreach ($this->multiActions as $key => &$action) {
                if ($action instanceof DeleteMultiAction) {
                    unset($this->multiActions[$key]);
                    break;
                }
            }
            unset($action);
        }
    }

    /**
     * @param bool $value
     * @return $this
     */
    public function hideMultiActionsWhenUnselected(bool $value = false)
    {
        $this->hideMultiActionsWhenUnselected = $value;

        return $this;
    }

    /**
     * @param bool $value
     * @return $this
     */
    public function hideMultiActionsToMenu(bool $value = false)
    {
        $this->hideMultiActionsToMenu = $value;
        return $this;
    }

    /**
     * @return bool
     */
    public function isHiddenMultiActions(): bool
    {
        if (null === $this->hideMultiActionsToMenu) {
            $this->hideMultiActionsToMenu();
        }
        return $this->hideMultiActionsToMenu;
    }

    /**
     * @return bool
     */
    public function isHiddenMultiActionsWhenUnselected(): bool
    {
        if (null === $this->hideMultiActionsWhenUnselected) {
            $this->hideMultiActionsWhenUnselected();
        }

        return $this->hideMultiActionsWhenUnselected;
    }

    /**
     * @param MultiActionInterface $multiAction
     */
    protected function addMultiAction(MultiActionInterface $multiAction)
    {
        $multiAction->setModel($this->model);
        $this->multiActions[$multiAction->getKey()] = $multiAction;
    }

    protected function initMultiActions()
    {
        if ($this->model instanceof Model) {
            $deleteMultiAction = new DeleteMultiAction();
            $deleteMultiAction->setModel($this->model);
            $this->addMultiAction($deleteMultiAction);
        }
    }

}
