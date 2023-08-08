<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 27.11.2019
 */

namespace Appus\Admin\Relations;

class HasManyRelation extends RelationAbstract
{

    /**
     * @return mixed
     */
    public function getValue()
    {
        $relation = $this->row->{$this->getRelation()};
        $res = [];
        if ($relation->count() > 0) {
            $fieldName = $this->getFieldName();
            $relation = $relation->map(function($item) use ($fieldName) {
                return $item->{$fieldName};
            });
            $res = $relation->toArray();
        }
        return $res;
    }

    public function saveValue(): array
    {
        return [];
    }

}
