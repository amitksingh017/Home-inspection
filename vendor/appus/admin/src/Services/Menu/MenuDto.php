<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 14.01.2020
 */

namespace Appus\Admin\Services\Menu;

class MenuDto
{

    protected $name;
    protected $route;
    protected $url;
    protected $sub;
    protected $icon;
    protected $order;
    protected $active;
    protected $actions;
    protected $minimizeText;
    protected $if;

    public function __construct(string $name)
    {
        $this->name = $name;
        $this->order();
    }

    /**
     * @param string $route
     * @param array $params
     * @param bool $absoluteUrl
     * @return MenuDto
     */
    public function route(string $route, array $params = [], bool $absoluteUrl = false): MenuDto
    {
        if ($absoluteUrl) {
            $this->url = url($route, $params);
            return $this;
        }
        $this->route = $route;
        $this->url = route($route, $params);
        return $this;
    }

    /**
     * @param string $className
     * @return MenuDto
     */
    public function icon(string $className): MenuDto
    {
        $this->icon = $className;
        return $this;
    }

    /**
     * @param int $value
     * @return MenuDto
     */
    public function order(int $value = 0): MenuDto
    {
        $this->order = $value;
        return $this;
    }

    /**
     * @param \Closure $callback
     * @return MenuDto
     */
    public function sub(\Closure $callback): MenuDto
    {
        $menuAdapter = app(MenuAdapterInterface::class);
        $callback($menuAdapter);
        $this->sub = $menuAdapter;
        return $this;
    }

    /**
     * @param array $actions
     * @return MenuDto
     */
    public function actions(array $actions): MenuDto
    {
        $this->actions = $actions;
        return $this;
    }

    /**
     * @param bool $value
     * @return MenuDto
     */
    public function active(bool $value = false): MenuDto
    {
        $this->active = $value;
        return $this;
    }

    /**
     * @param bool $value
     * @return MenuDto
     */
    public function minimizeText(bool $value = false): MenuDto
    {
        $this->minimizeText = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string|null
     */
    public function getRoute(): ?string
    {
        return $this->route;
    }

    /**
     * @return string|null
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * @return string|null
     */
    public function getIcon(): ?string
    {
        return $this->icon;
    }

    /**
     * @return int
     */
    public function getOrder(): int
    {
        return $this->order;
    }

    /**
     * @return array
     */
    public function getSub(): array
    {
        if (null === $this->sub) {
            return [];
        }
        $items = $this->sub->get();
        if (empty($items)) {
            $items = $this->sub->get(true);
        }
        return $items;
    }

    /**
     * @return bool
     */
    public function hasSub(): bool
    {
        return null !== $this->sub && (!empty($this->getSub()));
    }

    /**
     * @return array
     */
    public function getActions(): array
    {
        return $this->actions ?? [];
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        if (null === $this->active) {
            $this->active();
        }
        return $this->active;
    }

    /**
     * @return bool
     */
    public function isMinimizeText(): bool
    {
        if (null === $this->minimizeText) {
            $this->minimizeText();
        }
        return $this->minimizeText;
    }

    /**.
     * @param \Closure|null $callback
     * @return bool
     */
    public function if(\Closure $callback = null): bool
    {
        if (null === $callback) {
            if (null === $this->if) {
                return true;
            }
            $if = $this->if;

            return $if();
        }

        $this->if = $callback;
        return true;
    }

}
