<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 01.11.2019
 */

namespace Appus\Admin;

use Appus\Admin\Fields\ColumnField;
use Appus\Admin\Fields\Traits\FieldsTrait;
use Appus\Admin\Traits\CssAndJsTrait;
use Appus\Admin\Traits\ViewTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Appus\Admin\Metrics\MetricsTrait;

abstract class FormAbstract implements FormInterface
{

    use FieldsTrait, MetricsTrait, ViewTrait, CssAndJsTrait;

    protected $model;

    protected $title;

    /**
     * FormAbstract constructor.
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $this->initModel($model);
    }

    /**
     * @param string $value
     * @return FormInterface
     */
    public function setTitle(string $value): FormInterface
    {
        $this->title = $value;
        return $this;
    }

    /**
     * @return Model
     */
    public function model(): Model
    {
        return $this->model;
    }

    /**
     * @param \Closure $callback
     * @return ColumnField
     */
    public function column(\Closure $callback): ColumnField
    {
        $column = app(ColumnField::class, [
            'callback' => $callback,
            'model' => $this->model,
            'factory' => $this->getFieldsFactory()
        ]);
        $this->fields[] = $column;
        return $column;
    }

    /**
     * @param Model $model
     * @return Model
     */
    protected function initModel(Model $model): Model
    {
        $routeParams = request()->route()->parameters();
        if (!empty($routeParams) && empty($model->toArray())) {
            $table = $model->getTable();
            foreach($routeParams as $field => $param) {
                if (Schema::hasColumn($table, $field)) {
                    $model = $model->where($field, $param);
                } elseif (is_numeric($param)) {
                    $model = $model->where('id', $param);
                }
            }
            $model = $model->first();
        }
        return $model;
    }

    /**
     * @return string
     */
    abstract protected function getFieldsFactory(): string;

}
