<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 31.10.2019
 */

namespace Appus\Admin\Form;

use Appus\Admin\Cards\CardInterface;
use Appus\Admin\Cards\CardsTrait;
use Appus\Admin\Form\Traits\MessagesTrait;
use Appus\Admin\FormAbstract;
use Appus\Admin\Form\Fields\FieldFactory;
use Appus\Admin\Messages\Facades\Message;
use Illuminate\Http\RedirectResponse;
use Appus\Admin\Form\Traits\RouteTrait;
use Appus\Admin\Form\Traits\ValidationTrait;
use Appus\Admin\Form\Traits\RedirectionTrait;

class Form extends FormAbstract implements CardInterface
{

    use RouteTrait,
        ValidationTrait,
        RedirectionTrait,
        CardsTrait,
        MessagesTrait;

    protected $relations;

    protected $ajax;

    /**
     * @return string
     */
    protected function getFieldsFactory(): string
    {
        return FieldFactory::class;
    }

    /**
     * @param CardInterface $mainItem
     * @return $this
     */
    public function initCardBeforeRender(CardInterface $mainItem)
    {
        $this->currentRouteAction($mainItem->getCurrentRouteAction());
        return $this;
    }

    /**
     * @return string
     */
    public function getCardView(): string
    {
        return 'admin::form.card';
    }

    /**
     * @param bool $value
     * @return $this
     */
    public function ajax(bool $value = true)
    {
        $this->ajax = $value;
        return $this;
    }

    /**
     * @return bool
     */
    public function isAjax(): bool
    {
        if (null === $this->ajax) {
            $this->ajax();
        }
        return $this->ajax;
    }

    /**
     * @param bool $render
     * @param string $template
     * @return string
     * @throws \Throwable
     */
    public function render(bool $render = false, string $template = 'admin::form.index'): string
    {
        $view = view($template)->with([
            'title' => $this->title,
            'fields' => $this->fields,
            'url' => $this->getSavingUrl(),
            'width' => $this->width,
            'method' => $this->getSavingMethod(),
            'action' => $this->action,
            'cards' => $this->getCards(),
            'metrics' => $this->getMetrics(),
            'ajax' => $this->isAjax(),
            'body' => $this->isBody(),
            'viewPrepend' => $this->viewPrepend,
            'viewAppend' => $this->viewAppend,
            'hash' => $this->getHash(),
            'css' => $this->css,
            'js' => $this->js,
        ]);
        if ($render) {
            return $view->render();
        }
        return $view;
    }

    /**
     * @return RedirectResponse|mixed|string
     */
    public function save()
    {
        $hash = request()->get('hash');
        if ($hash && isset($this->cards[$hash])) {
            return $this->cards[$hash]->getItem()->save();
        }
        $params = request()->all();
        $rules = $this->getValidationRules();
        $this->validate($params, $rules);
        if (!$this->isValidated()) {
            if ($this->isAjax()) {
                return response()->json(['success' => false, 'errors' => $this->getErrors()]);
            }
            return $this->redirectValidationFails();
        }

        $fields = $this->getFields();
        $models = $this->saveFields($fields);

        $this->saveModels($models);

        if (!empty($this->relations)) {
            $models = $this->saveFields($this->relations, true);
            $this->saveModels($models);
        }
        $redirect = $this->getRedirect();
        Message::success($this->getMessage($this->getCurrentRouteAction(), $this->getResource()));
        if ($this->isAjax()) {
            return response()->json([
                'success' => true,
                'url' => $redirect ? $redirect->getTargetUrl() : null,
                'messages' => !$redirect ? Message::getMessages() : null,
            ]);
        }
        return $redirect ? $redirect : redirect(request()->path());
    }

    /**
     * @return RedirectResponse
     * @throws \Exception
     */
    public function delete(): RedirectResponse
    {
        $this->model->delete();
        Message::success($this->getMessage('delete', $this->getResource()));
        return $this->getDeletedRedirect();
    }

    /**
     * @param array $fields
     * @param bool $saveRelations
     * @return array
     */
    protected function saveFields(array $fields, bool $saveRelations = false): array
    {
        $models = [];
        foreach ($fields as $field) {
            if (!$field->isColumn()) {
                if (!$saveRelations && $field->checkRelation()) {
                    $this->relations[] = $field;
                    continue;
                }
                $model = $field->save($this->model);
                if ($model) {
                    $models = array_merge($models, $model);
                }
                continue;
            }
            $this->saveFields($field->getFields());
        }
        return $models;
    }

    /**
     * @param array $models
     * @return bool
     */
    protected function saveModels(array $models): bool
    {
        if (empty($models)) {
            return false;
        }
        foreach ($models as $model) {
            $model->save();
        }
        return true;
    }

    /**
     * @return string|null
     */
    public function getHash(): ?string
    {
        if (empty($this->fields)) {
            return null;
        }
        return md5(get_class($this->model) . implode('', array_keys($this->fields)));
    }

}
