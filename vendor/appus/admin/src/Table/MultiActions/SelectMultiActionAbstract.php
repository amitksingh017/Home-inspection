<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 08.04.2020
 */

namespace Appus\Admin\Table\MultiActions;

use Illuminate\Support\Collection;
use Illuminate\View\View;

abstract class SelectMultiActionAbstract extends MultiActionAbstract
{

    /**
     * @param Collection $collection
     * @param string|null $selected
     * @return array|null
     */
    abstract public function run(Collection $collection, string $selected = null): ?array;

    /**
     * @return array
     */
    abstract public function options(): array;

    /**
     * @return View
     */
    public function render(): View
    {
        $mainParams = parent::render()->getData();
        return view('admin::table.multi-actions.select')
            ->with($mainParams)
            ->with([
                'options' => $this->options(),
            ]);
    }

}
