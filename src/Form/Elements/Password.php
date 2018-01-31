<?php

namespace Sco\Admin\Form\Elements;

class Password extends Text
{
    protected $type = 'password';

    public function __construct(string $name, string $title)
    {
        parent::__construct($name, $title);

        $this->hashAsBcrypt(); // default hash type
    }

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
}
