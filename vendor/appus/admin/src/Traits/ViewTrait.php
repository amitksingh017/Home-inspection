<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 23.12.2019
 */

namespace Appus\Admin\Traits;

trait ViewTrait
{

    protected $viewPrepend;

    protected $viewAppend;

    protected $body;

    /**
     * @param bool $value
     * @return $this
     */
    public function body(bool $value = true)
    {
        $this->body = $value;
        return $this;
    }

    /**
     * @return bool
     */
    public function isBody(): bool
    {
        if (null === $this->body) {
            $this->body();
        }
        return $this->body;
    }

    /**
     * @param string $view
     * @param array $params
     * @return $this
     * @throws \Throwable
     */
    public function viewPrepend(string $view, array $params = [])
    {
        $this->viewPrepend = view($view, $params)->render();
        return $this;
    }

    /**
     * @param string $view
     * @param array $params
     * @return $this
     * @throws \Throwable
     */
    public function viewAppend(string $view, array $params = [])
    {
        $this->viewAppend = view($view, $params)->render();
        return $this;
    }

}
