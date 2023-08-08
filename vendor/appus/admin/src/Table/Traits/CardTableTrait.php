<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 18.03.2020
 */

namespace Appus\Admin\Table\Traits;

use Appus\Admin\Cards\Card;
use Appus\Admin\Table\Table;
use Illuminate\Database\Eloquent\Model;

trait CardTableTrait
{

    /**
     * @param \Closure $callback
     * @param Model|null $model
     * @return Card
     */
    public function tableCard(\Closure $callback, Model $model = null): Card
    {
        $className = Table::class;
        $card = $this->initCard($className, $callback, $model);
        $item = $card->getItem();
        $item->ajax(false)
            ->searchable(false)
            ->multiActions(false)
            ->disablePagination(true);
        return $card;
    }

}
