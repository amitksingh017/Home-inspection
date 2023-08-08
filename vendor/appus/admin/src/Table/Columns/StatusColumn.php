<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 10.10.2019
 */

namespace Appus\Admin\Table\Columns;

class StatusColumn extends ColumnAbstract
{

    protected $options;

    /**
     * @param string|null $value
     * @return string|null
     */
    public function getCellViewForString(string $value = null): ?string
    {
        return view('admin::table.columns.status')->with([
            'value' => $value,
            'option' => $this->options[$value] ?? $this->getDefaultOption()
        ]);
    }

    /**
     * @param array|null $value
     * @return string|null
     */
    public function getCellViewForArray(array $value = null): ?string
    {
        if (null === $value) {
            return $this->getCellViewForString(null);
        }
        $values = [];
        foreach ($value as $row) {
            $values[] = $this->getCellViewForString($row);
        }
        return implode("<br />", $values);
    }

    /**
     * @param array $options
     * @return ColumnInterface
     */
    public function options(array $options): ColumnInterface
    {
        $this->options = $options;
        return $this;
    }

    /**
     * @return string
     */
    protected function getDefaultOption(): string
    {
        return '#5867dd';
    }

}
