<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 17.01.2020
 */

namespace Appus\Admin\ViewComposers;

use Illuminate\View\View;

class TopMenuComposer extends MenuComposerAbstract
{

    public function compose(View $view)
    {
        $menuItems = $this->getItems(true);
        $view->with([
            'topMenuItems' => $menuItems ?? [],
        ]);
    }



}
