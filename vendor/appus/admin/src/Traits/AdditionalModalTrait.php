<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 29.01.2020
 */

namespace Appus\Admin\Traits;

use Appus\Admin\Details\Details;
use Appus\Admin\Exceptions\InvalidTypeException;
use Appus\Admin\Table\Table;

trait AdditionalModalTrait
{

    protected $additionalModalCallback;

    /**
     * @param \Closure $callback
     * @return $this
     */
    public function addModal(\Closure $callback)
    {
        $this->additionalModalCallback = $callback;
        return $this;
    }

    /**
     * @return bool
     */
    public function hasAdditionalModal(): bool
    {
        if (null !== $this->additionalModalCallback) {
            return true;
        }
        return false;
    }

    /**
     * @param $row
     * @return string
     * @throws \Throwable
     */
    public function getAdditionalModal($row): string
    {
        $callback = $this->additionalModalCallback;
        $additionalInfo = $callback($row);
        if (!$additionalInfo instanceof Table && !$additionalInfo instanceof Details) {
            throw new InvalidTypeException('Callback must return instance of Appus\Admin\Details\Details or Appus\Admin\Table\Table');
        }
        return $additionalInfo->render();
    }

}
