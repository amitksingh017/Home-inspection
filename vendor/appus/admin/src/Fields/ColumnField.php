<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 31.10.2019
 */

namespace Appus\Admin\Fields;

use Appus\Admin\Fields\Traits\FieldsTrait;
use Illuminate\Database\Eloquent\Model;

class ColumnField
{

    use FieldsTrait;

    protected $callbackFields;

    protected $model;

    protected $width;

    protected $factory;

    public function __construct(\Closure $callback, $model, string $factory)
    {
        $this->callbackFields = $callback;
        $this->model = $model;
        $this->factory = $factory;
    }

    /**
     * @return string
     */
    protected function getFieldsFactory(): string
    {
        return $this->factory;
    }

    /**
     * @param float $value
     * @return ColumnField
     */
    public function width(float $value): ColumnField
    {
        $this->width = $this->validateWidth($value);
        return $this;
    }

    /**
     * @return bool
     */
    public function isColumn(): bool
    {
        return true;
    }

    /**
     * @return string
     */
    public function render(): string
    {
        $this->initFields();
        return view('admin::details.fields.column')->with([
            'fields' => $this->fields,
            'width' => $this->width,
        ]);
    }

    public function initFields()
    {
        $callback = $this->callbackFields;
        $callback($this);
    }

    /**
     * @param float $value
     * @return float
     */
    protected function validateWidth(float $value): float
    {
        if ($value > 100) {
            $value = 100;
        }
        if ($value  < 0) {
            $value = 0;
        }
        return $value;
    }

}
