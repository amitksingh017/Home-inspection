<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 13.03.2020
 */

namespace Appus\Admin\Form\Fields;

interface FieldRuleInterface
{

    /**
     * @param $rules
     * @return mixed
     */
    public function rules($rules);

    /**
     * @param $rules
     * @return mixed
     */
    public function creationRules($rules);

    /**
     * @param $rules
     * @return mixed
     */
    public function updatingRules($rules);

    /**
     * @return mixed
     */
    public function getCreationRules();

    /**
     * @return mixed
     */
    public function getUpdatingRules();

}
