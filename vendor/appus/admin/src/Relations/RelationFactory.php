<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 27.11.2019
 */

namespace Appus\Admin\Relations;

use Appus\Admin\Exceptions\UnknownRelationException;

class RelationFactory
{

    /**
     * @param string $type
     * @param string $field
     * @param $row
     * @return RelationInterface
     * @throws UnknownRelationException
     */
    public static function factory(string $type, string $field, $row): RelationInterface
    {
        $class = substr("\/", 0, 1) . __NAMESPACE__ . substr("\/", 0, 1) . $type . 'Relation';
        if (!class_exists($class)) {
            throw new UnknownRelationException('Relation ' . $class . ' does not exist');
        }
        return new $class($field, $row);
    }

}
