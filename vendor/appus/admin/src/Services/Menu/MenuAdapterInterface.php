<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 15.01.2020
 */

namespace Appus\Admin\Services\Menu;

interface MenuAdapterInterface
{

    /**
     * @param string $name
     * @param bool $topMenu
     * @return MenuDto
     */
    public function add(string $name, bool $topMenu = false): MenuDto;

    /**
     * @param bool $topMenu
     * @return array|null
     */
    public function get(bool $topMenu = false): ?array;

}
