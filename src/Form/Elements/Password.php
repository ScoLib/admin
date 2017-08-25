<?php

namespace Sco\Admin\Form\Elements;

use Illuminate\Http\Request;

class Password extends Text
{
    protected $type = 'password';

    public function save(Request $request)
    {
        $value = $this->getValueFromRequest($request);
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
