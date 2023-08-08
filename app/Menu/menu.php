<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 14.01.2020
 */

/**
 *  It is configuration for menu items.
 *
 *  Adding of that items are like routes.
 *
 *  For more information read documentation.
 *
 */


use Appus\Admin\Services\Menu\Facades\Menu;


Menu::add('Inspector')
    ->order(1)
    ->icon('fas fa-user')
    ->route('inspectors.index');

Menu::add('Region')
    ->order(2)
    ->icon('fas fa-landmark')
    ->route('regions.index');

Menu::add('Report')
    ->order(3)
    ->icon('fas fa-chart-line')
    ->route('reports.index'); 
