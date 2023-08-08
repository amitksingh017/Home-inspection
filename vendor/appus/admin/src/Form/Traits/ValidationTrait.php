<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 04.11.2019
 */

namespace Appus\Admin\Form\Traits;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;

trait ValidationTrait
{

    protected $validator;

    /**
     * @return array
     */
    protected function getValidationRules(): array
    {
        $fields = $this->getFields();
        $rules = [];
        $this->getRulesFromFields($fields, $rules);
        return $rules;
    }

    /**
     * @param array $fields
     * @param array $rules
     */
    protected function getRulesFromFields(array $fields, array &$rules)
    {
        $action = request()->get('_action', 'create');
        foreach ($fields as $field) {
            if (!$field->isColumn()) {
                if ('create' === $action) {
                    $actionRules = $field->getCreationRules();
                } elseif ('edit' === $action) {
                    $actionRules = $field->getUpdatingRules();
                }
                if (!empty($actionRules)) {
                    $this->addRules($field->getValidationField(), $actionRules, $rules);
                }
                continue;
            }
            $field->initFields();
            $this->getRulesFromFields($field->getFields(), $rules);
        }
    }

    /**
     * @param string $field
     * @param $actionRules
     * @param array $rules
     */
    protected function addRules(string $field, $actionRules, array &$rules)
    {
        if (is_string($actionRules)) {
            $actionRules = explode('|', $actionRules);
        }
        foreach ($actionRules as $rule) {

            if ($rule instanceof Rule) {
                $rules[$field][] = $rule;
                continue;
            }

            $rule = explode('=', $rule);
            $multiPrefix = isset($rule[1]) ? $rule[0] : '';
            $rule = isset($rule[1]) ? $rule[1] : $rule[0];
            $rules[$field . $multiPrefix][] = $rule;
        }
    }

    /**
     * @param array $params
     * @param array $rules
     */
    protected function validate(array $params, array $rules)
    {
        $this->validator = Validator::make($params, $rules);
    }

    /**
     * @return bool
     */
    protected function isValidated(): bool
    {
        return !$this->validator->fails();
    }

    /**
     * @return mixed
     */
    protected function getErrors()
    {
        return $this->validator->errors();
    }

    /**
     * @return RedirectResponse
     */
    protected function redirectValidationFails(): RedirectResponse
    {
        return redirect()->back()
            ->withErrors($this->validator)
            ->withInput();
    }

}
