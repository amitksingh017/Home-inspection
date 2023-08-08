<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 04.11.2019
 */

namespace Appus\Admin\Form;

use Illuminate\Http\RedirectResponse;

class RedirectStorage
{

    protected $value;

    protected $asAbsoluteUrl;

    protected $params;

    public function __construct(string $value = null, array $params = [])
    {
        $this->value = $value;
        $this->params = $params;
    }

    /**
     * @param bool $value
     * @return RedirectStorage
     */
    public function asAbsoluteUrl(bool $value = false): RedirectStorage
    {
        $this->asAbsoluteUrl = $value;
        return $this;
    }

    /**
     * @param array $params
     * @return RedirectStorage
     */
    public function params(array $params = []): RedirectStorage
    {
        $this->params = array_merge($this->params, $params);
        return $this;
    }

    /**
     * @return RedirectResponse
     */
    public function getRedirect(): ?RedirectResponse
    {
        $url = $this->getUrl();
        if (null === $url) {
            return null;
        }
        return redirect($url);
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

    /**
     * @return string|null
     */
    protected function getUrl(): ?string
    {
        if (null === $this->value) {
            return null;
        }
        if ($this->isAbsoluteUrl()) {
            return url($this->value, $this->params);
        }
        return route($this->value, $this->params);
    }

}
