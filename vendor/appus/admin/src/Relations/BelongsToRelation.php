<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 27.11.2019
 */

namespace Appus\Admin\Relations;

class BelongsToRelation extends RelationAbstract
{

    /**
     * @return mixed
     */
    public function getValue()
    {
        $relations = $this->getKeys();
        $value = $this->row;
        foreach ($relations as $key) {
            $value = $value->{$key};
        }
        return $value;
    }

    public function saveValue(): array
    {
        return [];
    }

}
