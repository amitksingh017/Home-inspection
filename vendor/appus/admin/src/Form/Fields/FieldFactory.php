<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 31.10.2019
 */

namespace Appus\Admin\Form\Fields;

use Appus\Admin\Exceptions\InvalidTypeException;
use Appus\Admin\Extensions\Facades\FormFieldExtension;
use Appus\Admin\Fields\FieldFactoryAbstract;

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
        if (!$class instanceof FieldInterface || !$class instanceof FieldRuleInterface) {
            throw new InvalidTypeException(get_class($class) . ' does not implement ' . FieldInterface::class . ' and ' . FieldRuleInterface::class);
        }
        return true;
    }

    /**
     * @inheritDoc
     */
    protected static function getExtension(string $type): ?string
    {
        return FormFieldExtension::getExtension($type);
    }
}
