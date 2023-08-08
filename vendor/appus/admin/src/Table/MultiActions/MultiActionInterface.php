<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 11.02.2020
 */

namespace Appus\Admin\Table\MultiActions;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\View\View;

interface MultiActionInterface
{

    /**
     * @param Model $model
     * @return MultiActionInterface
     */
    public function setModel(Model $model): MultiActionInterface;

    /**
     * @return string
     */
    public function getKey(): string;

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return string
     */
    public function getIcon(): string;

    /**
     * @return string
     */
    public function getModelName(): string;

    /**
     * @return string|null
     */
    public function getjsFunctionNameCallback(): ?string;

    /**
     * @return bool
     */
    public function isReloadPageAfterAction(): bool;

    /**
     * @return string|null
     */
    public function getRedirectUrl(): ?string;

    /**
     * @param Collection $collection
     * @return array|null
     */
    public function run(Collection $collection): ?array;

    /**
     * @return string
     */
    public function getStyle(): string;

    /**
     * @return View
     */
    public function render(): View;

}
