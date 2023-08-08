<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 26.03.2020
 */

namespace Appus\Admin\Details\Fields;

use Appus\Admin\Fields\FieldAbstract;
use Appus\Admin\Fields\FieldInterface;

class DateTimeField extends FieldAbstract
{

    protected $format;

    /**
     * @param string|null $value
     * @return string
     */
    public function getRowViewForString(string $value = null): string
    {
        return view('admin::details.fields.date-time')->with([
            'name' => $this->name,
            'value' => $this->parseDate($value),
        ]);
    }

    /**
     * @param array|null $value
     * @return string|null
     */
    public function getRowViewForArray(array $value = null): ?string
    {
        if (null === $value) {
            return $this->getRowViewForString(null);
        }
        $value = $this->parseDates($value);
        return $this->getRowViewForString(implode("<br />", $value));
    }

    /**
     * @param string $value
     * @return FieldInterface
     */
    public function format(string $value = 'Y-m-d H:i:s'): FieldInterface
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
