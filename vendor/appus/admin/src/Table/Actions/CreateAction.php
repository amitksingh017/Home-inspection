<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 28.10.2019
 */

namespace Appus\Admin\Table\Actions;

class CreateAction extends Action
{

    const ROUTE = 'create';

    /**
     * CreateAction constructor.
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
        $this->name('Create')
            ->asView('admin::table.actions.create');
        $this->initRoute(self::ROUTE);
    }

}
