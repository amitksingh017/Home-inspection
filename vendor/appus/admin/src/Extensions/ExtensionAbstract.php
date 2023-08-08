<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 12.03.2020
 */

namespace Appus\Admin\Extensions;

abstract class ExtensionAbstract
{

    protected $extensions = [];

    protected static $instances = [];

    private function __construct() {}

    private function __clone() {}

    public function __wakeup() {}

    /**
     * @return ExtensionAbstract
     */
    public static function getInstance(): ExtensionAbstract
    {
        $className = static::class;
        if (!isset(self::$instances[$className])) {
            self::$instances[$className] = new static;
        }
        return self::$instances[$className];
    }

    /**
     * @param string $alias
     * @param string $className
     */
    public function extend(string $alias, string $className)
    {
        $this->extensions[$alias] = $className;
    }

    /**
     * @param string $alias
     * @return string|null
     */
    public function getExtension(string $alias): ?string
    {
        return $this->extensions[$alias] ?? null;
    }

}
