<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 10.10.2019
 */

namespace Appus\Admin\Table\Columns;

class TagColumn extends ColumnAbstract
{

    protected $delimiter;

    protected $color;

    /**
     * @param string|null $value
     * @return string|null
     */
    public function getCellViewForString(string $value = null): ?string
    {
        if (null === $this->delimiter) {
            $this->delimiter();
        }
        $value = explode($this->delimiter, $value);
        return view('admin::table.columns.tag')->with([
            'value' => $value,
            'color' => $this->color ?? $this->getDefaultColor(),
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
     * @param string $delimiter
     * @return ColumnInterface
     */
    public function delimiter(string $delimiter = ','): ColumnInterface
    {
        $this->delimiter = $delimiter;
        return $this;
    }

    /**
     * @param string $color
     * @return ColumnInterface
     */
    public function color(string $color): ColumnInterface
    {
        $this->color = $color;
        return $this;
    }

    /**
     * @return string
     */
    protected function getDefaultColor(): string
    {
        return '#1dc9b7';
    }

}
