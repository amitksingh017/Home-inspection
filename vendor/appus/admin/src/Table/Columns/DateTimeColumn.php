<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 26.03.2020
 */

namespace Appus\Admin\Table\Columns;

class DateTimeColumn extends ColumnAbstract
{

    protected $format;

    /**
     * @param string|null $value
     * @return string|null
     */
    public function getCellViewForString(string $value = null): ?string
    {
        return $this->parseDate($value);
    }

    /**
     * @param array|null $value
     * @return string|null
     */
    public function getCellViewForArray(array $value = null): ?string
    {
        $value = $this->parseDates($value);
        return implode("<br />", $value);
    }

    /**
     * @param string $value
     * @return ColumnInterface
     */
    public function format(string $value = 'Y-m-d H:i:s'): ColumnInterface
    {
        $this->format = $value;
        return $this;
    }

    /**
     * @param array $value
     * @return array
     */
    protected function parseDates(array $value)
    {
        if (empty($value)) {
            return $value;
        }
        $res = [];
        foreach ($value as $row) {
            $res[] = $this->parseDate($row);
        }
        return $res;
    }

    /**
     * @param string|null $value
     * @return false|string
     */
    protected function parseDate(string $value = null)
    {
        if (empty($value)) {
            return $value;
        }
        return date($this->getFormat(), strtotime($value));
    }

    /**
     * @return string
     */
    protected function getFormat(): string
    {
        if (null === $this->format) {
            $this->format();
        }
        return $this->format;
    }

}
