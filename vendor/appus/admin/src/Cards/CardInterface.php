<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 18.11.2019
 */

namespace Appus\Admin\Cards;

use Illuminate\Database\Eloquent\Model;

interface CardInterface
{

    /**
     * @param \Closure $callback
     * @param Model $model
     * @return Card
     */
    public function card(\Closure $callback, Model $model): Card;

    /**
     * @param int $value
     * @return mixed
     */
    public function setWidth(int $value);

    /**
     * @return string
     */
    public function getCardView(): string;

}
