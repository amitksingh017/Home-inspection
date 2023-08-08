<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 27.11.2019
 */

namespace Appus\Admin\Relations;

interface RelationInterface
{

    /**
     * RelationInterface constructor.
     * @param string $field
     * @param $row
     */
    public function __construct(string $field, $row);

    /**
     * @return mixed
     */
    public function getValue();

    /**
     * @return mixed
     */
    public function saveValue(): array;

}
