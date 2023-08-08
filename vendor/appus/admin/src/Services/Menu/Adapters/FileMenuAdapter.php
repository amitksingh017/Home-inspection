<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 14.01.2020
 */

namespace Appus\Admin\Services\Menu\Adapters;

use Appus\Admin\Services\Menu\MenuAdapterInterface;
use Appus\Admin\Services\Menu\MenuDto;

class FileMenuAdapter implements MenuAdapterInterface
{

    protected $sideMenu;

    protected $topMenu;

    /**
     * @param string $name
     * @param bool $topMenu
     * @return MenuDto
     */
    public function add(string $name, bool $topMenu = false): MenuDto
    {
        $item = $this->getItem($name);
        $this->addItem($item, $topMenu);
        return $item;
    }

    /**
     * @param bool $topMenu
     * @return array|null
     */
    public function get(bool $topMenu = false): ?array
    {
        if ($topMenu) {
            return $this->topMenu;
        }
        return $this->sideMenu;
    }

    /**
     * @param MenuDto $item
     * @param bool $topMenu
     * @return bool
     */
    protected function addItem(MenuDto $item, bool $topMenu): bool
    {
        if ($topMenu) {
            $this->topMenu[] = $item;
            return true;
        }
        $this->sideMenu[] = $item;
        return true;
    }

    /**
     * @param string $name
     * @return MenuDto
     */
    protected function getItem(string $name): MenuDto
    {
        return new MenuDto($name);
    }

}
