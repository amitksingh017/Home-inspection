<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 30.09.2019
 */

namespace Appus\Admin\Table;

use Appus\Admin\Cards\CardInterface;
use Appus\Admin\Exceptions\InvalidTypeException;
use Appus\Admin\Metrics\MetricsTrait;
use Appus\Admin\Table\Traits\ActionsTrait;
use Appus\Admin\Cards\CardsTrait;
use Appus\Admin\Table\Traits\FilterableTrait;
use Appus\Admin\Table\Traits\MultiActionsTrait;
use Appus\Admin\Traits\CssAndJsTrait;
use Illuminate\Database\Eloquent\Model;
use Appus\Admin\Table\Traits\ColumnsTrait;
use Appus\Admin\Table\Traits\RenderableTrait;
use Appus\Admin\Table\Traits\PaginationTrait;
use Appus\Admin\Table\Traits\QueryableTrait;
use Appus\Admin\Table\Traits\SearchableTrait;
use Illuminate\Support\Collection;

class Table implements CardInterface
{

    use ColumnsTrait,
        RenderableTrait,
        PaginationTrait,
        QueryableTrait,
        SearchableTrait,
        ActionsTrait,
        MultiActionsTrait,
        CardsTrait,
        FilterableTrait,
        MetricsTrait,
        CssAndJsTrait;

    protected $model;
    protected $title;
    protected $subtitle;

    /**
     * Table constructor.
     * @param $model
     * @throws InvalidTypeException
     */
    public function __construct($model)
    {
        if (!$model instanceof Model && !$model instanceof Collection) {
            throw new InvalidTypeException('Model must be an instance of ' . Model::class . ' or ' . Collection::class);
        }
        $this->model = $model;
        $this->initActions();
        $this->initMultiActions();
    }

    /**
     * @return string
     */
    public function getCardView(): string
    {
        return 'admin::table.card';
    }

    /**
     * @param string $title
     * @return Table
     */
    public function setTitle(string $title): Table
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @param string $subtitle
     * @return Table
     */
    public function setSubtitle(string $subtitle): Table
    {
        $this->subtitle = $subtitle;
        return $this;
    }



}
