<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 30.10.2019
 */

namespace Appus\Admin\Details\Fields;

use Appus\Admin\Exceptions\InvalidTypeException;
use Appus\Admin\Extensions\Facades\DetailsFieldExtension;
use Appus\Admin\Fields\FieldFactoryAbstract;
use Appus\Admin\Fields\FieldInterface;

class FieldFactory extends FieldFactoryAbstract
{

    /**
     * @return string
     */
    protected static function getNamespace(): string
    {
        return __NAMESPACE__;
    }

    /**
     * @inheritDoc
     */
    protected static function check($class): bool
    {
        if (!$class instanceof FieldInterface) {
            throw new InvalidTypeException(get_class($class) . ' does not implement ' . FieldInterface::class);
        }
        return true;
    }

    /**
     * @inheritDoc
     */
    protected static function getExtension(string $type): ?string
    {
        return DetailsFieldExtension::getExtension($type);
    }
}
