<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 19.11.2019
 */

namespace Appus\Admin\Metrics;

use Appus\Admin\EncryptionService;

abstract class MetricAbstract implements MetricInterface
{

    protected $name;

    protected $width = 20;

    /**
     * @return string
     * @throws \Throwable
     */
    public function render(): string
    {
        return view('admin::metrics.index')->with([
            'name' => $this->getName(),
            'width' => $this->getWidth(),
            'key' => $this->getKey(),
            'filters' => $this->filters(),
        ])->render();
    }

    /**
     * @return string
     */
    public function getKey(): string
    {
        return EncryptionService::encrypt(get_class($this));
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        if (null === $this->name) {
            $this->name = get_class($this);
            $this->name = explode(substr('\/', 0, 1), $this->name);
            $this->name = array_reverse($this->name);
            $this->name = $this->name[0];
        }
        return $this->name;
    }

    /**
     * @param int $value
     * @return $this|MetricInterface
     */
    public function width(int $value): MetricInterface
    {
        $this->width = $value;
        return $this;
    }

    /**
     * @return int
     */
    public function getWidth(): int
    {
        $this->validateWidth();
        return $this->width;
    }

    /**
     * @return array
     */
    public function filters(): array
    {
        return [];
    }

    protected function validateWidth()
    {
        if ($this->width < 0) {
            $this->width = 100;
        }
        if ($this->width > 100) {
            $this->width = 100;
        }
    }

    /**
     * @param array $filter
     * @return string
     */
    abstract public function load(array $filter = []): string;

}
