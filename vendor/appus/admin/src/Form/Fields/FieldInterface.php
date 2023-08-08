<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 13.03.2020
 */

namespace Appus\Admin\Form\Fields;

use Appus\Admin\Fields\FieldInterface as FieldFormInterface;
use Illuminate\Database\Eloquent\Model;

interface FieldInterface extends FieldFormInterface
{

    /**
     * @return string
     */
    public function getField(): string;

    /**
     * @return string
     */
    public function getFieldForSave(): string;

    /**
     * @param \Closure $callback
     * @return FieldInterface
     */
    public function saveAs(\Closure $callback): FieldInterface;

    /**
     * @param Model $model
     * @return array
     */
    public function save(Model $model): array;

}
