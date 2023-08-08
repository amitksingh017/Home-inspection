<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 30.10.2019
 */

namespace Appus\Admin\Fields;

use Appus\Admin\Exceptions\InvalidTypeException;
use Appus\Admin\Exceptions\UnknownFieldException;

abstract class FieldFactoryAbstract
{

    /**
     * @param string $type
     * @param $model
     * @param $field
     * @param null $name
     * @return mixed
     * @throws UnknownFieldException
     * @throws InvalidTypeException
     */
    public static function factory(string $type, $model, $field, $name = null)
    {
        $className = static::getNamespace() . substr("\/", 0, 1) . ucfirst($type) . 'Field';
        if (!class_exists($className)) {
            $className = static::getExtension($type);
        }
        if (null === $className) {
            throw new UnknownFieldException('Such Field Type does not exist');
        }
        $class = new $className($model, $field, $name);
        static::check($class);
        return $class;
    }

    /**
     * @return string
     */
    abstract protected static function getNamespace(): string;

    /**
     * @param $class
     * @throws InvalidTypeException
     * @return bool
     */
    abstract protected static function check($class): bool;

    /**
     * @param string $type
     * @return string|null
     */
    abstract protected static function getExtension(string $type): ?string;

}
