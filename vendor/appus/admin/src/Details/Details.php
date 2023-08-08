<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 30.10.2019
 */

namespace Appus\Admin\Details;

use Appus\Admin\Cards\CardInterface;
use Appus\Admin\Cards\CardsTrait;
use Appus\Admin\FormAbstract;
use Appus\Admin\Details\Fields\FieldFactory;

class Details extends FormAbstract implements CardInterface
{

    use CardsTrait;

    protected $cards;

    protected $width;

    /**
     * @return string
     */
    protected function getFieldsFactory(): string
    {
        return FieldFactory::class;
    }

    /**
     * @return string
     */
    public function getCardView(): string
    {
        return 'admin::details.card';
    }

    /**
     * @param bool $render
     * @param string $template
     * @return string
     * @throws \Throwable
     */
    public function render(bool $render = false, string $template = 'admin::details.index'): string
    {
        if (request()->ajax()) {
            return $this->renderAjax();
        }
        $view = view($template)->with($this->getParams());
        if ($render) {
            return $view->render();
        }
        return $view;
    }

    /**
     * @return string
     */
    public function renderAjax(): string
    {
        return view('admin::details.card')->with($this->getParams());
    }

    /**
     * @return array
     */
    protected function getParams(): array
    {
        return [
            'title' => $this->title,
            'fields' => $this->fields,
            'cards' => $this->getCards(),
            'width' => $this->width,
            'metrics' => $this->getMetrics(),
            'body' => $this->isBody(),
            'viewPrepend' => $this->viewPrepend,
            'viewAppend' => $this->viewAppend,
            'css' => $this->css,
            'js' => $this->js,
        ];
    }

}
