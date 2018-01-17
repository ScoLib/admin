<?php

namespace Sco\Admin\Form\Elements;

use Sco\Admin\Contracts\Validatable;

abstract class NamedElement extends Element implements Validatable
{
    protected $defaultValue = '';

    protected $validationRules = [];

    protected $validationMessages = [];

    public function required($message = null)
    {
        $this->addValidationRule('required', $message);

        return $this;
    }

    public function unique($message = null)
    {
        $this->addValidationRule('unique', $message);

        return $this;
    }

    public function getValidationRules()
    {
        $rules = array_merge(
            $this->getDefaultValidationRules(),
            $this->validationRules
        );

        if (isset($rules['unique']) && $rules['unique'] == 'unique') {
            $model = $this->getModel();
            $table = $model->getTable();

            $rule = 'unique:' . $table . ',' . $this->getName();
            if ($model->exists) {
                $rule .= ',' . $model->getKey() . ',' . $model->getKeyName();
            }
            $rules['unique'] = $rule;
        }

        return [$this->getName() => array_values($rules)];
    }

    protected function getDefaultValidationRules()
    {
        return [
            'bail' => 'bail',
        ];
    }

    /**
     * @return array
     */
    public function getValidationMessages()
    {
        return $this->validationMessages;
    }

    /**
     * Get validation custom attributes
     *
     * @return array
     */
    public function getValidationTitles()
    {
        return [$this->getName() => $this->getTitle()];
    }

    public function addValidationRule($rule, $message = null)
    {
        $this->validationRules[$this->getValidationRuleName($rule)] = $rule;

        if (is_null($message)) {
            return $this;
        }

        return $this->addValidationMessage($rule, $message);
    }

    public function addValidationMessage($rule, $message)
    {
        $key = $this->getName() . '.' . $this->getValidationRuleName($rule);

        $this->validationMessages[$key] = $message;

        return $this;
    }

    protected function getValidationRuleName($rule)
    {
        list($name, ) = explode(':', (string) $rule, 2);

        return $name;
    }
}
