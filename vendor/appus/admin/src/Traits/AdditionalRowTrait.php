<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 29.01.2020
 */

namespace Appus\Admin\Traits;

use Appus\Admin\Details\Details;
use Appus\Admin\Exceptions\InvalidTypeException;
use Appus\Admin\Table\Table;

trait AdditionalRowTrait
{

    protected $additionalRowCallback;

    /**
     * @param \Closure $callback
     * @return $this
     */
    public function addRow(\Closure $callback)
    {
        $this->additionalRowCallback = $callback;
        return $this;
    }

    /**
     * @return bool
     */
    public function hasAdditionalRow(): bool
    {
        if (null !== $this->additionalRowCallback) {
            return true;
        }
        return false;
    }

    /**
     * @param $row
     * @return string
     * @throws \Throwable
     */
    public function getAdditionalRow($row): string
    {
        $callback = $this->additionalRowCallback;
        $additionalInfo = $callback($row);

        if (!$additionalInfo instanceof Table && !$additionalInfo instanceof Details) {
            throw new InvalidTypeException('Callback must return instance of Appus\Admin\Details\Details or Appus\Admin\Table\Table');
        }
        return $additionalInfo->render();
    }

}
