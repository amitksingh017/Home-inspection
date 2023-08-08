<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 05.02.2020
 */

namespace Appus\Admin\Table\MultiActions;

use Appus\Admin\EncryptionService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\View\View;

abstract class MultiActionAbstract implements MultiActionInterface
{

    protected $model;
    protected $name;
    protected $icon;
    protected $jsFunctionNameCallback;
    protected $reloadPageAfterAction;
    protected $redirectUrl;
    protected $hideInfo = false;
    protected $hideIcon = false;
    protected $hideName = false;
    protected $confirmation = false;
    protected $style;

    /**
     * @param Model $model
     * @return MultiActionInterface
     */
    public function setModel(Model $model): MultiActionInterface
    {
        $this->model = $model;
        return $this;
    }

    /**
     * @return string
     */
    public function getKey(): string
    {
        return EncryptionService::encrypt(get_class($this));
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        if (null === $this->name) {
            $this->name = get_class($this);
            $this->name = explode(substr('\/', 0, 1), $this->name);
            $this->name = array_reverse($this->name);
            $this->name = $this->name[0];
        }
        return $this->name;
    }

    /**
     * @return string
     */
    public function getIcon(): string
    {
        if (null === $this->icon) {
            $this->icon = 'fas fa-question';
        }
        return $this->icon;
    }

    /**
     * @return string
     */
    public function getModelName(): string
    {
        return EncryptionService::encrypt(get_class($this->model));
    }

    /**
     * @return string|null
     */
    public function getjsFunctionNameCallback(): ?string
    {
        return $this->jsFunctionNameCallback;
    }

    /**
     * @return bool
     */
    public function isReloadPageAfterAction(): bool
    {
        if (null === $this->reloadPageAfterAction) {
            $this->reloadPageAfterAction = false;
        }
        return $this->reloadPageAfterAction;
    }

    /**
     * @return string|null
     */
    public function getRedirectUrl(): ?string
    {
        return $this->redirectUrl;
    }

    /**
     * @return string
     */
    public function getStyle(): string
    {
        if (null !== $this->style && is_array($this->style)) {
            foreach ($this->style as $key => $value) {
                $this->style[$key] = $key . ':' . $value;
            }
            $this->style = implode(';', $this->style);
        }
        return $this->style ?? '';
    }

    /**
     * @return View
     */
    public function render(): View
    {
        $this->getStyle();
        return view('admin::table.multi-actions.button', [
            'icon' => $this->getIcon(),
            'name' => $this->getName(),
            'hideInfo' => $this->hideInfo,
            'hideIcon' => $this->hideIcon,
            'hideName' => $this->hideName,
            'confirmation' => $this->confirmation,
            'style' => $this->getStyle(),
        ]);
    }

}
