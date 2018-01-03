<?php

namespace Sco\Admin\Form\Elements;

class Password extends Text
{
    protected $type = 'password';

    public function save()
    {
        $value = $this->getValueFromRequest();
        if ($this->getModel()->exists && empty($value)) {
            return;
        }
        $this->setModelAttribute($value);
    }

    public function getValidationRules()
    {
        $rules = parent::getValidationRules();
        if ($this->getModel()->exists) {
            foreach ($rules[$this->getName()] as $key => $rule) {
                if ($rule == 'required') {
                    unset($rules[$this->getName()][$key]);
                }
            }
        }

        return $rules;
    }

    public function getValue()
    {
        return '';
    }
}
