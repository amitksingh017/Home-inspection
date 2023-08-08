<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 15.10.2019
 */

namespace Appus\Admin\Table\Traits;

use Appus\Admin\Traits\ViewTrait;

trait RenderableTrait
{

    use ViewTrait;

    protected $ajax;

    /**
     * @param bool $render
     * @param string $template
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     * @throws \Throwable
     */
    public function render(bool $render = false, string $template = 'admin::table.index')
    {
        $hash = request()->get('hash');
        if ($hash && isset($this->cards[$hash])) {
            return $this->cards[$hash]->render();
        }
        $this->initBeforeRender();
        if ($this->ajax && request()->ajax()) {
            return $this->renderAjax();
        }
        $view = view($template)
            ->with($this->getParamsForTable());
        if (!$this->ajax) {
            $view->with($this->getParamsForRender());
        }
        if ($render) {
            return $view->render();
        }
        return $view;
    }

    protected function initBeforeRender()
    {
        if (null === $this->ajax) {
            $this->ajax();
        }
        if (null === $this->itemPerPage) {
            $this->itemPerPage();
        }
        if (null === $this->searchable) {
            $this->searchable();
        }
        if (null === $this->body) {
            $this->body();
        }
    }

    /**
     * @param bool $status
     * @return $this
     */
    public function ajax(bool $status = true)
    {
        $this->ajax = $status;
        return $this;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    protected function renderAjax()
    {
        return view('admin::table.list')
            ->with($this->getParamsForRender());
    }

    /**
     * @return array
     */
    protected function getParamsForTable(): array
    {
        return [
            'title' => $this->title,
            'subtitle' => $this->subtitle,
            'search' => request()->get('search', ''),
            'searchable' => $this->searchable,
            'body' => $this->body,
            'viewPrepend' => $this->viewPrepend,
            'viewAppend' => $this->viewAppend,
            'filters' => $this->filters,
            'tableActions' => $this->tableActions,
            'isHiddenTableActions' => $this->isHiddenTableActions(),
            'columns' => !empty($this->columns),
            'cards' => $this->getCards(),
            'hash' => $this->getHash(),
            'width' => $this->width,
            'isHiddenFilterToMenu' => $this->isHiddenFilterToMenu(),
            'metrics' => $this->getMetrics(),
            'multiActions' => $this->getMultiActions(),
            'itemPerPage' => $this->itemPerPage,
            'isHiddenMultiActionsToMenu' => $this->isHiddenMultiActions(),
            'isHiddenMultiActionsWhenUnselected' => $this->isHiddenMultiActionsWhenUnselected(),
            'css' => $this->css,
            'js' => $this->js,
        ];
    }

    /**
     * @return array
     */
    protected function getParamsForRender(): array
    {
        return [
            'data' => $this->getData(),
            'disabledPagination' => $this->isDisabledPagination(),
            'columns' => $this->columns,
            'itemPerPageOptions' => $this->itemPerPageOptions,
            'rowActions' => $this->rowActions,
            'isHiddenRowActions' => $this->isHiddenRowActions(),
            'multiActions' => $this->getMultiActions(),
        ];
    }

}
