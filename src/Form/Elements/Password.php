<?php

namespace Sco\Admin\Form\Elements;

class Password extends Text
{
    protected $type = 'password';

    protected $notRequired = false;

    public function save()
    {
        $value = $this->getValueFromRequest();

        // empty value don't save
        if (empty($value)) {
            return;
        }

        $this->setModelAttribute($value);
    }

    public function getValidationRules()
    {
        $rules = parent::getValidationRules();

        if ($this->isNotRequiredWithUpdate() && $this->getModel()->exists) {
            if (($key = array_search('required', $rules[$this->getName()])) !== false) {
                unset($rules[$this->getName()][$key]);
            }
        }

        return $rules;
    }

    public function getValue()
    {
        return '';
    }

    protected function hashAsBcrypt()
    {
        $this->setMutator(function ($value) {
            return bcrypt($value);
        });

        return $this;
    }

    protected function hashAsMD5()
    {
        $this->setMutator(function ($value) {
            return md5($value);
        });

        return $this;
    }

    protected function isNotRequiredWithUpdate()
    {
        return $this->notRequired;
    }

    public function notRequiredWithUpdate()
    {
        $this->notRequired = true;

        return $this;
    }
}
