<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 10.10.2019
 */

namespace Appus\Admin\Table\Columns;

class ImageColumn extends ColumnAbstract
{

    protected $storage;

    protected $styles;

    /**
     * @param string|null $value
     * @return string|null
     */
    public function getCellViewForString(string $value = null): ?string
    {
        if (!isset($this->storage)) {
            $this->storage(config('filesystems.default'));
        }
        if ($this->storage) {
            $value = \Storage::disk($this->storage)->url($value);
        }
        return view('admin::table.columns.image')->with([
            'value' => $value,
            'styles' => $this->styles,
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
        return implode('', $values);
    }

    /**
     * @param string $storage
     * @return ColumnInterface
     */
    public function storage(string $storage): ColumnInterface
    {
        $this->storage = $storage;
        return $this;
    }

    /**
     * @param int $value
     * @return ColumnInterface
     */
    public function width(int $value): ColumnInterface
    {
        $this->styles['width'] = $value . 'px';
        return $this;
    }

    /**
     * @param int $value
     * @return ColumnInterface
     */
    public function height(int $value): ColumnInterface
    {
        $this->styles['height'] = $value . 'px';
        return $this;
    }

    /**
     * @param array $options
     * @return ColumnInterface
     */
    public function styles(array $options): ColumnInterface
    {
        $this->styles = array_merge($this->styles ?? [], $options);
        return $this;
    }

}
