<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 25.10.2019
 */

namespace Appus\Admin\Table\Actions;

use Appus\Admin\Exceptions\InvalidFormatException;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class Action implements ActionInterface
{

    protected $name;

    protected $view;

    protected $route;

    protected $field;

    protected $params;

    protected $disabled;

    protected $resource;

    protected $cssClasses;

    public function __construct(string $name = null, string $modelName = null)
    {
        if (null !== $name) {
            $this->name($name);
        }
        $this->setResource($modelName);
    }

    /**
     * @param string $name
     * @return ActionInterface
     */
    public function name(string $name): ActionInterface
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name ?? '';
    }

    /**
     * @param string $value
     * @return ActionInterface
     * @throws \Throwable
     */
    public function asView(string $value): ActionInterface
    {
        $this->view = view($value)->render();
        return $this;
    }

    /**
     * @param string $value
     * @return ActionInterface
     */
    public function asHtml(string $value): ActionInterface
    {
        $this->view = $value;
        return $this;
    }

    /**
     * @param string $value
     * @return ActionInterface
     */
    public function route(string $value): ActionInterface
    {
        $this->route = $value;
        return $this;
    }

    /**
     * @param string $route
     */
    public function initRoute(string $route)
    {
        if (null !== $this->resource) {
            $route = $this->resource . '.' . $route;
            if (Route::has($route)) {
                $this->route = $route;
                $this->field = Str::singular($this->resource);
            }
        }
    }

    /**
     * @param string $value
     * @return ActionInterface
     */
    public function field(string $value): ActionInterface
    {
        $this->field = $value;
        return $this;
    }

    /**
     * @param array $params
     * @return ActionInterface
     */
    public function params(array $params = []): ActionInterface
    {
        $this->params = $params;
        return $this;
    }

    /**
     * @param bool $value
     * @return ActionInterface
     */
    public function disabled(bool $value = false): ActionInterface
    {
        $this->disabled = $value;
        return $this;
    }

    /**
     * @return bool
     */
    public function isDisabled(): bool
    {
        if (null === $this->disabled) {
            $this->disabled();
        }
        return $this->disabled;
    }

    /**
     * @param null $row
     * @return null|string
     */
    public function getUrl($row = null): ?string
    {
        if (null === $this->route) {
            return null;
        }
        if (null === $this->params) {
            $this->params();
        }
        $params = $this->params;
        if (null !== $this->field && null !== $row) {
            if (null === $row->{$this->field}) {
                $row->{$this->field} = $row->id;
            }
            $params[$this->field] = $row->{$this->field};
        }
        return route($this->route, $params);
    }

    /**
     * @param $value
     * @return ActionInterface
     * @throws InvalidFormatException
     */
    public function cssClasses($value): ActionInterface
    {
        if (!is_string($value) && !is_array($value)) {
            throw new InvalidFormatException('CSS classes must be a string or an array');
        }
        $this->cssClasses = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getCssClasses(): string
    {
        if (null === $this->cssClasses) {
            return '';
        }
        if (is_array($this->cssClasses)) {
            return implode(' ', $this->cssClasses);
        }
        return $this->cssClasses;
    }

    /**
     * @return string
     */
    public function render(): string
    {
        return $this->view ?? '';
    }

    /**
     * @param string|null $modelName
     * @return bool
     */
    protected function setResource(string $modelName = null): bool
    {
        if (null !== $modelName) {
            $this->resource = Str::plural($modelName);
            return true;
        }
        $currentRoute = Route::currentRouteName();
        if (!empty($currentRoute)) {
            $currentRoute = explode('.', $currentRoute);
            if (isset($currentRoute[1]) && 'index' === $currentRoute[1]) {
                $this->resource = $currentRoute[0];
            }
        }
        return true;
    }

}
