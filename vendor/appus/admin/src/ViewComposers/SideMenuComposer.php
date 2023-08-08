<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 14.01.2020
 */

namespace Appus\Admin\ViewComposers;

use Illuminate\View\View;

class SideMenuComposer extends MenuComposerAbstract
{

    public function compose(View $view)
    {
        $menuItems = $this->getItems();
        $view->with([
            'menuItems' => $menuItems ?? [],
        ]);
    }

}
