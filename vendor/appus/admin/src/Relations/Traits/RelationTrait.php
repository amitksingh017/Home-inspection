<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 28.11.2019
 */

namespace Appus\Admin\Relations\Traits;

use Appus\Admin\Exceptions\UnknownRelationException;
use Appus\Admin\Relations\RelationFactory;
use Appus\Admin\Relations\RelationInterface;

trait RelationTrait
{

    /**
     * @return bool
     */
    public function checkRelation(): bool
    {
        return stristr($this->getField(), '.');
    }

    /**
     * @param $row
     * @return mixed
     * @throws UnknownRelationException
     */
    protected function getRelationValue($row)
    {
        $relation = $this->getRelation($row);
        return $relation->getValue();
    }

    /**
     * @param $row
     * @return array
     * @throws UnknownRelationException
     */
    protected function saveRelationValue($row): array
    {
        $relation = $this->getRelation($row);
        return $relation->saveValue();
    }

    /**
     * @param $row
     * @return RelationInterface
     * @throws UnknownRelationException
     */
    protected function getRelation($row)
    {
        $relationType = $this->getRelationType($row);
        return RelationFactory::factory($relationType, $this->getField(), $row);
    }

    /**
     * @param $row
     * @return string
     */
    protected function getRelationType($row): string
    {
        $relations = explode('.', $this->getField());
        if (count($relations) > 2) {
            return 'BelongsTo';
        }
        $relationName = $this->getRelationName();
        $class = get_class($row->{$relationName}());
        $class = explode(substr("\/", 0, 1), $class);
        $class = array_pop($class);
        return $class;
    }

    /**
     * @return string
     */
    protected function getRelationName(): string
    {
        return explode('.', $this->getField())[0];
    }

}
