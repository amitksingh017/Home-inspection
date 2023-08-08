<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 05.02.2020
 */

namespace Appus\Admin\Table\MultiActions;

use Illuminate\Support\Collection;

class DeleteMultiAction extends MultiActionAbstract
{

    protected $name = 'Delete';
    protected $icon = 'fas fa-trash-alt';
    protected $reloadPageAfterAction = true;
    protected $confirmation = true;

    /**
     * @param Collection $collection
     * @return array|null
     */
    public function run(Collection $collection): ?array
    {
        $ids = $collection->pluck('id')->toArray();
        $collection->map(function ($item) {
            $item->delete();
        });
        return ['ids' => $ids];
    }

}
