<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 28.10.2019
 */

namespace Appus\Admin\Table\Actions;

class DeleteAction extends Action
{

    const ROUTE = 'destroy';

    /**
     * DeleteAction constructor.
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
        $this->name('Delete')
            ->asView('admin::table.actions.delete');
        $this->initRoute(self::ROUTE);
    }

}
