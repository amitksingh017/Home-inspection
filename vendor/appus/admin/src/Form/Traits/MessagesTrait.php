<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 22.01.2020
 */

namespace Appus\Admin\Form\Traits;

use Illuminate\Support\Str;

trait MessagesTrait
{

    protected $creationMessage;

    protected $editingMessage;

    protected $deletingMessage;

    /**
     * @param string $message
     * @return $this
     */
    public function creationMessage(string $message)
    {
        $this->creationMessage = $message;
        return $this;
    }

    /**
     * @param string $message
     * @return $this
     */
    public function editingMessage(string $message)
    {
        $this->editingMessage = $message;
        return $this;
    }

    /**
     * @param string $message
     * @return $this
     */
    public function deletingMessage(string $message)
    {
        $this->deletingMessage = $message;
        return $this;
    }

    /**
     * @param string $action
     * @param string|null $resource
     * @return string
     */
    public function getMessage(string $action, string $resource = null): string
    {
        $resource = $resource ?? 'Resource';
        $resource = Str::singular($resource);
        if ('create' === $action) {
            return $this->getCreationMessage($resource);
        }
        if ('delete' === $action) {
            return $this->getDeletingMessage($resource);
        }
        return $this->getEditingMessage($resource);
    }

    /**
     * @param string $resource
     * @return string
     */
    protected function getDeletingMessage(string $resource): string
    {
        if (null === $this->deletingMessage) {
            $this->deletingMessage(ucfirst($resource) . ' deleted successfully');
        }
        return $this->deletingMessage;
    }

    /**
     * @param string $resource
     * @return string
     */
    protected function getCreationMessage(string $resource): string
    {
        if (null === $this->creationMessage) {
            $this->creationMessage(ucfirst($resource) . ' created successfully');
        }
        return $this->creationMessage;
    }

    /**
     * @param string $resource
     * @return string
     */
    protected function getEditingMessage(string $resource): string
    {
        if (null === $this->editingMessage) {
            $this->editingMessage(ucfirst($resource) . ' updated successfully');
        }
        return $this->editingMessage;
    }

}
