<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 28.10.2019
 */

namespace Appus\Admin\Table\Actions;

class ViewAction extends Action
{

    const ROUTE = 'show';

    /**
     * ViewAction constructor.
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
        $this->name('View')
            ->asView('admin::table.actions.view');
        $this->initRoute(self::ROUTE);
    }

}
