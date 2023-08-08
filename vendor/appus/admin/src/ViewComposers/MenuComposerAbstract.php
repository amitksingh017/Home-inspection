<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 17.01.2020
 */

namespace Appus\Admin\ViewComposers;

use Appus\Admin\Services\Menu\Facades\Menu;
use Appus\Admin\Services\Menu\MenuDto;
use Appus\Admin\Services\Router;
use Illuminate\Routing\RouteCollection;

abstract class MenuComposerAbstract
{

    protected $checkRouteService;

    public function __construct(CheckRouteService $checkRouteService)
    {
        $this->includeFiles();
        $this->checkRouteService = $checkRouteService;
    }

    protected function includeFiles()
    {
        $files = config('admin.menu');
        if (!empty($files)) {
            foreach ($files as $file) {
                require_once $file;
            }
        }
    }

    /**
     * @param bool $topMenu
     * @return array
     */
    protected function getItems(bool $topMenu = false): array
    {
        $items = Menu::get($topMenu);
        if (!empty($items)) {
            $items = $this->buildItems($items);
        }
        return $items ?? [];
    }

    /**
     * @param array $menuItems
     * @return array
     */
    protected function buildItems(array $menuItems): array
    {
        $menuItems = collect($menuItems);
        $menuItems = $menuItems->sortBy(function ($item) {
            return $item->getOrder();
        })->toArray();
        $this->checkActiveItems($menuItems);
        return $menuItems;
    }

    /**
     * @param array $menuItems
     * @return array
     */
    protected function checkActiveItems(array $menuItems): array
    {
        foreach ($menuItems as $item) {
            if ($this->checkActive($item)) {
                $item->active(true);
            }
            $subItems = $item->getSub();
            if (!empty($subItems)) {
                $this->checkActiveItems($subItems);
            }
        }
        return $menuItems;
    }

    /**
     * @param MenuDto $item
     * @return bool
     */
    protected function checkActive(MenuDto $item): bool
    {
        $actions = $item->getActions();
        if ($this->checkRouteService->checkActive($actions)) {
            return true;
        }
        return $this->checkRouteService->checkActiveDefault($item->getUrl(), $item->getRoute());
    }

}
