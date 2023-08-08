<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 18.03.2020
 */

namespace Appus\Admin\Details\Traits;

use Appus\Admin\Cards\Card;
use Appus\Admin\Details\Details;
use Illuminate\Database\Eloquent\Model;

trait CardDetailsTrait
{

    /**
     * @param \Closure $callback
     * @param Model|null $model
     * @return Card
     */
    public function detailsCard(\Closure $callback, Model $model = null): Card
    {
        $className = Details::class;
        return $this->initCard($className, $callback, $model);
    }

}
