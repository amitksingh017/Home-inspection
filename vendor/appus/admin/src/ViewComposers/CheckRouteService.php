<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 28.01.2020
 */

namespace Appus\Admin\ViewComposers;

class CheckRouteService
{

    protected $actionName;
    protected $controllerName;
    protected $resourceName;
    protected $resourcePrefix;

    public function __construct()
    {
        $this->actionName = $this->getActionName();
        $this->controllerName = $this->getControllerName();
        $this->resourceName = $this->getResourceName();
        $this->resourcePrefix = $this->getResourcePrefix();
    }

    /**
     * @param array $actions
     * @return bool
     */
    public function checkActive(array $actions): bool
    {
        if (empty($actions)) {
            return false;
        }
        if ($this->checkByActionName($actions)) {
            return true;
        }
        if ($this->checkByControllerName($actions)) {
            return true;
        }
        if ($this->checkByResourceName($actions)) {
            return true;
        }
        if ($this->checkByResourcePrefix($actions)) {
            return true;
        }
        return false;
    }

    /**
     * @param string|null $itemUrl
     * @param string|null $itemRoute
     * @return bool
     */
    public function checkActiveDefault(string $itemUrl = null, string $itemRoute = null): bool
    {
        if (null !== $itemRoute) {
            $currentResourcePrefix = $this->parseResourcePrefix($itemRoute);
            if ($currentResourcePrefix === $this->resourcePrefix) {
                return true;
            }
        }
        if (null !== $itemUrl) {
            $currentUrl = url(request()->route()->uri());
            if ($currentUrl === $itemUrl) {
                return true;
            }
        }
        return false;
    }

    /**
     * @param array $actions
     * @return bool
     */
    protected function checkByActionName(array $actions): bool
    {
        return in_array($this->actionName, $actions);
    }

    /**
     * @param array $actions
     * @return bool
     */
    protected function checkByControllerName(array $actions): bool
    {
        return in_array($this->controllerName, $actions);
    }

    /**
     * @param array $actions
     * @return bool
     */
    protected function checkByResourceName(array $actions): bool
    {
        return in_array($this->resourceName, $actions);
    }

    /**
     * @param array $actions
     * @return bool
     */
    protected function checkByResourcePrefix(array $actions): bool
    {
        return in_array($this->resourcePrefix, $actions);
    }

    /**
     * @return string
     */
    protected function getActionName(): string
    {
        return request()->route()->getActionName();
    }

    /**
     * @return string
     */
    protected function getControllerName(): string
    {
        if (request()->route()->getActionName() === 'Closure') {
            return '';
        }
        return get_class(request()->route()->getController());
    }

    /**
     * @return string
     */
    protected function getResourceName(): string
    {
        return request()->route()->getName();
    }

    /**
     * @return string
     */
    protected function getResourcePrefix(): string
    {
        $resource = $this->getResourceName();
        return $this->parseResourcePrefix($resource);
    }

    /**
     * @param string $resource
     * @return string
     */
    protected function parseResourcePrefix(string $resource): string
    {
        $resourcePrefix = explode('.', $resource);
        array_pop($resourcePrefix);
        return implode('.', $resourcePrefix);
    }

}
