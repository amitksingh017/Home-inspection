<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 24.10.2019
 */

namespace Appus\Admin\Table\Traits;

use Appus\Admin\Table\Actions\ActionInterface;
use Appus\Admin\Table\Actions\Action;
use Appus\Admin\Table\Actions\CreateAction;
use Appus\Admin\Table\Actions\DeleteAction;
use Appus\Admin\Table\Actions\EditAction;
use Appus\Admin\Table\Actions\ViewAction;

trait ActionsTrait
{

    protected $rowActions;

    protected $tableActions;

    protected $hideRowActionsToMenu;

    protected $hideTableActionsToMenu;

    /**
     * @return Action
     */
    public function createAction(): Action
    {
        return $this->tableActions['create'];
    }

    /**
     * @return Action
     */
    public function viewAction(): Action
    {
        return $this->rowActions['view'];
    }

    /**
     * @return Action
     */
    public function editAction(): Action
    {
        return $this->rowActions['edit'];
    }

    /**
     * @return Action
     */
    public function deleteAction(): Action
    {
        return $this->rowActions['delete'];
    }

    /**
     * @param string|null $name
     * @return ActionInterface
     */
    public function customRowAction(string $name = null): ActionInterface
    {
        $customAction = app(Action::class, ['name' => $name]);
        $this->rowActions[] = $customAction;
        return $customAction;
    }

    /**
     * @param string|null $name
     * @return ActionInterface
     */
    public function customTableAction(string $name = null): ActionInterface
    {
        $customAction = app(Action::class, ['name' => $name]);
        $this->tableActions[] = $customAction;
        return $customAction;
    }

    /**
     * @param bool $value
     * @return $this
     */
    public function hideRowActionsToMenu(bool $value = false)
    {
        $this->hideRowActionsToMenu = $value;
        return $this;
    }

    /**
     * @return bool
     */
    public function isHiddenRowActions(): bool
    {
        if (null === $this->hideRowActionsToMenu) {
            $this->hideRowActionsToMenu();
        }
        return $this->hideRowActionsToMenu;
    }

    /**
     * @param bool $value
     * @return $this
     */
    public function hideTableActionsToMenu(bool $value = false)
    {
        $this->hideTableActionsToMenu = $value;
        return $this;
    }

    /**
     * @return bool
     */
    public function isHiddenTableActions(): bool
    {
        if (null === $this->hideTableActionsToMenu) {
            $this->hideTableActionsToMenu();
        }
        return $this->hideTableActionsToMenu;
    }

    /**
     * @return string
     */
    protected function getModelName(): string
    {
        $modelName = get_class($this->model);
        $modelName = explode(substr('\/', 0, 1), $modelName);
        $modelName = array_pop($modelName);
        return mb_strtolower($modelName);
    }

    protected function initActions()
    {
        $this->tableActions['create'] = app(CreateAction::class, ['modelName' => $this->getModelName()]);
        $this->rowActions['view'] = app(ViewAction::class, ['modelName' => $this->getModelName()]);
        $this->rowActions['edit'] = app(EditAction::class, ['modelName' => $this->getModelName()]);
        $this->rowActions['delete'] = app(DeleteAction::class, ['modelName' => $this->getModelName()]);
    }

}
