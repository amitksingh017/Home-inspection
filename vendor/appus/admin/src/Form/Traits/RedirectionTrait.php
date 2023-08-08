<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 04.11.2019
 */

namespace Appus\Admin\Form\Traits;

use Appus\Admin\Form\RedirectStorage;
use Illuminate\Http\RedirectResponse;

trait RedirectionTrait
{

    protected $redirectWhenCreated;

    protected $redirectWhenUpdated;

    protected $redirectWhenDeleted;

    /**
     * @param string|null $value
     * @param array $params
     * @return RedirectStorage
     */
    public function redirectWhenCreated(string $value = null, array $params = []): RedirectStorage
    {
        
        $redirectStorage = app(RedirectStorage::class, ['value' => $value, 'params' => $params]);
        $this->redirectWhenCreated = $redirectStorage;
        return $redirectStorage;
    }

    /**
     * @param string|null $value
     * @param array $params
     * @return RedirectStorage
     */
    public function redirectWhenUpdated(string $value = null, array $params = []): RedirectStorage
    {
        $redirectStorage = app(RedirectStorage::class, ['value' => $value, 'params' => $params]);
        $this->redirectWhenUpdated = $redirectStorage;
        return $redirectStorage;
    }

    /**
     * @param string|null $value
     * @param array $params
     * @return RedirectStorage
     */
    public function redirectWhenDeleted(string $value = null, array $params = []): RedirectStorage
    {
        $redirectStorage = app(RedirectStorage::class, ['value' => $value, 'params' => $params]);
        $this->redirectWhenDeleted = $redirectStorage;
        return $redirectStorage;
    }

    /**
     * @return RedirectResponse|null
     */
    public function getDeletedRedirect(): ?RedirectResponse
    {
        if (null === $this->redirectWhenDeleted) {
            $resource = $this->getResource();
            $route = $resource . '.index';
            $this->redirectWhenDeleted = app(RedirectStorage::class, ['value' => $route]);
        }
        return $this->redirectWhenDeleted->getRedirect();
    }

    /**
     * @return RedirectResponse|null
     */
    protected function getRedirect(): ?RedirectResponse
    {
        $action = request()->get('_action', 'create');
        if ('create' === $action) {
            return $this->getCreatedRedirect();
        } elseif ('edit' === $action) {
            return $this->getUpdatedRedirect();
        }
    }

    /**
     * @return RedirectResponse|null
     */
    protected function getCreatedRedirect(): ?RedirectResponse
    {
        if (null === $this->redirectWhenCreated) {
            $resource = $this->getResource();
            $route = $resource . '.index';
            $this->redirectWhenCreated = app(RedirectStorage::class, ['value' => $route]);
        }
        return $this->redirectWhenCreated->getRedirect();
    }

    /**
     * @return RedirectResponse|null
     */
    protected function getUpdatedRedirect(): ?RedirectResponse
    {
        if (null === $this->redirectWhenUpdated) {
            $resource = $this->getResource();
            $route = $resource . '.index';
            $this->redirectWhenUpdated = app(RedirectStorage::class, ['value' => $route]);
        }
        return $this->redirectWhenUpdated->getRedirect();
    }

}
