<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 04.11.2019
 */

namespace Appus\Admin\Form\Traits;

trait RulesTrait
{

    protected $creationRules;

    protected $updatingRules;

    /**
     * @param $rules
     * @return $this
     */
    public function rules($rules)
    {
        $this->creationRules = $rules;
        $this->updatingRules = $rules;
        return $this;
    }

    /**
     * @param $rules
     * @return $this
     */
    public function creationRules($rules)
    {
        $this->creationRules = $rules;
        return $this;
    }

    /**
     * @param $rules
     * @return $this
     */
    public function updatingRules($rules)
    {
        $this->updatingRules = $rules;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCreationRules()
    {
        return $this->creationRules;
    }

    /**
     * @return mixed
     */
    public function getUpdatingRules()
    {
        return $this->updatingRules;
    }

}
