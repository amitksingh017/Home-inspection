<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 01.11.2019
 */

namespace Appus\Admin\Form\Traits;

use Appus\Admin\Form\RouteStorage;
use Illuminate\Support\Facades\Route;

trait RouteTrait
{

    protected $storeRoute;

    protected $updateRoute;

    protected $action;

    /**
     * @param string $value
     * @return $this
     */
    public function currentRouteAction(string $value)
    {
        $this->action = $value;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCurrentRouteAction(): ?string
    {
        return $this->action ?? request()->get('_action', 'create');
    }

    /**
     * @param string $value
     * @param array $params
     * @return RouteStorage
     */
    public function storeRoute(string $value, array $params = []): RouteStorage
    {
        $this->storeRoute = app(RouteStorage::class, ['value' => $value, 'params' => $params]);
        return $this->storeRoute;
    }

    /**
     * @param string $value
     * @param array $params
     * @return RouteStorage
     */
    public function updateRoute(string $value, array $params = []): RouteStorage
    {
        $this->updateRoute = app(RouteStorage::class, ['value' => $value, 'params' => $params]);
        return $this->updateRoute;
    }

    /**
     * @return string
     */
    protected function getSavingUrl(): string
    {
        if ('create' === $this->action) {
            return $this->getStoreRoute()->getUrl();
        }
        if ('edit' === $this->action) {
            return $this->getUpdateRoute()->getUrl();
        }
    }

    /**
     * @return string
     */
    protected function getSavingMethod(): string
    {
        if ('create' === $this->action) {
            return $this->getStoreRoute()->getMethod();
        }
        if ('edit' === $this->action) {
            return $this->getUpdateRoute()->getMethod();
        }
    }

    /**
     * @return RouteStorage
     */
    protected function getStoreRoute(): RouteStorage
    {
        if (null === $this->storeRoute) {
            $this->storeRoute($this->getResource() . '.store');
        }
        return $this->storeRoute;
    }

    /**
     * @return RouteStorage
     */
    protected function getUpdateRoute(): RouteStorage
    {
        if (null === $this->updateRoute) {
            $this->updateRoute($this->getResource() . '.update', request()->route()->parameters())
                ->method('put');
        }
        return $this->updateRoute;
    }

    /**
     * @return null|string
     */
    public function getResource(): ?string
    {
        $currentRoute = Route::currentRouteName();
        $currentRoute = explode('.', $currentRoute);
        return $currentRoute[0] ?? null;
    }

}
