<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 01.11.2019
 */

namespace Appus\Admin\Form;

class RouteStorage
{

    protected $route;

    protected $params;

    protected $method;

    protected $asAbsoluteUrl;

    public function __construct(string $value, array $params = [])
    {
        $this->route = $value;
        $this->params = $params;
    }

    /**
     * @param bool $value
     * @return RouteStorage
     */
    public function asAbsoluteUrl(bool $value = false): RouteStorage
    {
        $this->asAbsoluteUrl = $value;
        return $this;
    }

    /**
     * @param string $value
     * @return RouteStorage
     */
    public function method(string $value = 'post'): RouteStorage
    {
        $this->method = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        if ($this->isAbsoluteUrl()) {
            return url($this->route, $this->params);
        }
        return route($this->route, $this->params);
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        if (null === $this->method) {
            $this->method();
        }
        return mb_strtoupper($this->method);
    }

    /**
     * @return bool
     */
    protected function isAbsoluteUrl(): bool
    {
        if (null === $this->asAbsoluteUrl) {
            $this->asAbsoluteUrl();
        }
        return $this->asAbsoluteUrl;
    }

}
