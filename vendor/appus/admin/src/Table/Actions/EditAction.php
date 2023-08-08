<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 28.10.2019
 */

namespace Appus\Admin\Table\Actions;

class EditAction extends Action
{

    const ROUTE = 'edit';

    /**
     * EditAction constructor.
     * @param string|null $name
     * @param string|null $modelName
     * @throws \Throwable
     */
    public function __construct(string $name = null, string $modelName = null)
    {
        parent::__construct($name, $modelName);
        $this->init();
    }

    /**
     * @throws \Throwable
     */
    public function init()
    {
        $this->name('Edit')
            ->asView('admin::table.actions.edit');
        $this->initRoute(self::ROUTE);
    }

}
