<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 28.11.2019
 */

namespace Appus\Admin\Relations;

class HasOneRelation extends RelationAbstract
{

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->row->{$this->getRelation()}->{$this->getFieldName()} ?? '';
    }

    /**
     * @return array
     */
    public function saveValue(): array
    {
        $model = $this->row->{$this->getRelation()};
        if (null === $model) {
            $model = $this->row->{$this->getRelation()}()->newRelatedInstanceFor($this->row);
        }
        $model->{$this->getFieldName()} = request()->get($this->getFieldForSave());
        if (null !== $model->{$this->getFieldName()}) {
            return [
                get_class($model) => $model
            ];
        }
        $model->delete();
        return [];
    }

}
