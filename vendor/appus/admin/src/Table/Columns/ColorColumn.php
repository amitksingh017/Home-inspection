<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 20.03.2020
 */

namespace Appus\Admin\Table\Columns;

class ColorColumn extends ColumnAbstract
{

    protected $withText;

    /**
     * @param string|null $value
     * @return string|null
     */
    public function getCellViewForString(string $value = null): ?string
    {
        return view('admin::table.columns.color')->with([
            'value' => $value,
            'isWithText' => $this->isWithText(),
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
        $delimiter = "<br />";
        if (!$this->isWithText()) {
            $delimiter = ' ';
        }
        return implode($delimiter, $values);
    }

    /**
     * @param bool $value
     * @return ColumnInterface
     */
    public function withText(bool $value = false): ColumnInterface
    {
        $this->withText = $value;
        return $this;
    }

    /**
     * @return bool
     */
    protected function isWithText(): bool
    {
        if (null === $this->withText) {
            $this->withText();
        }
        return $this->withText;
    }

}
